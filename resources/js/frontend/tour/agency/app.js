import Vue from 'vue';
import Vuetify from 'vuetify'
Vue.use(Vuetify)
window.Vue = Vue;

Vue.component('agency-tours-index', require('./Index.vue').default);
Vue.component('agency-order-tour', require('./OrderTour.vue').default);
Vue.component('agency-orders-index', require('./Order/Index.vue').default);
Vue.component('agency-order-edit', require('./Order/OrderTour.vue').default);

/**
/**
/**
 * Vuex store
 *
 * shoom1337
 */
import store from './store'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#agency-wrap',
    store
});
