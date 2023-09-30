export const posts = {
    namespaced: true,

    state: {
        newsPosts: null,
        newsPostsStatus: true,
        postMessage: "",
    },
    getters: {
        newsPosts: state => state.newsPosts,
        newsStatus: state => state.newsPostsStatus,
        postMessage: state => state.postMessage,
    },
    mutations: {
        pushLikes(state, data) {
            state.newsPosts.data[data.postKey].data.attributes.likes = data.likes;
        },
        setPostsStatus(state, status) {
            state.newsPostsStatus = status;
        },
        setPosts(state, posts) {
            state.newsPosts = posts;
        },
        updateMessage(state, message) {
            state.postMessage = message;
        },
        pushPost(state, post) {
            state.newsPosts.data.unshift(post);
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
                    commit('updateMessage', '');
                    // commit('setPostsStatus', 'success');
                })
                .catch(err => {
                    console.log(err)
                    // commit('setPostsStatus', 'error');
                });
        }
    },
};


