<script>
import {mapState} from "vuex";
import {http} from "@/service/HttpService";

export default {
  name: "LeaveComment",

  data(){
    return{
      totalLeaveComments: 0,
      leaveComments: [],
      loading: true,
      options: {},
      search: '',
      headers: [
        { title: 'ID', key: 'id', sortable: false },
        { title: 'User name', key: 'user_id' },
        { title: 'Title', key: 'title' },
        { title: 'Comment', key: 'comment' },
        { title: 'Actions', key: 'actions', align: 'center', sortable: false },
      ],

      items: [
        { title: 'Review', 'id': 1 },
        { title: 'Pending', 'id': 2 },
        { title: 'Rejected', 'id': 3 },
        { title: 'Approved', 'id': 4 },
      ],
    }
  },

  computed: {
    startIndex() {
      let currentPage = this.options.page;
      let itemsPerPage = this.options.itemsPerPage;

      return (currentPage - 1) * itemsPerPage + 1;
    },

    ...mapState({
      message: state => state.leaveComment.success_message,
      errors: state => state.leaveComment.errors,
      success_status: state => state.leaveComment.success_status,
      error_status: state => state.leaveComment.error_status
    })
  },

  watch: {
    options: {
      handler () {
        this.getAllLeaveComment()
      },
      deep: true,
    },

    search: {
      handler () {
        this.getAllLeaveComment()
      },
    },
  },

  mounted() {
    this.getAllLeaveComment();
  },

  methods: {
    getAllLeaveComment(){
      this.loading = true

      const { sortBy, sortDesc, page, itemsPerPage } = this.options

      http().get('http://localhost:8000/api/v1/admin/leave-comment', {
        params: {
          sortBy: sortBy[0],
          sortDesc: sortDesc,
          page: page,
          itemsPerPage: itemsPerPage,
          search: this.search
        }
      }).then((result) => {
        this.leaveComments = result.data.data.data;
        this.totalLeaveComments = result.data.data.total;
        this.loading = false;
      }).catch((err) => {
        console.log(err);
      })
    },

    calculateIndex(item) {
      return this.startIndex + item;
    },

    deleteLeaveComment: async function(id){
      try {
        await this.$store.dispatch("leaveComment/DeleteLeaveComment", id).then(() => {
          if (this.success_status === 200)
          {
            this.$swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: this.message,
              showConfirmButton: false,
              timer: 1500
            });

            this.getAllLeaveComment();
          }
        })
      }catch (e) {
        this.$swal.fire({
          icon: 'error',
          text: 'Oops',
          title: 'Something wen wrong!!!',
        });
      }
    },
  }
}
</script>

<template>
  <div id="leave_comment">
    <v-row class="mx-5">

      <v-col cols="12" class="pa-6">

        <v-row wrap>
          <v-col cols="6">
            <h1 :class="['text-subtitle-2', 'text-grey', 'mt-5']">Leave Comments</h1>
          </v-col>
        </v-row>

        <v-row wrap>
          <v-col cols="12">
            <v-card elevation="8">
              <v-row>
                <v-col col="6">
                  <v-card-title :class="['text-subtitle-1']">All Leave Comments Lists</v-card-title>
                </v-col>

                <v-col cols="6"></v-col>
              </v-row>

              <v-divider></v-divider>

              <v-card-text>
                <v-card-title class="d-flex align-center pe-2" style="justify-content: space-between">

                  <h1 :class="['text-subtitle-1', 'text-black']">Leave Comments</h1>

                  <v-spacer></v-spacer>

                  <v-text-field
                      v-model="search"
                      density="compact"
                      label="Search"
                      prepend-inner-icon="mdi-magnify"
                      variant="solo-filled"
                      flat
                      hide-details
                      single-line
                  ></v-text-field>
                </v-card-title>


                <v-data-table-server
                    :headers="headers"
                    :items="leaveComments"
                    :search="search"
                    v-model:options="options"
                    :items-length="totalLeaveComments"
                    :loading="loading"
                    item-value="name"
                    class="elevation-4"
                    fixed-header
                >
                  <template v-slot:[`item.id`]="{ index }">
                    <td>{{ calculateIndex(index) }}</td>
                  </template>

                  <template v-slot:[`item.user_id`]="{ item }">
                    <td>{{ item.user.name }}</td>
                  </template>

                  <template v-slot:[`item.title`]="{ item }">
                    <td>{{ item.leave.title }}</td>
                  </template>

                  <template v-slot:[`item.actions`]="{ item }">
                    <v-row align="center" justify="center">
                      <td>
                        <v-btn color="red" icon="mdi-delete" size="x-small" @click="deleteLeaveComment(item.id)"></v-btn>
                      </td>
                    </v-row>
                  </template>
                </v-data-table-server>

              </v-card-text>

            </v-card>
          </v-col>
        </v-row>

      </v-col>
    </v-row>
  </div>
</template>

<style scoped>

</style>