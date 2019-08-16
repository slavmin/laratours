export default {
  actions: {
    async fetchTourTypes({ commit }) {
      axios.get('/api/tour-options/')
        .then(r => commit('setTourTypes', r.data[0].tour_type_options))
    }
  },
  mutations: {
    setTourTypes(state, types) {
      state.types = types
    }
  },
  state: {
    types: []
  },
  getters: {
    getTourTypes(state) {
      return state.types
    }
  },
}