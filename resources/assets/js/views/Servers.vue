<template>
    <v-layout row wrap>
        <v-flex xs12 s12>
            <v-card class="elevation-2">
                <v-card-title>
                    Servers
                    <v-spacer></v-spacer>
                    <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                    ></v-text-field>
                </v-card-title>
                <v-data-table
                    :headers="[
                        { text: 'ID', value: 'id' },
                        { text: 'Name', value: 'name' },
                        { text: 'Node', value: 'node' },
                        { text: 'OS', value: 'os' },
                        { text: 'Version', value: 'version' },
                        { text: 'Platform', value: 'platform' },
                        { text: 'Processor', value: 'processor' },
                        { text: 'Created at', value: 'created_at' },
                        { text: 'Options' },
                    ]"
                    :loading="!loaded"
                    :items="servers"
                    :search="search"
                >
                    <template slot="items" slot-scope="props">
                        <td>{{ props.item.id }}</td>
                        <td>{{ props.item.name }}</td>
                        <td>{{ props.item.node }}</td>
                        <td>{{ props.item.os }}</td>
                        <td >{{ props.item.version }}</td>
                        <td>{{ props.item.platform }}</td>
                        <td>{{ props.item.processor }}</td>
                        <td>{{ createdAt(props.item.created_at) }}</td>
                        <td>
                            <v-btn icon class="mx-0" :to="{ name: 'server', params: { id: props.item.id } }">
                                <v-icon color="grey">remove_red_eye</v-icon>
                            </v-btn>
                        </td>
                    </template>
                    <v-alert slot="no-results" :value="true" color="error" icon="warning">
                        Your search for "{{ search }}" found no results.
                    </v-alert>
                </v-data-table>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        data: () => ({
            servers: [],
            loaded: false,
            search: [],
            server_name: 'sample_server',
        }),
        computed: {
            created_date() {
                return moment(this.$store.state.user.created_at).fromNow();
            }
        },
        methods: {
            getServers() {
                this.loaded = false
                axios.post('/api/servers?api_token=' + this.$store.state.user.api_token)
                    .then(res => {
                        this.servers = res.data
                        this.searched = this.servers
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
            this.getServers()
        },
        watch: {
            '$route': 'getServers'
        },
    }
</script>