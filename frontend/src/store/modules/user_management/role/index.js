/* -------------------------------------------------------------------------- */
/*                                states Define                               */
/* -------------------------------------------------------------------------- */
import {http} from "@/service/HttpService";

const state = {
    roles: [],
    role: {},
    rolePermission: [],
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
    GET_ALL_ROLE: (state, data) => {
        state.roles = data;
    },

    STORE_ROLE: (state, data) => {
        if (state.roles.push(data.data)) {
            state.success_message = data.data.message;
            state.success_status = data.status;
        } else {
            state.success_message = "";
        }
    },

    GET_SINGLE_ROLE: (state, data) => {
        state.role = data.role;
        state.rolePermission = data.role_permission;
    },

    UPDATE_VALUE: (state, data) => {
        state.rolePermission = data;
    },

    UPDATE_ROLE: (state, data) => {
        if (state.roles.push(data.data)) {
            state.success_message = data.data.message;
            state.success_status = data.status;
        } else {
            state.success_message = "";
        }
    },

    DELETE_ROLE: (state, {id, data}) => {
        if (id) {
            state.menus = state.roles.filter((item) => {
                return id !== item.id;
            });

            state.success_message = data.message;
            state.success_status = data.status;
        } else {
            state.success_message = "";
        }
    }
};

/* -------------------------------------------------------------------------- */
/*                               Actions Define                               */
/* -------------------------------------------------------------------------- */
const actions = {
    /*Get all roles start*/
    async GetAllRole({ commit }) {
        try {
            const result = await http().get("v1/admin/role", {
                params: {
                    pagination: false
                }
            });
            commit("GET_ALL_ROLE", result.data.data);
        } catch (err) {
            // Handle errors properly, considering Vuex store structure
            state.errors = err.response.data.errors;
            state.error_status = err.response.status;
        }
    },
    /*Get all roles end*/

    /*Store role start*/
    StoreRole: ({commit}, data) => {
        return http()
            .post("v1/admin/role", data)
            .then((result) => {
                commit("STORE_ROLE", result);
                return result
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    },
    /*Store role end*/

    /*edit role start*/
    editRole: ({commit}, id) => {
        return http()
            .get(`v1/admin/role/${id}`)
            .then((result) => {
                commit("GET_SINGLE_ROLE", result.data.data);
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    },
    /*edit role end*/

    /*update role start*/
    UpdateRole: ({commit}, {id, data}) => {
        return http()
            .put(`v1/admin/role/${id}`, data)
            .then((result) => {
                commit("UPDATE_ROLE", result);
                return result
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    },
    /*update role end*/

    /*destroy role start*/
    DeleteRole: ({commit}, id) => {
        return http()
            .delete(`v1/admin/role/${id}`)
            .then((result) => {
                commit("DELETE_ROLE", { id: id, data: result.data });
            })
            .catch((err) => {
                state.errors = err.response.data.errors;
                state.error_status = err.response.status;
            })
    }
    /*destroy role end*/
};

/* -------------------------------------------------------------------------- */
/*                               Getters Define                               */
/* -------------------------------------------------------------------------- */
const getters = {
    rolePermissions: (state) => {
        return state.rolePermission;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}