import Vue from 'vue'
import Vuex from 'vuex'

import transport from './modules/allTransports'

import cities from './modules/cities'

import guide from './modules/guide'
import attendant from './modules/attendant'
import languages from './modules/languages'

import tourConstructor from './modules/tourConstructor'
import tourTypes from './modules/tourTypes'

import agencyOrder from './modules/agencyOrder'
import operatorOrder from './modules/operatorOrder'
import orderList from './modules/orderList'

import deleteTours from './modules/deleteTours'

import navBar from './modules/navBar'

import transportDocs from './modules/transportDocs'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        transport,
        cities,
        guide,
        attendant,
        languages,
        tourConstructor,
        tourTypes,
        agencyOrder,
        operatorOrder,
        orderList,
        deleteTours,
        navBar,
        transportDocs,
    }
})
