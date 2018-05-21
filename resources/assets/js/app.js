import Vue from 'vue'
import Vuex from 'vuex'
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import 'vuetify/dist/vuetify.min.css'
import colors from 'vuetify/es5/util/colors'

Vue.use(Vuex)
Vue.use(Vuetify, {
    theme: {
        primary: colors.indigo.accent3
    }
})
Vue.use(VueRouter)

import App from './views/App'
import Login from './views/Login'
import Server from './views/Server'
import Servers from './views/Servers'
import Register from './views/Register'

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
        },
        getUser(state) {
            var user = localStorage.getItem('user')
            if (user) {
                state.user = JSON.parse(user)
            }
        },
        logout(state) {
            localStorage.removeItem('user')
            state.user = null
        }
    }
})

store.commit('getUser')

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'servers',
            component: Servers,
            beforeEnter: (to, from, next) => {
                if (store.state.user == null) {
                    router.push({ name: 'login' })
                }
                next()
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: (to, from, next) => {
                if (store.state.user != null) {
                    router.push({ name: 'servers' })
                }
                next()
            }
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            beforeEnter: (to, from, next) => {
                if (store.state.user != null) {
                    router.push({ name: 'servers' })
                }
                next()
            }
        },
        {
            path: '/servers/:id',
            name: 'server',
            component: Server,
            beforeEnter: (to, from, next) => {
                if (store.state.user == null) {
                    router.push({ name: 'login' })
                }
                next()
            }
        },
        {
            path: '*',
            name: 'not_found',
            component: {
                created: () => router.push('/')
            }
        }
    ],
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
    created() {
        this.$store.commit('getUser');
    }
});