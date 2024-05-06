import { createWebHistory, createRouter} from "vue-router";
import AuthRouter from "@/router/auth/AuthRouter";

const routes = [
    ...AuthRouter
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;