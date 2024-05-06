import {http} from "@/service/HttpService";

export const register = ({commit, state}, data) => {

    return http().post('v1/auth/register', data).then((result) => {
        commit("ADD_REGISTER", result.data);
    }).catch((err) => {
        state.errors = err.response.data.errors;
        state.error_status = err.response.status;
    })
};