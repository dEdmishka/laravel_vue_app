<template>
    <div class="flex flex-col items-center py-4">
        <NewPost/>

        <p v-if="loading">Loading posts...</p>
        <Post v-else v-for="post in posts.data"
              :key="post.data.post_id"
              :post="post"
        />
    </div>
</template>

<script>
import NewPost from "../components/NewPost.vue";
import Post from "../components/Post.vue";

export default {
    name: "NewsFeed",
    components: {
        Post,
        NewPost,
    },

    data: () => {
        return {
            posts: [],
            loading: true
        }
    },

    mounted() {
        axios.get('/api/posts')
            .then(res => {
                this.posts = res.data;
            })
            .catch(err => {
                console.log('Unable to fetch posts!');
            })
            .finally(() => {
                this.loading = false;
            });
    }
}
</script>

<style lang="scss" scoped>

</style>
