import Vue from 'vue'
import Vuex from 'vuex'
import post from './modules/post'
import transportCompanies from './modules/transportCompanies'
import transports from './modules/transports'
import customerType from './modules/customerType'

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		post,
		transportCompanies,
		transports,
		customerType,
	}
})