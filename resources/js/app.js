import './bootstrap';
import {createApp} from 'vue';
import App from "./components/App.vue";
import router from "./router.js";
import Start from "./views/Start.vue";
import store from "./store/index.js";

const app = createApp({});

app.use(router)
app.use(store)
app.component('app', App);
app.component('start', Start);
app.mount('#app');
