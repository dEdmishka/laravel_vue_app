import {createRouter, createWebHistory} from 'vue-router/dist/vue-router.esm-bundler';
import Start from "./views/Start.vue";
import NewsFeed from "./views/NewsFeed.vue";

const routes = [
    {
        path: '/',
        component: NewsFeed,
        name: 'home',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

export default router;
