import Vue from 'vue'
import Vuetify from 'vuetify'
Vue.use(Vuetify)
window.Vue = Vue

Vue.component('tour-index', require('./Index.vue').default);
Vue.component('tour-add', require('./Add.vue').default);
Vue.component('tour-edit', require('./Edit.vue').default);
Vue.component('tour-routes', require('../../components/documents/TourRoutes.vue').default);
Vue.component('yandex-map', require('../../components/documents/YandexMap.vue').default);

/**
 * Vuex store
 *
 * shoom1337
 */
import store from './store.js'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#tour-constructor',
    store
});
