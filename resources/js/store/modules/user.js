export const user = {
    namespaced: true,

    state: {
        user: null,
        loading: true,
        userStatus: null,

        // avatarUrl: null,
        // user: {
        //     id: userData.id || undefined,
        //     role: userData.role || undefined,
        //     name: userData.name || undefined,
        //     surname: userData.surname || undefined,
        //     patronymic: userData.patronymic || undefined,
        //     email: userData.email || undefined,
        //     phone: userData.phone || undefined,
        //     sex: userData.sex,
        //     birthday: userData.birthday || undefined,
        //     email_verified_at: userData.email_verified_at || undefined,
        //     created_at: userData.created_at || undefined,
        //     updated_at: userData.updated_at || undefined,
        //     deleted_at: userData.deleted_at || undefined,
        // }
    },
    getters: {
        authUser: state => state.user,
        loading: state => state.loading,
        // isLoggedIn: state => state.user.id !== undefined,
        // isEmailVerified: state => state.user.email_verified_at !== undefined && state.user.email_verified_at !== null,
        // getAvatarUrl: (state) => state.avatarUrl,
        // getUserEmail: (state) => state.user.email,
    },
    mutations: {
        setAuthUser(state, user) {
            state.user = user;
        },
        resetLoading(state) {
            state.loading = false;
        }
        // setUserData(state, user) {
        //     if (!user) {
        //         state.user = {};
        //         localStorage.removeItem('user');
        //     } else {
        //         state.user = user;
        //         localStorage.setItem('user', encryptData(user));
        //     }
        // },
        // setAvatarUrl(state, url) {
        //     state.avatarUrl = url;
        // },
    },
    actions: {
        fetchAuthUser({commit}) {
            axios.get('/api/auth-user')
                .then(res => {
                    commit('setAuthUser', res.data);
                })
                .catch(err => {
                    console.log('Unable to fetch auth user');
                })
                .finally(() => {
                    commit('resetLoading');
                });
        },
        // setUser({commit}, user) {
        //     commit('user/setUserData', user, {root: true});
        // },
        // setAvatar({commit}, avatar) {
        //     commit('user/setAvatarUrl', avatar, {root: true});
        // },
        // async onLoadFiles({commit}, formData) {
        //     AccountApi
        //         .loadFiles(formData)
        //         .then(async (res) => {
        //             console.log(res);
        //         })
        //         .catch(async (err) => {
        //             // console.log(err);
        //             await this.dispatch('reports/showErrors', err);
        //         })
        // },
        // async onUpdateUser({commit}, {name, surname, patronymic, email, phone, sex, birthday}) {
        //     await this.dispatch('loading/setLoading', true);
        //     AccountApi
        //         .updateData(name, surname, patronymic, email, phone, sex, birthday)
        //         .then(async (res) => {
        //             await this.dispatch('user/setUser', res.data);
        //             await this.dispatch('reports/showSuccess', res);
        //         })
        //         .catch(async (err) => {
        //             await this.dispatch('reports/showErrors', err);
        //         })
        //         .finally(async () => {
        //             await this.dispatch('loading/setLoading', false);
        //         });
        // },
        // async onUpdatePassword({commit}, {current_password, password, password_confirmation}) {
        //     await this.dispatch('loading/setLoading', true);
        //     AccountApi
        //         .updatePassword(current_password, password, password_confirmation)
        //         .then(async (res) => {
        //             await this.dispatch('reports/showSuccess', res);
        //         })
        //         .catch(async (err) => {
        //             await this.dispatch('reports/showErrors', err);
        //         })
        //         .finally(async () => {
        //             await this.dispatch('loading/setLoading', false);
        //         });
        // },
        // async onUpdateAvatar({commit}, formData) {
        //     await this.dispatch('loading/setLoading', true);
        //     AccountApi
        //         .updateAvatar(formData)
        //         .then(async (res) => {
        //             await this.dispatch('user/setAvatar', res.data.data.url);
        //             await this.dispatch('reports/showSuccess', res);
        //         })
        //         .catch(async (err) => {
        //             await this.dispatch('reports/showErrors', err);
        //         })
        //         .finally(async () => {
        //             await this.dispatch('loading/setLoading', false);
        //         });
        // },
        // async fetchUser({commit}) {
        //     await this.dispatch('loading/setLoading', true);
        //     AccountApi.getAccountData()
        //         .then(async (res) => {
        //             const avatarUrl = res.data.avatar?.url || DEFAULT_PROFILE_IMG;
        //             commit('setAvatarUrl', avatarUrl);
        //         })
        //         .catch(async (err) => {
        //             console.error(err);
        //             // await this.dispatch('reports/showErrors', err);
        //         })
        //         .finally(async () => {
        //             await this.dispatch('loading/setLoading', false);
        //         });
        // },
    },
};


