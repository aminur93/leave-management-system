import Permission from "@/views/admin/user_management/permission/Permission.vue";
import AddPermission from "@/views/admin/user_management/permission/AddPermission.vue";
import EditPermission from "@/views/admin/user_management/permission/EditPermission.vue";

export default [
    {
        path: '/permission',
        name: 'Permission',
        component: Permission
    },
    {
        path: '/add-permission',
        name: 'AddPermission',
        component: AddPermission
    },
    {
        path: '/edit-permission/:id',
        name: 'EditPermission',
        component: EditPermission
    }
]