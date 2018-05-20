import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'

Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueMaterial)

import App from './views/App'
import Home from './views/Home'
import Login from './views/Login'
import Servers from './views/Servers'
import Register from './views/Register'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/servers',
            name: 'servers',
            component: Servers,
        },
    ],
});

const store = new Vuex.Store({
    state: {
        message: '',
        messageShow: false,
        user: null,
    },
    mutations: {
        message(state, p) {
            state.message = p
        },
        messageShow(state, p) {
            state.messageShow = p
        },
        user(state, p) {
            state.user = p
            localStorage.setItem('user', JSON.stringify(p))
            console.log('ADDED')
        },
        getUser(state) {
            var user = localStorage.getItem('user')
            if (user) {
                state.user = JSON.parse(user)
            }
            console.log(state.user)
        },
        logout(state) {
            localStorage.removeItem('user')
            state.user = null
        }
    }
})

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
    created() {
        this.$store.commit('getUser');
    }
});