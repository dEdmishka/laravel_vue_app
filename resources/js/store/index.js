import {createStore} from "vuex";
import {user} from './modules/user.js';
import {title} from "./modules/title.js";
export default createStore({
    modules: {
        user,
        title
    },
});
