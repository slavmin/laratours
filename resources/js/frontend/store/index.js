import Vue from 'vue'
import Vuex from 'vuex'
import post from './modules/post'
import transportCompanies from './modules/transportCompanies'
import transport from './modules/allTransports'
import customerType from './modules/customerType'
import cities from './modules/cities'

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		post,
		transportCompanies,
		transport,
		customerType,
    cities,
	}
})