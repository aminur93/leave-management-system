import Leave from "@/views/admin/leave/Leave.vue";
import AddLeave from "@/views/admin/leave/AddLeave.vue";
import EditLeave from "@/views/admin/leave/EditLeave.vue";

export default [

    {
        path: '/leave',
        name: 'Leave',
        component: Leave
    },

    {
        path: '/add-leave',
        name: 'AddLeave',
        component: AddLeave
    },

    {
        path: '/edit-leave/:id',
        name: 'EditLeave',
        component: EditLeave
    }
]