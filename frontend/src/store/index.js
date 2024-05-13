import {createStore} from "vuex";
import createPersistedState from "vuex-persistedstate";

import state from "./state";
import * as getters from "./getters";
import * as mutations from "./mutations";
import * as actions from "./actions";
import permission from "@/store/modules/user_management/permission";
import roles from "@/store/modules/user_management/role";
import users from "@/store/modules/user_management/user";

const store = createStore({
    state,
    getters,
    mutations,
    actions,

    modules: {
        permission,
        roles,
        users
    },

    plugins: [
        createPersistedState({
            paths: ["token", "user", "permissions"]
        })
    ]
});

export default store;