<template>
    <div
        v-if="authUser"
        class="flex flex-col flex-1 h-screen overflow-y-hidden"
    >
        <Navbar/>
        <!--        This is app!-->
        <div class="flex overflow-y-hidden flex-1">
            <Sidebar/>

            <div class="overflow-x-hidden w-2/3">
                <router-view
                    :key="$route.fullPath"
                ></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import Navbar from "./Navbar.vue";
import Sidebar from "./Sidebar.vue";
import {mapGetters} from "vuex";

export default {
    components: {
        Navbar,
        Sidebar
    },

    computed: {
        ...mapGetters({
            authUser: 'user/authUser',
        })
    },

    watch: {
        $route(to, from) {
            this.$store.dispatch('title/setPageTitle', to.meta.title);
        }
    },

    created() {
        this.$store.dispatch('title/setPageTitle', this.$route.meta.title);
    },

    mounted() {
        this.$store.dispatch('user/fetchAuthUser');
    }
}
</script>

<style lang="scss" scoped>

</style>
