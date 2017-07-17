require('./bootstrap');
import VTooltip from 'v-tooltip';

Vue.use(VTooltip);
window.eventBus = new Vue({})

Vue.component('init', require('./components/Init.vue'));
Vue.component('user-list', require('./components/admin/UserList.vue'));
Vue.component('user-create', require('./components/admin/UserCreate.vue'));
Vue.component('activity', require('./components/profile/Activity.vue'));
Vue.component('user-detail-edit', require('./components/profile/UserDetailEdit.vue'));
Vue.component('change-password', require('./components/profile/ChangePassword.vue'));
Vue.component('upload-avatar', require('./components/profile/UploadAvatar.vue'));
Vue.component('avatar', require('./components/profile/Avatar.vue'));
Vue.component('user-widget', require('./components/admin/dashboard/UserWidget.vue'));

// Area
Vue.component('area-list', require('./components/admin/area/AreaList.vue'));
Vue.component('area-form', require('./components/admin/area/AreaForm.vue'));
Vue.component('area-buttons', require('./components/admin/area/AreaButtons.vue'));

// Market
Vue.component('market-buttons', require('./components/admin/market/MarketButtons.vue'));
Vue.component('market-insert-form', require('./components/admin/market/MarketInsertForm.vue'));
Vue.component('market-list', require('./components/admin/market/MarketList.vue'));
Vue.component('init-market', require('./components/admin/market/InitMarket.vue'));
Vue.component('market-photo', require('./components/admin/market/MarketPhoto.vue'));
Vue.component('market-edit', require('./components/admin/market/MarketEdit.vue'));
Vue.component('market-map', require('./components/admin/market/MarketMap.vue'));


import moment from 'moment';
import {
  store
} from './store'
const app = new Vue({
    el: '#app',
    store
});
