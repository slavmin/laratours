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
import guide from './modules/guide'
import attendant from './modules/attendant'
import languages from './modules/languages'
import tourConstructor from './modules/tourConstructor'
import busScheme from './modules/busScheme'

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
    guide,
    attendant,
    languages,
    tourConstructor,
    busScheme,
	}
})