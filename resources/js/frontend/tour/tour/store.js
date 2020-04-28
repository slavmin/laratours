import Vue from 'vue'
import Vuex from 'vuex'

import tourConstructor from '../../store/modules/tourConstructor'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        tourConstructor,
    }
})
