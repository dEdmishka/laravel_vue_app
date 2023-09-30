import {createStore} from "vuex";
import {user} from './modules/user.js';
import {title} from "./modules/title.js";
import {profile} from "./modules/profile.js";
import {posts} from "./modules/posts.js";

export default createStore({
    modules: {
        user,
        title,
        profile,
        posts
    },
});
