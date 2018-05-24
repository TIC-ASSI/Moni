<template>
    <v-layout row wrap>
        <v-flex xs12 s12 md6>
            <v-card class="elevation-2">
                <v-card-title>
                    <span class="headline">Instructions</span>
                </v-card-title>
                <v-container fill-height fluid>
                        <v-layout fill-height wrap>
                            <v-flex xs12 style="overflow-y: auto;">
                                <p>
                                    To add a new server to the monitoring system, download the tool for the
                                    desired platform and execute it with the following parameters
                                    (Please note that the order is important):
                                </p>
                                <p>
                                    <b>API_TOKEN:</b> Required.
                                    Used to authenticate you to the server.
                                </p>
                                <p>
                                    <b>SERVER_NAME:</b> Required.
                                    Determines the server name to be used.
                                    It will create one for you if it did not exist.
                                </p>
                                <p>
                                    <b>INTERVAL: (sec)</b> Optional.
                                    Defaults to 60 seconds.
                                </p>
                                <p>
                                    You may copy and paste your API_TOKEN from below:<br><br>
                                    <code>{{ $store.state.user.api_token }}</code>
                                </p>
                            </v-flex>
                        </v-layout>
                </v-container>
            </v-card>
        </v-flex>
        <v-flex xs12 s12 md6>
            <v-card class="elevation-2">
                <v-card-title>
                    <span class="headline">Download</span>
                </v-card-title>
                <v-container fill-height fluid>
                        <v-layout fill-height wrap>
                            <v-flex xs12 style="overflow-y: auto;">
                                <p>
                                    Download the native application for the desired platform. To execute it
                                    we provide an example command to be executed on the download path of the application:
                                </p>
                                <p>
                                    <v-btn @click="download('linux')" color="primary">Linux Download</v-btn>
                                    <br>
                                    <code>chmod u+x ./monitoring</code><br>
                                    <code>./monitoring {{ $store.state.user.api_token }} Server1 60</code>
                                </p>
                                <p>
                                    <v-btn @click="download('windows')" color="primary">Windows Download</v-btn>
                                    <br>
                                    <code>.\monitoring.exe {{ $store.state.user.api_token }} Server1 60</code>
                                </p>
                                <p>
                                    This example code will create a server named <b>Server1</b> with a refresh
                                    interval of <b>60</b> seconds.
                                </p>
                            </v-flex>
                        </v-layout>
                </v-container>
            </v-card>
        </v-flex>
        <v-flex xs12 s12>
            <v-card class="elevation-2">
                <v-card-title>
                    <span class="headline">Servers</span>
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
                        { text: 'Last update', value: 'updated_at' },
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
                        <td>{{ props.item.version }}</td>
                        <td>{{ props.item.platform }}</td>
                        <td>{{ props.item.processor }}</td>
                        <td>{{ timeAt(props.item.updated_at) }}</td>
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
                        if (err.response.status == 401) {
                            this.$store.commit('logout')
                            this.$router.push({ name: 'login' })
                        }
                    })
            },
            download(platform) {
                var name = 'monitoring'
                var url = '/app/monitoring'
                if (platform == 'windows') {
                    name = 'monitoring.exe'
                    url = '/app/' + name
                }
                window.location.href = url;
            },
            timeAt(at) {
                return moment(at).fromNow()
            }
        },
        created() {
            this.getServers()
            var pusher = new Pusher('b5732d274e9b079e5ccb', {
                cluster: 'eu',
                encrypted: true
            });
            var channel = pusher.subscribe('servers_' + this.$store.state.user.id);
            channel.bind('update', this.getServers);
        },
        watch: {
            '$route': 'getServers'
        },
    }
</script>