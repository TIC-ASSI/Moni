<template>
    <div class="md-layout">
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-50 md-xlarge-size-50">
            <md-card>
                <md-card-header>
                    <div class="md-title">Account details</div>
                    <div class="md-subhead">You can check your account details here</div>
                </md-card-header>

                <md-card-content>
                    <md-list>
                        <md-list-item>
                            <md-icon>person</md-icon>
                            <span class="md-list-item-text">{{ $store.state.user.name }}</span>
                        </md-list-item>
                        <md-list-item>
                            <md-icon>mail</md-icon>
                            <span class="md-list-item-text">{{ $store.state.user.email }}</span>
                        </md-list-item>
                        <md-list-item>
                            <md-icon>access_time</md-icon>
                            <span class="md-list-item-text">{{ created_date }}</span>
                        </md-list-item>
                        <md-list-item>
                            <md-icon>computer</md-icon>
                            <span class="md-list-item-text">{{ servers.length }}</span>
                        </md-list-item>
                    </md-list>
                </md-card-content>

                <md-card-actions>
                    <md-button @click="logout">Logout</md-button>
                </md-card-actions>
            </md-card>
            <br>
            <md-card>
                <md-card-header>
                    <div class="md-title">Add a new server</div>
                    <div class="md-subhead">Instructions to add a new server</div>
                </md-card-header>

                <md-card-content>
                    <p>
                        You need to download our tool. The tool requires <b>python +3.6</b>. To use the tool, you
                        need to execute the python script with the following arguments, the order is important, so make
                        sure you enter them correctly:
                    </p>
                    <p>
                        To help a bit with this, enter the desired server name here and copy-paste the following code
                        in your terminal to execute the script.
                    </p>
                    <md-field>
                        <label>Server name</label>
                        <md-input v-model="server_name"></md-input>
                    </md-field>
                    <md-field>
                        <label>Command to execute</label>
                        <md-input readonly :value="'python monitoring.py ' + server_name + ' ' + $store.state.user.api_token"></md-input>
                    </md-field>

                </md-card-content>

                <md-card-actions>
                    <md-button @click="logout"><md-button @click="download">Download the python script</md-button></md-button>
                </md-card-actions>
            </md-card>
        </div>
        <div class="md-layout-item md-small-size-100 md-medium-size-50 md-large-size-50 md-xlarge-size-50">
            <md-table v-model="searched" md-sort="id" md-sort-order="asc" md-card md-fixed-header>
                <md-table-toolbar>
                    <div class="md-toolbar-section-start">
                    <h1 class="md-title">Servers</h1>
                    </div>

                    <md-field md-clearable class="md-toolbar-section-end">
                    <md-input placeholder="Search by name..." v-model="search" @input="searchOnTable" />
                    </md-field>
                </md-table-toolbar>

                <md-table-empty-state
                    md-label="No servers found"
                    :md-description="`No server found for this '${search}' query. Try a different search term or create a new server.`">
                </md-table-empty-state>


                <md-table-row slot="md-table-row" slot-scope="{ item }">
                    <md-table-cell md-label="ID" md-sort-by="id" md-numeric>{{ item.id }}</md-table-cell>
                    <md-table-cell md-label="Name" md-sort-by="name">{{ item.name }}</md-table-cell>
                    <md-table-cell md-label="OS" md-sort-by="os">{{ item.os }}</md-table-cell>
                    <md-table-cell md-label="Version" md-sort-by="version">{{ item.version }}</md-table-cell>
                    <md-table-cell md-label="Node" md-sort-by="node">{{ item.node }}</md-table-cell>
                    <md-table-cell md-label="Panel"><md-button class="md-raised md-primary">Panel</md-button></md-table-cell>
                </md-table-row>
            </md-table>
        </div>
    </div>
</template>

<script>
    const toLower = text => {
        return text.toString().toLowerCase()
    }

    const searchByName = (items, term) => {
        if (term) {
            return items.filter(item => toLower(item.name).includes(toLower(term)))
        }

        return items
    }

    export default {
        data: () => ({
            servers: [],
            search: null,
            searched: [],
            server_name: 'sample_server',
        }),
        computed: {
            created_date() {
                return moment(this.$store.state.user.created_at).fromNow();
            }
        },
        methods: {
            getServers() {
                axios.post('/api/servers?api_token=' + this.$store.state.user.api_token)
                    .then(res => {
                        this.servers = res.data
                        this.searched = this.servers
                    })
                    .catch(err => {
                        this.$store.commit('message', err.response.data.message)
                        this.$store.commit('messageShow', true)
                    })
            },
            logout() {
                this.$store.commit('message', "See you soon, " + this.$store.state.user.name)
                this.$store.commit('messageShow', true)
                this.$store.commit('logout')
                this.$router.push('/login')
            },
            searchOnTable () {
                this.searched = searchByName(this.servers, this.search)
            },
            download() {
                //
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