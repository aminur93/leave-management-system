<script>
import {mapState} from "vuex";
import {http} from "@/service/HttpService";

export default {
  name: "LeaveManagement",

  data(){
    return{
      totalLeaves: 0,
      leaves: [],
      loading: true,
      options: {},
      search: '',
      headers: [
        { title: 'ID', key: 'id', sortable: false },
        { title: 'User name', key: 'user_id' },
        { title: 'Leave Category', key: 'leave_category_id' },
        { title: 'Title', key: 'title' },
        { title: 'Start Date', key: 'start_date' },
        { title: 'End Date', key: 'end_date' },
        { title: 'Total Days', key: 'total_days' },
        { title: 'Status', key: 'status' },
        { title: 'Actions', key: 'actions', align: 'center', sortable: false },
      ],

      items: [
        { title: 'Review', 'id': 1 },
        { title: 'Pending', 'id': 2 },
        { title: 'Rejected', 'id': 3 },
        { title: 'Approved', 'id': 4 },
      ],

      dialog: false,

      add_comment: {
        leave_id: '',
        comment: ''
      }
    }
  },

  computed: {
    startIndex() {
      let currentPage = this.options.page;
      let itemsPerPage = this.options.itemsPerPage;

      return (currentPage - 1) * itemsPerPage + 1;
    },

    ...mapState({
      message: state => state.leave.success_message,
      errors: state => state.leave.errors,
      success_status: state => state.leave.success_status,
      error_status: state => state.leave.error_status,

      commentMessage: state => state.leaveComment.success_message,
      commentErrors: state => state.leaveComment.errors,
      commentSuccess_status: state => state.leaveComment.success_status,
      commentError_status: state => state.leaveComment.error_status
    })
  },

  watch: {
    options: {
      handler () {
        this.getAllLeave()
      },
      deep: true,
    },

    search: {
      handler () {
        this.getAllLeave()
      },
    },
  },

  mounted() {
    this.getAllLeave();
  },

  methods: {
    getAllLeave(){
      this.loading = true

      const { sortBy, sortDesc, page, itemsPerPage } = this.options

      http().get('http://localhost:8000/api/v1/admin/leave', {
        params: {
          sortBy: sortBy[0],
          sortDesc: sortDesc,
          page: page,
          itemsPerPage: itemsPerPage,
          search: this.search
        }
      }).then((result) => {
        this.leaves = result.data.data.data;
        this.totalLeaves = result.data.data.total;
        this.loading = false;
      }).catch((err) => {
        console.log(err);
      })
    },

    calculateIndex(item) {
      return this.startIndex + item;
    },

    deleteLeave: async function(id){
      try {
        await this.$store.dispatch("leave/DeleteLeave", id).then(() => {
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

            this.getAllLeave();
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

    changeStatus: async function({id, data}){
      try {

        let formData = new FormData();

        formData.append('status', data);

        await this.$store.dispatch("leave/statusChange", {id:id, data: formData}).then(() => {
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

            this.getAllLeave();
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

    openDialog(leave_id){
      this.dialog = true;
      this.add_comment.leave_id = leave_id;
    },

    DialogClose(){
      this.dialog = false;
      this.add_comment = {};
    },

    addComment: async function(){

      try {

        let formData = new FormData();

        formData.append('leave_id', this.add_comment.leave_id);
        formData.append('comment', this.add_comment.comment);

        await this.$store.dispatch("leaveComment/StoreLeave", formData).then(() => {
          if (this.commentSuccess_status === 201)
          {
            this.$swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: this.commentMessage,
              showConfirmButton: false,
              timer: 1500
            });

            this.add_comment = {};
            this.dialog = false;
          }
        })
      }catch (e) {
        if (this.commentError_status === 422)
        {
          console.log('error');
        }else {
          this.$swal.fire({
            icon: 'error',
            text: 'Oops',
            title: 'Something wen wrong!!!',
          });
        }
      }
    }
  }
}
</script>

<template>
  <div id="leave">
    <v-row class="mx-5">

      <v-col cols="12" class="pa-6">

        <v-row wrap>
          <v-col cols="6">
            <h1 :class="['text-subtitle-2', 'text-grey', 'mt-5']">Leave</h1>
          </v-col>
        </v-row>

        <v-row wrap>
          <v-col cols="12">
            <v-card elevation="8">
              <v-row>
                <v-col col="6">
                  <v-card-title :class="['text-subtitle-1']">All Leave Lists</v-card-title>
                </v-col>

                <v-col cols="6">
                  <v-card-actions class="justify-end">
                    <v-btn color="success" router to="/add-leave">
                      <v-icon small left>mdi-plus</v-icon>
                      <span>Add New</span>
                    </v-btn>
                  </v-card-actions>
                </v-col>
              </v-row>

              <v-divider></v-divider>

              <v-card-text>
                <v-card-title class="d-flex align-center pe-2" style="justify-content: space-between">

                  <h1 :class="['text-subtitle-1', 'text-black']">Leave</h1>

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
                    :items="leaves"
                    :search="search"
                    v-model:options="options"
                    :items-length="totalLeaves"
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

                  <template v-slot:[`item.leave_category_id`]="{ item }">
                    <td>{{ item.leave_category.name }}</td>
                  </template>

                  <template v-slot:[`item.status`]="{ item }">
                    <td>
                      <v-menu>
                        <template v-slot:activator="{ props }">
                          <div v-if="item.status === 0">
                            <v-btn icon="mdi-dots-vertical" v-bind="props"></v-btn>
                          </div>

                          <div v-if="item.status === 1" class="custom_button">
                            <v-btn variant="tonal" color="primary" v-bind="props">Review</v-btn>
                          </div>

                          <div v-if="item.status === 2" class="custom_button">
                            <v-btn variant="tonal" color="purple-darken-4" v-bind="props">Pending</v-btn>
                          </div>

                          <div v-if="item.status === 3" class="custom_button">
                            <v-btn variant="tonal" color="red-darken-4" v-bind="props">Rejected</v-btn>
                          </div>

                          <div v-if="item.status === 4" class="custom_button">
                            <v-btn variant="tonal" color="green-darken-4" v-bind="props">Approved</v-btn>
                          </div>

                        </template>

                        <v-list>
                          <v-list-item
                              v-for="(ite, i) in items"
                              :key="i"
                              @click="changeStatus({id:item.id, data: ite.id})"
                          >
                            <v-list-item-title style="cursor: pointer">{{ ite.title }}</v-list-item-title>
                          </v-list-item>
                        </v-list>
                      </v-menu>
                    </td>
                  </template>


                  <template v-slot:[`item.actions`]="{ item }">
                    <v-row align="center" justify="center">
                      <td :class="['mx-1']">
                        <v-btn color="warning" icon="mdi-pencil" size="x-small" router :to="`/edit-leave/${item.id}`"></v-btn>
                      </td>

                      <td :class="['mx-1']">
                          <v-btn
                              color="cyan-darken-4"
                              icon="mdi-comment"
                              size="x-small"
                              @click="openDialog(item.id)"
                          ></v-btn>

                        <v-dialog max-width="500" v-model="dialog">
                            <v-card title="Add Comment">
                              <v-card-text>
                                <v-form v-on:submit.prevent="addComment">
                                  <v-col cols="12">
                                    <v-row wrap>

                                      <v-col cols="12" md="8" sm="12" lg="12">
                                        <v-text-field
                                            type="text"
                                            :model-value="item.title"
                                            label="Leave Title"
                                            persistent-hint
                                            variant="outlined"
                                            required
                                        ></v-text-field>
                                      </v-col>

                                      <v-col cols="12" md="8" sm="12" lg="12">
                                        <v-textarea
                                            v-model="add_comment.comment"
                                            label="Description"
                                            variant="outlined"
                                        ></v-textarea>
                                        <p v-if="errors.description" class="error custom_error">{{errors.description[0]}}</p>
                                      </v-col>

                                      <v-row wrap>
                                        <v-col cols="12" md="8" sm="12" lg="12" :class="['d-flex', 'justify-end']">
                                          <v-btn
                                              flat
                                              color="primary"
                                              text="Close"
                                              class="custom-btn mr-2"
                                              @click="DialogClose"
                                          ></v-btn>

                                          <v-btn
                                              flat
                                              color="success"
                                              type="submit"
                                              class="custom-btn mr-2"
                                          >
                                            Submit
                                          </v-btn>
                                        </v-col>
                                      </v-row>
                                    </v-row>
                                  </v-col>
                                </v-form>
                              </v-card-text>
                            </v-card>
                        </v-dialog>
                      </td>

                      <td>
                        <v-btn color="red" icon="mdi-delete" size="x-small" @click="deleteLeave(item.id)"></v-btn>
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
.custom_button{
  margin-left: -10px;
}
</style>