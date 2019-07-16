export default {
  actions: {
    async fetchMuseum(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          const museum = response.data[0].museum_options
          ctx.commit('updateMuseum', museum)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateMuseum(state, museum) {
      state.museum = museum
    }
  },
  state: {
    museum: []
  },
  getters: {
    allMuseum(state) {
      return state.museum
    }
  }
}