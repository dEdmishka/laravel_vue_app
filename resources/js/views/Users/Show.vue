<template>
    <div class="flex flex-col items-center">
        <div class="relative mb-8">
            <div class="w-100 h-64 overflow-hidden z-10">
                <img
                    src="https://th.bing.com/th/id/R.49735b38c27ca67787e201a8f4b0fd6d?rik=Yeba4oTgZZIBBA&riu=http%3a%2f%2favante.biz%2fwp-content%2fuploads%2fDownload-hd-backgrounds%2fDownload-hd-backgrounds-041.jpg&ehk=Nk5YhR00vTCJR2p4kaMj5MKuYzVr36EkV8C9ayV0Ijw%3d&risl=&pid=ImgRaw&r=0"
                    alt="user background image" class="object-cover w-full">
            </div>

            <div class="absolute flex items-center bottom-0 left-0 z-20 -mb-8 ml-12">
                <div class="w-32">
                    <img src="https://cdn.pixabay.com/photo/2014/07/09/10/04/man-388104_960_720.jpg"
                         alt="profile image"
                         class="object-cover w-32 h-32 border-4 border-gray-200 rounded-full shadow-lg">
                </div>
                <p v-if="userLoading">Loading name...</p>
                <p
                    v-else
                    class="text-2xl text-gray-100 ml-4">
                    {{ user.data.attributes.name }}
                </p>
            </div>
        </div>

        <p v-if="postLoading">Loading posts...</p>
        <Post v-else v-for="post in posts.data"
              :key="post.data.post_id"
              :post="post"
        />

        <p v-if="!postLoading && posts.data.length === 0">No posts found!</p>
    </div>
</template>

<script>
import Post from "../../components/Post.vue";

export default defineComponent({
    name: "Show",
    components: {
        Post
    },
    data: () => {
        return {
            user: null,
            posts: [],
            userLoading: true,
            postLoading: true
        }
    },
    mounted() {
        axios.get('/api/users/' + this.$route.params.userId)
            .then(res => {
                this.user = res.data;
            })
            .catch(err => {
                console.log('Unable to fetch the user from the server');
            })
            .finally(() => {
                this.userLoading = false;
            });

        axios.get('/api/users/' + this.$route.params.userId + '/posts')
            .then(res => {
                this.posts = res.data;
            })
            .catch(err => {
                console.log('Unable to fetch posts!');
            })
            .finally(() => {
                this.postLoading = false;
            });
    }
})

import {defineComponent} from 'vue'
</script>


<style scoped lang="scss">

</style>
