import LeaveCategory from "@/views/admin/leave_category/LeaveCategory.vue";
import AddLeaveCategory from "@/views/admin/leave_category/AddLeaveCategory.vue";
import EditLeaveCategory from "@/views/admin/leave_category/EditLeaveCategory.vue";

export default [

    {
        path: '/leave-category',
        name: 'LeaveCategory',
        component: LeaveCategory
    },

    {
        path: '/add-leave-category',
        name: 'AddLeaveCategory',
        component: AddLeaveCategory
    },

    {
        path: '/edit-leave-category/:id',
        name: 'EditLeaveCategory',
        component: EditLeaveCategory
    }
]