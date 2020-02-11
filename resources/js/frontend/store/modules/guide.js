export default {
  actions: {
    async fetchGuide(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          const guide = response.data[0].guide_options
          ctx.commit('updateGuide', guide)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateGuide(state, guide) {
      state.guide = guide
    }
  },
  state: {
    guide: []
  },
  getters: {
    allGuide(state) {
      return state.guide
    }
  }
}