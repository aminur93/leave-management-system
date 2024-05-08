import Dashboard from "@/views/admin/Dashboard.vue";
import store from "@/store";
import Master from "@/views/admin/Master.vue";

export default [
    {
        path: '/dashboard',
        component: Master,
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: Dashboard
            }
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