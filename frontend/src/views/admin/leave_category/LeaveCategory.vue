<script>
import {mapState} from "vuex";
import {http} from "@/service/HttpService";

export default {
  name: "LeaveCategory",

  data(){
    return{
      totalLeaveCategories: 0,
      leaveCategories: [],
      loading: true,
      options: {},
      search: '',
      headers: [
        { title: 'ID', key: 'id', sortable: false },
        { title: 'Name', key: 'name' },
        { title: 'Leave Total', key: 'leave_total' },
        { title: 'Status', key: 'status' },
        { title: 'Actions', key: 'actions', align: 'center', sortable: false },
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
      message: state => state.leaveCategory.success_message,
      errors: state => state.leaveCategory.errors,
      success_status: state => state.leaveCategory.success_status,
      error_status: state => state.leaveCategory.error_status
    })
  },

  watch: {
    options: {
      handler () {
        this.getAllLeaveCategories()
      },
      deep: true,
    },

    search: {
      handler () {
        this.getAllLeaveCategories()
      },
    },
  },

  mounted() {
    this.getAllLeaveCategories();
  },

  methods: {
    getAllLeaveCategories(){
      this.loading = true

      const { sortBy, sortDesc, page, itemsPerPage } = this.options

      http().get('http://localhost:8000/api/v1/admin/leave-category', {
        params: {
          sortBy: sortBy[0],
          sortDesc: sortDesc,
          page: page,
          itemsPerPage: itemsPerPage,
          search: this.search
        }
      }).then((result) => {
        this.leaveCategories = result.data.data.data;
        this.totalLeaveCategories = result.data.data.total;
        this.loading = false;
      }).catch((err) => {
        console.log(err);
      })
    },

    calculateIndex(item) {
      return this.startIndex + item;
    },

    deleteLeaveCategory: async function(id){
      try {
        await this.$store.dispatch("leaveCategory/DeleteLeaveCategory", id).then(() => {
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

            this.getAllLeaveCategories();
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

    changeStatus: async function(id){
      try {
        await this.$store.dispatch("leaveCategory/statusChange", id).then(() => {
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

            this.getAllLeaveCategories();
          }
        })
      }catch (e) {
        this.$swal.fire({
          icon: 'error',
          text: 'Oops',
          title: 'Something wen wrong!!!',
        });
      }
    }
  }
}
</script>

<template>
  <div id="leave_category">
    <v-row class="mx-5">

      <v-col cols="12" class="pa-6">

        <v-row wrap>
          <v-col cols="6">
            <h1 :class="['text-subtitle-2', 'text-grey', 'mt-5']">Leave Category</h1>
          </v-col>
        </v-row>

        <v-row wrap>
          <v-col cols="12">
            <v-card elevation="8">
              <v-row>
                <v-col col="6">
                  <v-card-title :class="['text-subtitle-1']">All Leave Category Lists</v-card-title>
                </v-col>

                <v-col cols="6">
                  <v-card-actions class="justify-end">
                    <v-btn color="success" router to="/add-leave-category">
                      <v-icon small left>mdi-plus</v-icon>
                      <span>Add New</span>
                    </v-btn>
                  </v-card-actions>
                </v-col>
              </v-row>

              <v-divider></v-divider>

              <v-card-text>
                <v-card-title class="d-flex align-center pe-2" style="justify-content: space-between">

                  <h1 :class="['text-subtitle-1', 'text-black']">Leave Category</h1>

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
                    :items="leaveCategories"
                    :search="search"
                    v-model:options="options"
                    :items-length="totalLeaveCategories"
                    :loading="loading"
                    item-value="name"
                    class="elevation-4"
                    fixed-header
                >
                  <template v-slot:[`item.id`]="{ index }">
                    <td>{{ calculateIndex(index) }}</td>
                  </template>

                  <template v-slot:[`item.status`]="{ item }">
                    <td>
                        <v-switch
                            :model-value="item.status === 1 ? true : false"
                            color="primary"
                            @click.prevent="changeStatus(item.id)"
                        ></v-switch>
                    </td>
                  </template>


                  <template v-slot:[`item.actions`]="{ item }">
                    <v-row align="center" justify="center">
                      <td :class="['mx-2']">
                        <v-btn color="warning" icon="mdi-pencil" size="x-small" router :to="`/edit-leave-category/${item.id}`"></v-btn>
                      </td>

                      <td>
                        <v-btn color="red" icon="mdi-delete" size="x-small" @click="deleteLeaveCategory(item.id)"></v-btn>
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