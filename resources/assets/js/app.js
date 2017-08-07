require('./bootstrap');

import VTooltip from 'v-tooltip';
import moment from 'moment';
import VueMoment from 'vue-moment';
import VueLazyLoad from 'vue-lazyload'
import VueTouch from 'vue-touch'
Vue.use(VTooltip);
Vue.use(VueMoment);
Vue.use(VueLazyLoad)
Vue.use(VueTouch, { name: 'v-touch' })

window.eventBus = new Vue({})
require('./adminComponents');
require('./sellerComponents');

Vue.component('date-range', require('./components/VueDateRange.vue'));

// Supervisor
  // Seller
    Vue.component('seller-list', require('./components/supervisor/seller/SellerList.vue'));
    Vue.component('seller-create', require('./components/supervisor/seller/SellerCreate.vue'));
  // Seller
    Vue.component('seller-target-list', require('./components/supervisor/seller_target/SellerTargetList.vue'));
    Vue.component('seller-target-buttons', require('./components/supervisor/seller_target/SellerTargetButtons.vue'));
    Vue.component('seller-target-form', require('./components/supervisor/seller_target/SellerTargetForm.vue'));

import {
  store
} from './store'
const app = new Vue({
    el: '#app',
    store
});
