export const ADD_REGISTER = (state, data) => {
    state.success_message = data.message;
    state.success_status = data.status;
};