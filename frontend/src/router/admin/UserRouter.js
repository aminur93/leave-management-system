import User from "@/views/admin/user_management/user/User.vue";
import AddUser from "@/views/admin/user_management/user/AddUser.vue";
import EditUser from "@/views/admin/user_management/user/EditUser.vue";

export default [

    {
        path: '/user',
        name: 'User',
        component: User
    },

    {
        path: '/add-user',
        name: 'AddUser',
        component: AddUser
    },

    {
        path: '/edit-user/:id',
        name: 'EditUser',
        component: EditUser
    }
]