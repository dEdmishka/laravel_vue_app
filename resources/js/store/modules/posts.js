export const posts = {
    namespaced: true,

    state: {
        posts: null,
        postsStatus: true,
        postMessage: "",
    },
    getters: {
        posts: state => state.posts,
        postsStatus: state => state.postsStatus,
        postMessage: state => state.postMessage,
    },
    mutations: {
        pushLikes(state, data) {
            state.posts.data[data.postKey].data.attributes.likes = data.likes;
        },
        pushComments(state, data) {
            state.posts.data[data.postKey].data.attributes.comments = data.comments;
        },
        setPostsStatus(state, status) {
            state.postsStatus = status;
        },
        setPosts(state, posts) {
            state.posts = posts;
        },
        updateMessage(state, message) {
            state.postMessage = message;
        },
        pushPost(state, post) {
            state.posts.data.unshift(post);
        },
    },
    actions: {
        fetchNewsPosts({commit}) {
            commit('setPostsStatus', 'loading');

            axios.get('/api/posts')
                .then(res => {
                    commit('setPosts', res.data);
                    commit('setPostsStatus', 'success');
                })
                .catch(err => {
                    commit('setPostsStatus', 'error');
                });
        },
        fetchUserPosts({commit, dispatch}, userId) {
            commit('setPostsStatus', 'loading');
            axios.get('/api/users/' + userId + '/posts')
                .then(res => {
                    commit('setPosts', res.data);
                    commit('setPostsStatus', 'success');
                })
                .catch(err => {
                    console.log('Unable to fetch posts!');
                    commit('setPostsStatus', 'error');
                })
        },
        postMessage({commit, state}) {
            commit('setPostsStatus', 'loading');

            axios.post('/api/posts', {body: state.postMessage})
                .then(res => {
                    commit('pushPost', res.data);
                    commit('updateMessage', '');
                    commit('setPostsStatus', 'success');
                })
                .catch(err => {
                    commit('setPostsStatus', 'error');
                });
        },
        likePost({commit, state}, data) {
            axios.post('/api/posts/' + data.postId + '/like')
                .then(res => {
                    commit('pushLikes', { likes: res.data, postKey: data.postKey});
                })
                .catch(err => {
                    console.log(err);
                });
        },
        commentPost({commit, state}, data) {
            axios.post('/api/posts/' + data.postId + '/comment', { body: data.body })
                .then(res => {
                    commit('pushComments', { comments: res.data, postKey: data.postKey});
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
};


