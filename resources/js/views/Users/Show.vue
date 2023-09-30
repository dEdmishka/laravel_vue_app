<template>
    <div class="flex flex-col items-center">
        <div class="relative mb-8">
            <div class="w-100 h-64 overflow-hidden z-10">
                <img
                    alt="user background image"
                    class="object-cover w-full"
                    src="https://th.bing.com/th/id/R.49735b38c27ca67787e201a8f4b0fd6d?rik=Yeba4oTgZZIBBA&riu=http%3a%2f%2favante.biz%2fwp-content%2fuploads%2fDownload-hd-backgrounds%2fDownload-hd-backgrounds-041.jpg&ehk=Nk5YhR00vTCJR2p4kaMj5MKuYzVr36EkV8C9ayV0Ijw%3d&risl=&pid=ImgRaw&r=0">
            </div>

            <div class="absolute flex items-center bottom-0 left-0 z-20 -mb-8 ml-12">
                <div class="w-32">
                    <img alt="profile image"
                         class="object-cover w-32 h-32 border-4 border-gray-200 rounded-full shadow-lg"
                         src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg">
                </div>
                <div v-if="userStatus !== 'success'">Loading name...</div>
                <div
                    v-else
                    class="text-2xl text-gray-100 ml-4">
                    {{ user.data.attributes.name }}
                </div>
            </div>

            <div class="absolute flex items-center bottom-0 right-0 z-20 mb-4 mr-12">
                <button
                    v-if="friendBtnText && friendBtnText !== 'Accept'"
                    class="py-1 px-3 bg-gray-400 rounded"
                    @click="$store.dispatch('profile/sendFriendRequest', $route.params.userId)"
                >
                    {{ friendBtnText }}
                </button>
                <button
                    v-if="friendBtnText && friendBtnText === 'Accept'"
                    class="mr-2 py-1 px-3 bg-blue-500 rounded"
                    @click="$store.dispatch('profile/acceptFriendRequest', $route.params.userId)"
                >
                    Accept
                </button>
                <button
                    v-if="friendBtnText && friendBtnText === 'Accept'"
                    class="py-1 px-3 bg-gray-400 rounded"
                    @click="$store.dispatch('profile/ignoreFriendRequest', $route.params.userId)"
                >
                    Ignore
                </button>
            </div>
        </div>

        <div v-if="postsStatus !== 'success'">Loading posts...</div>
        <div v-else-if="posts.data.length === 0">No posts found!</div>
        <Post v-else v-for="(post, postKey) in posts.data"
              :key="postKey"
              :post="post"
        />

    </div>
</template>

<script>
import Post from "../../components/Post.vue";
import {defineComponent} from 'vue'
import {mapGetters} from "vuex";

export default defineComponent({
    name: "Show",
    components: {
        Post
    },
    data: () => {return {}},
    computed: {
        ...mapGetters({
            user: 'profile/user',
            userStatus: 'profile/userStatus',
            postsStatus: 'posts/postsStatus',
            posts: 'posts/posts',
            friendBtnText: 'profile/friendBtnText',
        })
    },
    methods: {},
    mounted() {
        this.$store.dispatch('profile/fetchUser', this.$route.params.userId);
        this.$store.dispatch('posts/fetchUserPosts', this.$route.params.userId);
    }
})
</script>


<style lang="scss" scoped>

</style>
