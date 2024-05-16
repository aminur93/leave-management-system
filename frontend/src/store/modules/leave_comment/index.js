/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
//import {http} from "@/service/HttpService";

import {http} from "@/service/HttpService";

const state = {
    leaveComments: [],
    leaveComment: {},
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
    STORE_LEAVE_COMMENT: (state, data) => {
        if (state.leaveComments.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }else {
            state.success_message = '';
        }
    },

    GET_SINGLE_LEAVE_COMMENT: (state, data) => {
        state.leaveComment = data;
    },

    UPDATE_LEAVE_COMMENT: (state, data) => {
        if (state.leaveComments.push(data.data))
        {
            state.success_message = data.data.message;
            state.success_status = data.status;
        }
    },
}

/* -------------------------------------------------------------------------- */
/*                               Actions Define                               */
/* -------------------------------------------------------------------------- */
const actions = {
    /*store leave start*/
    StoreLeave: ({commit}, data) => {
        return http()
            .post("v1/admin/leave-comment", data)
            .then((result) => {
                commit("STORE_LEAVE_COMMENT", result);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*store leave end*/

    /*get single leave category start*/
    GetSingleLeave: ({commit}, id) => {
        return http()
            .get(`v1/admin/leave-comment/${id}`)
            .then((result) => {
                commit("GET_SINGLE_LEAVE_COMMENT", result.data.data);
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
    UpdateLeave: ({commit}, {id, data}) => {
        return http()
            .put(`v1/admin/leave-comment/${id}`, data)
            .then((result) => {
                commit("UPDATE_LEAVE_COMMENT", result);
            })
            .catch((err) => {
                const errors = err.response.data.errors;
                const errorStatus = err.response.status;
                commit("SET_ERROR", { errors, errorStatus });
                throw err;
            })
    },
    /*update leave category end*/
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