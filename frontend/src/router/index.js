import { createWebHistory, createRouter} from "vue-router";
import AuthRouter from "@/router/auth/AuthRouter";
import AdminRouter from "@/router/admin/AdminRouter";
import CommonRouter from "@/router/CommonRouter";

const routes = [
    ...CommonRouter,
    ...AuthRouter,
    ...AdminRouter
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;