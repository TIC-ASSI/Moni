<template>
  <div class="page-container" style="height: 100%;">
    <md-app md-waterfall md-mode="fixed-last" style="height: 100%;">
      <md-app-toolbar class="md-large md-dense md-primary">
        <div class="md-toolbar-row">
          <div class="md-toolbar-section-start">
            <md-button class="md-icon-button" @click="menuVisible = !menuVisible">
              <md-icon>menu</md-icon>
            </md-button>

            <span class="md-title">Monitoring</span>
          </div>

          <div class="md-toolbar-section-end">
            <md-button class="md-icon-button">
              <md-icon>more_vert</md-icon>
            </md-button>
          </div>
        </div>

        <div class="md-toolbar-row">
          <md-tabs class="md-primary" md-sync-route>
            <md-tab id="tab-home" md-label="Home" to="/"></md-tab>
            <md-tab :md-disabled="$store.state.user != null" id="tab-login" md-label="Login" to="/login"></md-tab>
            <md-tab :md-disabled="$store.state.user != null" id="tab-register" md-label="Register" to="/register"></md-tab>
            <md-tab :md-disabled="$store.state.user == null" id="tab-servers" md-label="My servers" to="/servers"></md-tab>
          </md-tabs>
        </div>
      </md-app-toolbar>

      <md-app-drawer :md-active.sync="menuVisible">
        <md-toolbar class="md-transparent" md-elevation="0">Navigation</md-toolbar>

        <md-list>
          <md-list-item>
            <md-icon>move_to_inbox</md-icon>
            <span class="md-list-item-text">Inbox</span>
          </md-list-item>

          <md-list-item>
            <md-icon>send</md-icon>
            <span class="md-list-item-text">Sent Mail</span>
          </md-list-item>

          <md-list-item>
            <md-icon>delete</md-icon>
            <span class="md-list-item-text">Trash</span>
          </md-list-item>

          <md-list-item>
            <md-icon>error</md-icon>
            <span class="md-list-item-text">Spam</span>
          </md-list-item>
        </md-list>
      </md-app-drawer>

      <md-app-content>
        <transition mode="out-in" name="page">
            <router-view></router-view>
        </transition>
        <md-snackbar md-position="center" :md-active.sync="$store.state.messageShow" md-persistent>
            <span>{{ $store.state.message }}</span>
            <md-button class="md-accent" @click="$store.commit('messageShow', false)">Close</md-button>
        </md-snackbar>
      </md-app-content>
    </md-app>
  </div>
</template>

<style lang="scss" scoped>
  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
  }
</style>

<script>
export default {
  name: 'LastRowFixed',
  data: () => ({
    menuVisible: false
  })
}
</script>