/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');
import vuetify from './plugins/vuetify'

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('index', require('./components/Index.vue').default);
// Vue.component('login', require('./components/Login.vue').default);
// Vue.component('branding', require('./components/Branding.vue').default);
// Vue.component('changelog', require('./components/Changelog.vue').default);
// Vue.component('reset-email', require('./components/ResetEmail.vue').default);
// Vue.component('reset-password', require('./components/ResetPassword.vue').default);
// Vue.component('transport-index', require('./tour/object/transport/Index.vue').default);
// Vue.component('customer-type-table', require('./tour/customer/type/Table.vue').default);
// Vue.component('customer-type-add', require('./tour/customer/type/Add.vue').default);
// Vue.component('museum-index', require('./tour/object/museum/Index.vue').default);
// Vue.component('hotel-index', require('./tour/object/hotel/Index.vue').default);
// Vue.component('meal-index', require('./tour/object/meal/Index.vue').default);
Vue.component('guide-index', require('./tour/object/guide/Index.vue').default);
Vue.component('attendant-index', require('./tour/object/attendant/Index.vue').default);
Vue.component('operator-orders-index', require('./tour/order/Index.vue').default);
Vue.component('operator-order-edit', require('./tour/order/OrderTour.vue').default);
// Vue.component('trash', require('./tour/includes/Trash.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);
// Vue.component('messages', require('./components/Messages.vue').default);
// Vue.component('footer-component', require('./components/Footer.vue').default);
// Vue.component('no-data', require('./components/NoData.vue').default);
Vue.component('documents-index', require('./components/documents/Index.vue').default);
Vue.component('document-add', require('./components/documents/Add.vue').default);
Vue.component('document-edit', require('./components/documents/Edit.vue').default);
Vue.component('pdf', require('./components/documents/public/PDF.vue').default);

Vue.component('cities-autocomplete', require('./components/CitiesAutocomplete.vue').default);
Vue.component('museum-objectable', require('./components/MuseumObjectable.vue').default);
Vue.component('hotel-objectable', require('./components/HotelObjectable.vue').default);
Vue.component('meal-objectable', require('./components/MealObjectable.vue').default);
Vue.component('transport-objectable', require('./components/TransportObjectable.vue').default);
Vue.component('object-attribute-price', require('./components/ObjectAttributePrice.vue').default);

window.Vuetify = require('vuetify');
Vue.use(Vuetify)

import store from './store'


const app = new Vue({
    vuetify,
    el: '#app',
    store,
    // data: () => ({
    //     drawer: null,
    //     drawerRight: false,
    // }),
});
