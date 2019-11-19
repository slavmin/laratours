export default {
  actions: {
    updateDrivers({ commit }, driver) {
      commit('addDrivers', driver)
    },
    removeDriver({ commit }, driver) {
      commit('delDriver', driver)
    }
  },
  mutations: {
    addDrivers(state, driver) {
      state.drivers.push(driver)
    },
    delDriver(state, driver) {
      state.drivers = state.drivers.filter(d => d != driver)
    }
  },
  state: {
    drivers: [],
    bus: {
      regNumber: '',
      diagCard: '',
      regCert: '',
      glonass: false,
      eraGlonass: true,
      insurance: '',
    },
  },
  getters: {
    getDrivers(state) {
      return state.drivers
    }
  }
}