import Vue from 'vue'
import Vuex from 'vuex'

import agencyOrder from '../../store/modules/agencyOrder'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        agencyOrder,
    }
})
