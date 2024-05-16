<script>
import {mapActions, mapState} from "vuex";
import router from "@/router";

export default {
  name: "AddLeave",

  data(){
    return{
      add_leave: {
        leave_category_id: null,
        title: '',
        start_date: '',
        end_date: '',
        description: ''
      }
    }
  },

  computed: {
    ...mapState({
      getLeaveCategories: state => state.leaveCategory.leaveCategories,
      message: state => state.leave.success_message,
      errors: state => state.leave.errors,
      success_status: state => state.leave.success_status,
      error_status: state => state.leave.error_status
    })
  },

  mounted() {
    this.getAllLeaveCategory();
  },

  methods: {
    ...mapActions({
        getAllLeaveCategory: "leaveCategory/GetAllLeaveCategory"
    }),
    
    addLeave: async function(){
      try {

        let formData = new FormData();

        formData.append('leave_category_id', this.add_leave.leave_category_id);
        formData.append('title', this.add_leave.title);
        formData.append('start_date', this.add_leave.start_date);
        formData.append('end_date', this.add_leave.end_date);
        formData.append('description', this.add_leave.description);

        await this.$store.dispatch("leave/StoreLeave", formData).then(() => {

          if (this.success_status === 201)
          {
            this.$swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: this.message,
              showConfirmButton: false,
              timer: 1500
            });

            this.add_leave = {};

            setTimeout(function () {
              router.push({path: '/leave'});
            },2000)
          }
        })

      }catch (e) {
        if (this.error_status === 422)
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
  <div id="add_leave">
    <v-row class="mx-5 mt-5">
      <v-col cols="12">
        <v-row>
          <v-col cols="12" md="12" sm="12" lg="12">
            <v-card>
              <v-card-title><h3>Add Leave</h3></v-card-title>

              <v-divider></v-divider>

              <v-card-text>
                <v-form v-on:submit.prevent="addLeave">
                  <v-col cols="12">
                    <v-row wrap>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-select
                            variant="outlined"
                            v-model="add_leave.leave_category_id"
                            :items="getLeaveCategories"
                            item-title="name"
                            item-value="id"
                            label="select Leave Category"
                        ></v-select>
                        <p v-if="errors.leave_category_id" class="error custom_error">{{errors.leave_category_id[0]}}</p>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-text-field
                            type="text"
                            v-model="add_leave.title"
                            label="Title"
                            persistent-hint
                            variant="outlined"
                            required
                        ></v-text-field>
                        <p v-if="errors.title" class="error custom_error">{{errors.title[0]}}</p>
                      </v-col>

                      <v-col cols="12" class="d-flex">
                        <v-row wrap>
                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="date"
                                v-model="add_leave.start_date"
                                label="Start Date"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.start_date" class="error custom_error">{{errors.start_date[0]}}</p>
                          </v-col>

                          <v-col cols="12" md="6" sm="6" lg="6">
                            <v-text-field
                                type="date"
                                v-model="add_leave.end_date"
                                label="End Date"
                                persistent-hint
                                variant="outlined"
                                required
                            ></v-text-field>
                            <p v-if="errors.end_date" class="error custom_error">{{errors.end_date[0]}}</p>
                          </v-col>
                        </v-row>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-textarea
                            v-model="add_leave.description"
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
                              class="custom-btn mr-2"
                              router
                              to="/leave"
                          >
                            Back
                          </v-btn>
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
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </div>
</template>

<style scoped>
.error{
  color: red;
}
</style>