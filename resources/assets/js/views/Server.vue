<template>
    <v-layout row wrap>
        <v-flex xs12 s12 md6 lg4>
            <v-card color="white" class="elevation-2">
                <v-card-title>
                    Server information
                </v-card-title>
                <v-data-table
                    :items="server_info"
                    hide-actions
                    hide-headers
                >
                    <template slot="items" slot-scope="props">
                        <td><b>{{ props.item.name }}</b></td>
                        <td>{{ props.item.value }}</td>
                    </template>
                </v-data-table>
            </v-card>
            <br>
            <v-card color="white" class="elevation-2">
                <v-card-title>
                    Network information
                </v-card-title>
                <v-data-table
                    :items="net_info"
                    hide-actions
                    hide-headers
                >
                    <template slot="items" slot-scope="props">
                        <td><b>{{ props.item.name }}</b></td>
                        <td>{{ props.item.value }}</td>
                    </template>
                </v-data-table>
            </v-card>
        </v-flex>
        <v-flex xs12 s12 md6 lg4>
            <v-card color="white" class="elevation-2">
                <v-card-title>
                    CPU information
                </v-card-title>
                <v-data-table
                    :items="cpu_info"
                    hide-actions
                    hide-headers
                >
                    <template slot="items" slot-scope="props">
                        <td><b>{{ props.item.name }}</b></td>
                        <td>{{ props.item.value }}</td>
                    </template>
                </v-data-table>
            </v-card>
            <br>
            <v-card color="white" class="elevation-2">
                <v-container fill-height fluid>
                    <v-layout fill-height wrap>
                        <v-flex xs12>
                            <center>
                                <v-progress-circular
                                    :size="200"
                                    :width="25"
                                    :rotate="-90"
                                    :value="cpu_percent"
                                    color="primary"
                                >
                                    <h2>{{ cpu_percent }} %</h2>
                                    CPU usage
                                </v-progress-circular>
                            </center>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
            <br>
            <v-card color="white" class="elevation-2">
                <v-card-title>
                    Disks information
                </v-card-title>
                <v-data-table
                    :items="server ? server.current.disks : []"
                    hide-actions
                    hide-headers
                >
                    <template slot="items" slot-scope="props">
                        <td><b>{{ props.item.mount_point }}</b></td>
                        <td>{{ props.item.file_system }}</td>
                        <td>{{ props.item.used }}GB / {{ props.item.total }}GB</td>
                        <td>
                            <v-progress-circular
                                :value="parseInt(props.item.percent)"
                                :rotate="-90"
                                :color="colorOfPer(props.item.percent)"
                            >
                            </v-progress-circular>
                        </td>
                    </template>
                </v-data-table>
            </v-card>
        </v-flex>
        <v-flex xs12 s12 md6 lg4>
            <v-card color="white" class="elevation-2">
                <v-card-title>
                    Memory information
                </v-card-title>
                <v-data-table
                    :items="mem_info"
                    hide-actions
                    hide-headers
                >
                    <template slot="items" slot-scope="props">
                        <td><b>{{ props.item.name }}</b></td>
                        <td>{{ props.item.value }}</td>
                    </template>
                </v-data-table>
            </v-card>
            <br>
            <v-card color="white" class="elevation-2">
                <v-container fill-height fluid>
                    <v-layout fill-height wrap>
                        <v-flex xs12>
                            <center>
                                <v-progress-circular
                                    :size="200"
                                    :width="25"
                                    :rotate="-90"
                                    :value="mem_percent"
                                    color="primary"
                                >
                                    <h2>{{ mem_percent }} %</h2>
                                    Memory usage
                                </v-progress-circular>
                            </center>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
            <br>
            <v-card color="white" class="elevation-2">
                <v-card-title>
                    Addresses information
                </v-card-title>
                <v-data-table
                    :items="server ? server.current.net.addresses : []"
                    hide-actions
                    hide-headers
                >
                    <template slot="items" slot-scope="props">
                        <td><b>{{ props.item.name }}</b></td>
                        <td>{{ props.item.ip }}</td>
                    </template>
                </v-data-table>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    export default {
        data: () => ({
            server: null,
            loaded: false,
            pusher: null,
        }),
        computed: {
            server_info() {
                if (this.server == null) {
                    return []
                }
                return [
                    { 'name': 'ID', 'value': this.server.id },
                    { 'name': 'Name', 'value': this.server.name },
                    { 'name': 'Node', 'value': this.server.node },
                    { 'name': 'Operating System', 'value': this.server.os },
                    { 'name': 'Operating System version', 'value': this.server.version },
                    { 'name': 'Platform', 'value': this.server.platform },
                    { 'name': 'Processor', 'value': this.server.processor },
                    { 'name': 'PIDs', 'value': this.server.current.pid.number + ' PIDs' },
                    { 'name': 'Last update', 'value': this.timeAt(this.server.updated_at) }
                ]
            },
            cpu_info() {
                if (this.server == null) {
                    return []
                }
                return [
                    { 'name': 'Cores', 'value': this.server.current.cpu.cores + ' Cores' },
                    { 'name': 'Max. frequency', 'value': this.server.current.cpu.max_frequency + ' Hz' },
                    { 'name': 'Min. frequency', 'value': this.server.current.cpu.min_frequency + ' Hz' },
                    { 'name': 'Frequency', 'value': this.server.current.cpu.frequency + ' Hz' },
                    { 'name': 'CPU usage', 'value': this.server.current.cpu.percent + '%' },
                ]
            },
            mem_info() {
                if (this.server == null) {
                    return []
                }
                return [
                    { 'name': 'Total', 'value': this.server.current.mem.total + ' GB' },
                    { 'name': 'Used', 'value': this.server.current.mem.used + ' GB' },
                    { 'name': 'Free', 'value': this.server.current.mem.free + ' GB' },
                    { 'name': 'Available', 'value': this.server.current.mem.available + ' GB' },
                    { 'name': 'Memory Usage', 'value': this.server.current.mem.percent + '%' },
                ]
            },
            net_info() {
                if (this.server == null) {
                    return []
                }
                return [
                    { 'name': 'Total', 'value': this.server.current.net.total + ' PIDs' },
                    { 'name': 'Listening', 'value': this.server.current.net.listen + ' PIDs' },
                    { 'name': 'Stable', 'value': this.server.current.net.stable + ' PIDs' },
                ]
            },
            cpu_percent() {
                if (this.server == null) {
                    return 0
                }
                return parseInt(this.server.current.cpu.percent)
            },
            mem_percent() {
                if (this.server == null) {
                    return 0
                }
                return parseInt(this.server.current.mem.percent)
            }
        },
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
                        if (err.response.status == 401) {
                            this.$store.commit('logout')
                            this.$router.push({ name: 'login' })
                        }
                    })
            },
            colorOfPer(p) {
                if (p < 25) {
                    return 'green'
                } else if (p < 50) {
                    return 'blue'
                } else if (p < 75) {
                    return 'green'
                }
                return 'red'
            },
            timeAt(at) {
                return moment(at).fromNow()
            }
        },
        created() {
            this.getServer()
            console.log('OK')
            Pusher.logToConsole = true;
            var pusher = new Pusher('b5732d274e9b079e5ccb', {
                cluster: 'eu',
                encrypted: true
            });
            var channel = pusher.subscribe('server_' + this.$route.params.id);
            channel.bind('update', this.getServer);
        },
        watch: {
            '$route' (to, from) {
                this.getServer()
            }
        }
    }
</script>