<template>
    <v-layout row wrap>
        <v-flex xs12 s12>
            {{ server }}
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        data: () => ({
            server: {},
            loaded: false,
        }),
        methods: {
            getServer() {
                this.loaded = false
                axios.post('/api/servers/' + this.$route.params.id + '?api_token=' + this.$store.state.user.api_token)
                    .then(res => {
                        this.server = res.data
                        this.loaded = true
                    })
                    .catch(err => {
                        this.$store.commit('message', err.response.data.message)
                        this.$store.commit('messageShow', true)
                    })
            },
            createdAt(at) {
                return moment(at).fromNow()
            }
        },
        created() {
            this.getServer()
        },
        watch: {
            '$route' (to, from) {
                this.getServer()
            }
        }
    }
</script>