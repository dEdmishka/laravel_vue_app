import './bootstrap';
import {createApp} from 'vue';
import App from "./components/App.vue";
import router from "./router.js";
import Start from "./views/Start.vue";

const app = createApp({});

app.use(router)
app.component('app', App);
app.component('start', Start);
app.mount('#app');
