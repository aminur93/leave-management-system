/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
import {http} from "@/service/HttpService";

const state = {
    leaveCategories: [],
    leaveCategory: {},
    success_message: "",
    errors: {},
    error_message: "",
    error_status: "",
    success_status: "",
}

/* -------------------------------------------------------------------------- */
/*                              Mutations Define                              */
/* -------------------------------------------------------------------------- */
const mutations = {

    GET_ALL_LEAVE_CATEGORY: (state, data) => {
        state.leaveCategories = data;
    },

    STORE_LEAVE_CATEGORY: (state, data) => {
        if (state.leaveCategories.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }else {
            state.success_message = '';
        }
    },

    GET_SINGLE_LEAVE_CATEGORY: (state, data) => {
        state.leaveCategory = data;
    },

    UPDATE_LEAVE_CATEGORY: (state, data) => {
        if (state.leaveCategories.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    DELETE_LEAVE_CATEGORY: (state, {id, data}) => {
        if (id)
        {
            state.leaveCategories = state.leaveCategories.filter(item => {
                return item.id !== id;
            })

            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },

    STATUS_CHANGE_LEAVE_CATEGORY: (state, data) => {
        state.success_message = data.data.message;
        state.success_status = data.status;
    },

    SET_ERROR(state, { errors, errorStatus }) {
        state.errors = errors;
        state.error_status = errorStatus;
    }
}

/* -------------------------------------------------------------------------- */
/*                               Actions Define                               */
/* -------------------------------------------------------------------------- */
const actions = {

    /*get all leave categories start*/
    async GetAllLeaveCategory({ commit }) {
        try {
            const result = await http().get("v1/admin/leave-category", {
                params: {
                    pagination: false
                }
            });
            commit("GET_ALL_LEAVE_CATEGORY", result.data.data);
        } catch (err) {
            const errors = err.response.data.errors;
            const errorStatus = err.response.status;
            commit("SET_ERROR", { errors, errorStatus });
            throw err; // Re-throw the error to propagate it to the caller
        }
    },
    /*get all leave categories end*/

    /*store leave category start*/
    StoreLeaveCategory: ({commit}, data) => {
        return http()
            .post("v1/admin/leave-category", data)
            .then((result) => {
                commit("STORE_LEAVE_CATEGORY", result);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*store leave category end*/

    /*get single leave category start*/
    GetSingleLeaveCategory: ({commit}, id) => {
        return http()
            .get(`v1/admin/leave-category/${id}`)
            .then((result) => {
                commit("GET_SINGLE_LEAVE_CATEGORY", result.data.data);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*get single leave category end*/

    /*update leave category start*/
    UpdateLeaveCategory: ({commit}, {id, data}) => {
        return http()
            .put(`v1/admin/leave-category/${id}`, data)
            .then((result) => {
                commit("UPDATE_LEAVE_CATEGORY", result);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*update leave category end*/

    /*destroy leave category start*/
    DeleteLeaveCategory: ({commit}, id) => {
        return http()
            .delete(`v1/admin/leave-category/${id}`)
            .then((result) => {
                commit("DELETE_LEAVE_CATEGORY", {id:id, data:result});
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*destroy leave category end*/

    /*status change start*/
    statusChange: ({commit}, id) => {
        return http()
            .post(`v1/admin/leave-category/status/${id}`)
            .then((result) => {
                commit("STATUS_CHANGE_LEAVE_CATEGORY", result);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    }
    /*status change end*/
}

/* -------------------------------------------------------------------------- */
/*                               Getters Define                               */
/* -------------------------------------------------------------------------- */
const getters = {}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}