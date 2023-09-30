<template>
    <div class="flex flex-col items-center py-4">
        <NewPost/>

        <p v-if="newsStatus === 'loading'">Loading posts...</p>
        <Post
            v-for="(post, postKey) in posts.data"
            v-else
            :key="postKey"
            :post="post"
        />
    </div>
</template>

<script>
import NewPost from "../components/NewPost.vue";
import Post from "../components/Post.vue";
import {mapGetters} from "vuex";

export default {
    name: "NewsFeed",
    components: {
        Post,
        NewPost,
    },

    // data: () => {
    //     return {
    //         posts: [],
    //         loading: true
    //     }
    // },

    computed: {
        ...mapGetters('posts', {
            posts: 'newsPosts',
            newsStatus: 'newsStatus'
        })
    },

    created() {
        this.$store.dispatch('posts/fetchNewsPosts');
    }
}
</script>

<style lang="scss" scoped>

</style>
