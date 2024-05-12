import Dashboard from "@/views/admin/Dashboard.vue";
import store from "@/store";
import Master from "@/views/admin/Master.vue";
import PermissionRouter from "@/router/admin/PermissionRouter";
import RoleRouter from "@/router/admin/RoleRouter";
import UserRouter from "@/router/admin/UserRouter";
import LeaveCategoryRouter from "@/router/admin/LeaveCategoryRouter";
import LeaveRouter from "@/router/admin/LeaveRouter";
import LeaveCommentRouter from "@/router/admin/LeaveCommentRouter";

export default [
    {
        path: '/dashboard',
        component: Master,
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: Dashboard,
            },

            ...PermissionRouter,
            ...RoleRouter,
            ...UserRouter,
            ...LeaveCategoryRouter,
            ...LeaveRouter,
            ...LeaveCommentRouter
        ],
        beforeEnter(to, from, next){
            if (!store.getters['AuthToken'])
            {
                next({name: 'Login'});
            }else {
                next();
            }
        }
    }
]