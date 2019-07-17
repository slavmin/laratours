export default {
  actions: {
    async fetchAllTourOptions(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          ctx.commit('updateTourOptions', response.data[0])
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateTourOptions(state, tourOptions) {
      state.tourOptions = tourOptions
    }
  },
  state: {
    tourOptions: [],
  },
  getters: {
    allTourOptions(state) {
      return state.tourOptions
    }
  }
}