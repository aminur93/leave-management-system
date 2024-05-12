import Role from "@/views/admin/user_management/role/Role.vue";
import AddRole from "@/views/admin/user_management/role/AddRole.vue";
import EditRole from "@/views/admin/user_management/role/EditRole.vue";

export default [
    {
        path: '/role',
        name: 'Role',
        component: Role
    },

    {
        path: '/add-role',
        name: 'AddRole',
        component: AddRole
    },

    {
        path: '/edit-role/:id',
        name: 'EditRole',
        component: EditRole
    }
]