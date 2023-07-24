import {createRouter, createWebHistory} from 'vue-router/dist/vue-router.esm-bundler';
import Start from "./views/Start.vue";

const routes = [
    {
        path: '/',
        component: Start,
        name: 'home',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

export default router;
