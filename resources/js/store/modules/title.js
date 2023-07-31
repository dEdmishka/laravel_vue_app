export const title = {
    namespaced: true,

    state: {
        title: 'Welcome',
    },
    getters: {
        pageTitle: state => state.title,
    },
    mutations: {
        setTitle(state, title) {
            state.title = title + ' | Facebook';

            document.title = state.title;
        },
    },
    actions: {
        setPageTitle({commit}, title) {
            commit('setTitle', title);
        }
    },
};


