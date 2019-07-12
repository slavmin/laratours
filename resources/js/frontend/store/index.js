import Vue from 'vue'
import Vuex from 'vuex'
import post from './modules/post'
import transportCompanies from './modules/transportCompanies'
import transports from './modules/transports'

Vue.use(Vuex)

export default new Vuex.Store({
	modules: {
		post,
		transportCompanies,
		transports
	}
})