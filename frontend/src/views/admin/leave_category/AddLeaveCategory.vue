<script>
import {mapState} from "vuex";
import router from "@/router";

export default {
  name: "AddLeaveCategory",

  data(){
    return{
      add_leave_category: {
        name: '',
        leave_total: '',
        status: ''
      }
    }
  },

  computed: {
    ...mapState({
      message: state => state.leaveCategory.success_message,
      errors: state => state.leaveCategory.errors,
      success_status: state => state.leaveCategory.success_status,
      error_status: state => state.leaveCategory.error_status
    })
  },

  methods: {
    addLeaveCategory: async function(){
      try {

        let formData = new FormData();

        formData.append('name', this.add_leave_category.name);
        formData.append('leave_total', this.add_leave_category.leave_total);
        formData.append('status', this.add_leave_category.status);

        await this.$store.dispatch('leaveCategory/StoreLeaveCategory', formData).then(() => {

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

              this.add_leave_category = {};

              setTimeout(function () {
                router.push({path: '/leave-category'});
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
  <div id="add_leave-category">
    <v-row class="mx-5 mt-5">
      <v-col cols="12">
        <v-row>
          <v-col cols="12" md="12" sm="12" lg="12">
            <v-card>
              <v-card-title><h3>Add Leave Category</h3></v-card-title>

              <v-divider></v-divider>

              <v-card-text>
                <v-form v-on:submit.prevent="addLeaveCategory">

                  <v-col cols="12">
                    <v-row wrap>
                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-text-field
                            type="text"
                            v-model="add_leave_category.name"
                            label="Leave category name"
                            persistent-hint
                            variant="outlined"
                            required
                        ></v-text-field>
                        <p v-if="errors.name" class="error custom_error">{{errors.name[0]}}</p>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-text-field
                            type="number"
                            :min="0"
                            v-model="add_leave_category.leave_total"
                            label="Total Leave Count"
                            persistent-hint
                            variant="outlined"
                            required
                        ></v-text-field>
                        <p v-if="errors.leave_total" class="error custom_error">{{errors.leave_total[0]}}</p>
                      </v-col>

                      <v-col cols="12" md="8" sm="12" lg="12">
                        <v-checkbox
                            type="checkbox"
                            v-model="add_leave_category.status"
                            label="Status"
                            persistent-hint
                            color="orange"
                            required
                        ></v-checkbox>
                        <p v-if="errors.status" class="error custom_error">{{errors.status[0]}}</p>
                      </v-col>
                    </v-row>

                    <v-row wrap>
                      <v-col cols="12" md="8" sm="12" lg="12" :class="['d-flex', 'justify-end']">
                        <v-btn
                            flat
                            color="primary"
                            class="custom-btn mr-2"
                            router
                            to="/leave-category"
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