/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../bootstrap');
import store from './store'
import vuetify from './plugins/vuetify'
window.Vuetify = require('vuetify');
window.Vue = require('vue');
Vue.use(Vuetify)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('operator-orders-index', require('./tour/order/Index.vue').default);
// Vue.component('operator-order-edit', require('./tour/order/OrderTour.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);

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

Vue.component('tour-create', require('./components/TourCreate.vue').default);
Vue.component('tour-edit', require('./components/TourEdit.vue').default);
Vue.component('partner-tour', require('./tour/tour/PartnerTour.vue').default);


const app = new Vue({
    vuetify,
    el: '#app',
    store,
    // data: () => ({
    //     drawer: null,
    //     drawerRight: false,
    // }),
});
