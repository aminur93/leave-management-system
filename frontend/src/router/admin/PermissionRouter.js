import Permission from "@/views/admin/user_management/permission/Permission.vue";
import AddPermission from "@/views/admin/user_management/permission/AddPermission.vue";
import EditPermission from "@/views/admin/user_management/permission/EditPermission.vue";

export default [
    {
        path: '/dashboard/permission',
        name: 'Permission',
        component: Permission
    },
    {
        path: '/dashboard/add-permission',
        name: 'AddPermission',
        component: AddPermission
    },
    {
        path: '/dashboard/edit-permission/:id',
        name: 'EditPermission',
        component: EditPermission
    }
]