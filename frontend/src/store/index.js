import {createStore} from "vuex";
import createPersistedState from "vuex-persistedstate";

/*root import start*/
import state from "./state";
import * as getters from "./getters";
import * as mutations from "./mutations";
import * as actions from "./actions";
/*root import end*/

/*module import start*/
import permission from "@/store/modules/user_management/permission";
import roles from "@/store/modules/user_management/role";
import users from "@/store/modules/user_management/user";
import leaveCategory from "@/store/modules/leave_category";
import leave from "@/store/modules/leave";
import leaveComment from "@/store/modules/leave_comment";
/*module import end*/

const store = createStore({
    state,
    getters,
    mutations,
    actions,

    modules: {
        permission,
        roles,
        users,
        leaveCategory,
        leave,
        leaveComment
    },

    plugins: [
        createPersistedState({
            paths: ["token", "user", "permissions"]
        })
    ]
});

export default store;