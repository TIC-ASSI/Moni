<template>
    <v-layout row wrap>
        <v-flex xs12 s12 md8 lg4 offset-md2 offset-lg4>
            <v-card color="white" class="elevation-2">
                <v-card-title primary-title>
                    <h3 class="headline mb-0">Login</h3>
                </v-card-title>
                <form @submit.prevent="handleSubmit" @keyup.enter="handleSubmit">
                    <v-container fill-height fluid>
                        <v-layout fill-height wrap>
                            <v-flex xs12>
                                <v-text-field
                                    label="Email"
                                    autofocus
                                    :error-messages="errors.email"
                                    v-model="credentials.email"
                                ></v-text-field>
                            </v-flex>
                            <v-flex xs12>
                                <v-text-field
                                    label="Password"
                                    type="password"
                                    :error-messages="errors.password"
                                    v-model="credentials.password"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </form>
                <v-card-actions>
                    <v-btn @click="handleSubmit" flat>Log me in</v-btn>
                </v-card-actions>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        data: () => ({
            errors: {},
            credentials: {
                email: '',
                password: ''
            }
        }),
        methods: {
            handleSubmit() {
                axios.post('/api/login', this.credentials)
                    .then(res => {
                        this.errors = {}
                        this.$store.commit('user', res.data.user)
                        this.$store.commit('message', res.data.message)
                        this.$store.commit('messageShow', true)
                        this.$router.push({ name: 'servers' })
                    })
                    .catch(err => {
                        console.log(err.response)
                        this.errors = 'errors' in err.response.data ? err.response.data.errors : {}
                        this.$store.commit('message', err.response.data.message)
                        this.$store.commit('messageShow', true)
                    });
            }
        }
    }
</script>