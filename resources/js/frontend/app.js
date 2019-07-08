
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '../bootstrap';
import '../plugins';
import Vue from 'vue';

window.Vue = Vue;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('object-prices-component', require('./components/ObjectPricesComponent.vue').default);
Vue.component('bus-scheme-component', require('./components/BusSchemeComponent.vue').default);
Vue.component('object-table-component', require('./tour/object/ObjectTableComponent.vue').default);
Vue.component('transport-price-component', require('./tour/object/transport/TransportPriceComponent.vue').default);
Vue.component('add-transport-component', require('./tour/object/transport/AddTransportComponent.vue').default);
Vue.component('transport-company-component', require('./components/TransportCompanyComponent.vue').default);

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
    el: '#app',
    store
});