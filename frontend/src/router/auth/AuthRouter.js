import Register from "@/views/auth/Register.vue";
import Login from "@/views/auth/Login.vue";

export default [
    {
        path: '/',
        name: 'Login',
        component: Login
    },
    {
        path: '/register',
        name: 'Register',
        component: Register
    }
]