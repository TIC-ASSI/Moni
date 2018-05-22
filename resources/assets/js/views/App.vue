<template>
    <v-app>
        <v-toolbar dark color="primary" extended tabs app>
            <v-toolbar-side-icon></v-toolbar-side-icon>
            <v-toolbar-title>Monitoring</v-toolbar-title>
            <v-tabs
                slot="extension"
                align-with-title
                color="primary"
                slider-color="white"
            >
                <v-tab :disabled="!$store.state.user" :to="{ name: 'servers' }" exact>
                    My servers
                </v-tab>
                <v-tab :disabled="$store.state.user != null" :to="{ name: 'login' }" exact>
                    Login
                </v-tab>
                <v-tab :disabled="$store.state.user != null" :to="{ name: 'register' }" exact>
                    Register
                </v-tab>
                <v-tab @click="logout" :disabled="!$store.state.user" exact>
                    Logout
                </v-tab>
            </v-tabs>
        </v-toolbar>
        <v-content style="margin-top: 50px;">
            <v-container wrap grid-list-lg>
                <transition name="page" mode="out-in" appear>
                    <router-view></router-view>
                </transition>
            </v-container>
        </v-content>
        <v-snackbar
        :timeout="6000"
        top
        v-model="$store.state.messageShow"
        >
            {{ $store.state.message }}
            <v-btn flat color="pink" @click.native="$store.state.messageShow = false">Close</v-btn>
        </v-snackbar>
    </v-app>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$store.commit('message', "See you soon, " + this.$store.state.user.name)
            this.$store.commit('messageShow', true)
            this.$store.commit('logout')
            this.$router.push('/login')
        },
    }
}
</script>