export default {
  actions: {
    async updateProfiles({ commit }, profiles) {
      commit('setProfiles', profiles)
    },
  },
  mutations: {
    setProfiles(state, profiles) {
      state.profiles = profiles
    },
  },
  state: {
    profiles: {},
    tours: [],
  },
  getters: {
    getProfiles(state) {
      return state.profiles
    },
  },
}