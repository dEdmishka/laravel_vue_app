export const profile = {
    namespaced: true,

    state: {
        user: null,
        userStatus: null,
        friendBtnText: '',
        posts: [],
        postsStatus: null,
    },
    getters: {
        user: state => state.user,
        posts: state => state.posts,
        status: state => {
            return {
                user: state.userStatus,
                posts: state.postsStatus,
            }
        },
        friendship: state => state.user.data.attributes.friendship,
        friendBtnText: state => state.friendBtnText
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setUserStatus(state, status) {
            state.userStatus = status;
        },
        setPosts(state, posts) {
            state.posts = posts;
        },
        setPostsStatus(state, postsStatus) {
            state.postsStatus = postsStatus;
        },
        setUserFriendship(state, friendship) {
            state.user.data.attributes.friendship = friendship;
        },
        setBtnText(state, text) {
            state.friendBtnText = text;
        },
    },
    actions: {
        fetchUser({commit, dispatch}, userId) {
            commit('setUserStatus', 'loading');
            axios.get('/api/users/' + userId)
                .then(res => {
                    commit('setUser', res.data);
                    commit('setUserStatus', 'success');
                    dispatch('setFriendBtn');
                })
                .catch(err => {
                    console.log('Unable to fetch the user from the server');
                    commit('setUserStatus', 'error');
                })
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
        sendFriendRequest({commit, getters, dispatch}, friendId) {
            if (getters.friendBtnText !== 'Add Friend') {
                return;
            }

            axios.post('/api/friend-request', {'friend_id': friendId})
                .then(res => {
                    commit('setUserFriendship', res.data);
                    commit('setBtnText', 'Pending Friend Request');
                    dispatch('setFriendBtn');
                })
                .catch(err => {
                    commit('setBtnText', 'Add Friend');
                })
        },
        acceptFriendRequest({commit, dispatch}, userId) {
            axios.post('/api/friend-request-response', {'user_id': userId, 'status': 1})
                .then(res => {
                    commit('setUserFriendship', res.data);
                    dispatch('setFriendBtn');
                })
                .catch(err => {
                })
        },
        ignoreFriendRequest({commit, dispatch}, userId) {
            axios.delete('/api/friend-request-response/delete', {data: {'user_id': userId}})
                .then(res => {
                    commit('setUserFriendship', null);
                    dispatch('setFriendBtn');
                })
                .catch(err => {
                })
        },
        setFriendBtn({state, commit, getters, rootState}) {
            if (rootState.user.user.data.user_id === state.user.data.user_id) {
                commit('setBtnText', '');
            } else if (getters.friendship === null) {
                commit('setBtnText', 'Add Friend');
            } else if (getters.friendship.data.attributes.confirmed_at === null
                && getters.friendship.data.attributes.friend_id !== rootState.user.user.data.user_id) {
                commit('setBtnText', 'Pending Friend Request');
            } else if (getters.friendship.data.attributes.confirmed_at === null
                && getters.friendship.data.attributes.friend_id === rootState.user.user.data.user_id) {
                commit('setBtnText', 'Accept');
            } else if (getters.friendship.data.attributes.confirmed_at !== null) {
                commit('setBtnText', '');
            }
        }
    },
};


