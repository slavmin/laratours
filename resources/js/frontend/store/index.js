import Vue from 'vue'
import Vuex from 'vuex'
import post from './modules/post'
import transportCompanies from './modules/transportCompanies'
import transport from './modules/allTransports'
import customerType from './modules/customerType'
import cities from './modules/cities'
import museum from './modules/museum'
import hotel from './modules/hotel'
import meal from './modules/meal'
import tourConstructor from './modules/tourConstructor'

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		post,
		transportCompanies,
		transport,
		customerType,
    cities,
    museum,
    hotel,
    meal,
    tourConstructor,
	}
})