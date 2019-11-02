export default {
  actions: {
    updateCurrentScheme({ commit }, scheme) {
      commit('setCurrentScheme', scheme)
    }
  },
  mutations: {
    setCurrentScheme(state, scheme) {
      state.currentScheme = scheme
      console.log(state)
    }
  },
  state: {
    currentScheme: {},
    defaultScheme: {
      rows: 10,
      cols: 4,
      driver: ['1-1', '1-2'],
      doors: ['1-4'],
      guide: ['2-4'],
      pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
      unavailable: [],
      service: [],
      totalPassengersCount: 0,
    }
  },
  getters: {
    getCurrentScheme(state) {
      return state.currentScheme
    }
  }
}