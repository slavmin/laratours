export default {
  actions: {
    async addTourId({ commit }, id) {
      commit('pushTourId', id)
    },
    async removeTourId({ commit }, id) {
      commit('filterTourId', id)
    }
  },
  mutations: {
    pushTourId(state, id) {
      state.tourIds.push(id)
    },
    filterTourId(state, id) {
      state.tourIds = state.tourIds.filter(tourId => tourId != id)
    }
  },
  state: {
    tourIds: [],
  },
  getters: {
    getTourIdsToRemove(state) {
      return state.tourIds
    }
  }
}