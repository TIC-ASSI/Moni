<template>
    <div class="md-layout md-alignment-center-center">
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-50 md-xlarge-size-33">
            <md-card>
                <md-card-header>
                <div class="md-title">Login</div>
                <div class="md-subhead">Enter the credentials to login</div>
                </md-card-header>

                <md-card-content>
                    <form @submit.prevent="handleSubmit">
                        <md-field :class="{ 'md-invalid': 'email' in this.errors }">
                            <label>Email</label>
                            <md-input v-model="credentials.email"></md-input>
                            <span class="md-error">{{ 'email' in this.errors ? this.errors.email[0] : '' }}</span>
                        </md-field>
                        <md-field :class="{ 'md-invalid': 'password' in this.errors }">
                            <label>Password</label>
                            <md-input v-model="credentials.password" type="password"></md-input>
                            <span class="md-error">{{ 'password' in this.errors ? this.errors.password[0] : '' }}</span>
                        </md-field>
                        <center>
                            <md-button type="submit" style="" class="md-raised md-primary">Login</md-button><br>
                            <md-button to="/register">Do you need an account?</md-button>
                        </center>
                    </form>
                </md-card-content>
            </md-card>
        </div>
    </div>
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
                        this.$router.push('/servers')
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