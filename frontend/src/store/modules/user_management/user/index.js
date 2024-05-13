/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
import {http} from "@/service/HttpService";

const state = {
    users: [],
    user: {},
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
    GET_ALL_USER: (state, data) => {
        state.users = data;
    },

    STORE_USER: (state, data) => {
        if (state.users.push(data.data)) {
            state.success_message = data.data.message;
            state.success_status = data.status;
        } else {
            state.success_message = "";
        }
    },

    GET_SINGLE_USER: (state, data) => {
        state.user = data;
    },

    UPDATE_USER: (state, data) => {
        if (state.users.push(data.data)) {
            state.success_message = data.data.message;
            state.success_status = data.status;
        } else {
            state.success_message = "";
        }
    },

    DELETE_USER: (state, {id, data}) => {
        if (id) {
            state.menus = state.users.filter((item) => {
                return id !== item.id;
            });

            state.success_message = data.message;
            state.success_status = data.status;
        } else {
            state.success_message = "";
        }
    }
}

/* -------------------------------------------------------------------------- */
/*                               Actions Define                               */
/* -------------------------------------------------------------------------- */
const actions = {

    /*get all users start*/
    async GetAllUser({ commit }) {
        try {
            const result = await http().get("v1/admin/user", {
                params: {
                    pagination: false
                }
            });
            commit("GET_ALL_USER", result.data.data);
        } catch (err) {
            // Handle errors properly, considering Vuex store structure
            state.errors = err.response.data.errors;
            state.error_status = err.response.status;
        }
    },
    /*get all users end*/

    /*store user start*/
    StoreUser: ({commit}, data) => {
        return http()
            .post('v1/admin/user', data)
            .then((result) => {
                commit("STORE_USER", result);
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    },
    /*store user end*/

    /*get single user start*/
    GetSingleUser: ({commit}, id) => {
        return http()
            .get(`v1/admin/user/${id}`)
            .then((result) => {
                commit("GET_SINGLE_USER", result.data.data);
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    },
    /*get single user end*/

    /*update user start*/
    UpdateUser: ({commit}, {id, data}) => {
        return http()
            .put(`v1/admin/user/${id}`, data)
            .then((result) => {
                commit("UPDATE_USER", result);
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    },
    /*update user end*/

    /*destroy user start*/
    DeleteUser: ({commit}, id) => {
        return http()
            .delete(`v1/admin/user/${id}`)
            .then((result) => {
                commit("DELETE_USER", {id:id, data:result});
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    }
    /*destroy user end*/
}

/* -------------------------------------------------------------------------- */
/*                               Getters Define                               */
/* -------------------------------------------------------------------------- */
const getters = {

}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}