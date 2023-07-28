import {createRouter, createWebHistory} from 'vue-router/dist/vue-router.esm-bundler';
import Start from "./views/Start.vue";
import NewsFeed from "./views/NewsFeed.vue";
import UserShow from './views/Users/Show.vue'

const routes = [
    {
        path: '/',
        component: NewsFeed,
        name: 'home',
    },
    {
        path: '/users/:userId',
        component: UserShow,
        name: 'user.show',
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

export default router;
