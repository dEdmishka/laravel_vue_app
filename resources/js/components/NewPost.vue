<template>
    <div class="bg-white rounded w-2/3 p-4">
        <div class="flex justify-between items-center">
            <div>
                <div class="w-8">
                    <img alt="profile image for user"
                         class="w-8 h-8 object-cover rounded-full"
                         src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg">
                </div>
            </div>
            <div class="flex-1 flex mx-4">
                <input id="body"
                       v-model="postMessage"
                       class="w-full pl-4 h-8 bg-gray-200 rounded-full
                       border-gray-300 focus:outline-none
                       focus:shadow-outline focus:ring-1
                       focus:ring-sky-500 text-sm"
                       name="body"
                       placeholder="Add a post"
                       type="text"
                >
                <transition name="fade">
                    <button v-if="postMessage"
                            class="bg-gray-200 ml-2 px-3 py-1 rounded-full"
                            @click="$store.dispatch('posts/postMessage')"
                    >
                        Post
                    </button>
                </transition>
            </div>
            <div>
                <button class="flex justify-center items-center rounded-full w-10 h-10 bg-gray-200">
                    <svg class="fill-current w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.8 4H2.2c-.2 0-.3.2-.3.3v15.3c0 .3.1.4.3.4h19.6c.2 0 .3-.1.3-.3V4.3c0-.1-.1-.3-.3-.3zm-1.6 13.4l-4.4-4.6c0-.1-.1-.1-.2 0l-3.1 2.7-3.9-4.8h-.1s-.1 0-.1.1L3.8 17V6h16.4v11.4zm-4.9-6.8c.9 0 1.6-.7 1.6-1.6 0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6.1.9.8 1.6 1.6 1.6z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {posts} from "../store/modules/posts.js";
import _ from 'lodash';

export default {
    name: "NewsPost",
    data() {
        return {
            postMessage: posts.state.postMessage,
        }
    },
    watch: {
      postMessage: _.debounce(function (postMessage) {
          this.$store.commit('posts/updateMessage', postMessage);
      }, 300),
        // But example below won`t work!!!
        // postMessage: setTimeout(function (postMessage) {
        //     this.$store.commit('posts/updateMessage', postMessage);
        // }, 200),
    },
    // watch: {
    //   postMessage(postMessage) {
    //       this.$store.commit('posts/updateMessage', postMessage);
    //   }
    // },
    // computed: {
    //     // ...mapState('posts', {
    //     //     postMessage: state => state.postMessage,
    //     // }),
    //     // ...mapGetters('posts', {
    //     //     postMessage: 'postMessage'
    //     // })
    //     postMessage: {
    //         get() {
    //             console.log(1);
    //             return posts.state.postMessage
    //         },
    //         set(postMessage) {
    //             this.$store.commit('posts/updateMessage', postMessage);
    //         },
    //     },
    // },
}
</script>
<style lang="scss" scoped>
/* enter -> enter-active -> leave-active -> leave-to */
.fade {
    &-enter-active, &-leave-active {
        transition: opacity 0.5s ease;
    }

    &-enter-from, &-leave-to {
        opacity: 0;
    }
}
</style>
