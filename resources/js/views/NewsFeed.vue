<template>
    <div class="flex flex-col items-center py-4">
        <NewPost/>

        <Post/>
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
    }
}
</script>

<style lang="scss" scoped>

</style>
