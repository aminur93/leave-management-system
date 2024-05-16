<script>
import {mapState} from "vuex";

export default {
  name: "AddLeaveComment",

  data(){
    return{
      add_leave_comment: {
        comment: ''
      }
    }
  },

  computed: {
    ...mapState({
      message: state => state.leave.success_message,
      errors: state => state.leave.errors,
      success_status: state => state.leave.success_status,
      error_status: state => state.leave.error_status
    })
  },
}
</script>

<template>
  <div id="add_leave_comment">
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
                        <v-textarea
                            v-model="add_leave_comment.comment"
                            label="Description"
                            variant="outlined"
                        ></v-textarea>
                        <p v-if="errors.comment" class="error custom_error">{{errors.comment[0]}}</p>
                      </v-col>

                      <v-row wrap>
                        <v-col cols="12" md="8" sm="12" lg="12" :class="['d-flex', 'justify-end']">
                          <v-btn
                              flat
                              color="primary"
                              class="custom-btn mr-2"
                              router
                              to="/leave-comment"
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

</style>