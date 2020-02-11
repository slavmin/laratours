export default {
  actions: {
    async fetchAttendant(ctx) {
      axios.get('/api/tour-options')
        .then((response) => {
          const attendant = response.data[0].attendant_options
          ctx.commit('updateAttendant', attendant)
        })
        .catch(e => console.log(e))
    },
  },
  mutations: {
    updateAttendant(state, attendant) {
      state.attendant = attendant
    }
  },
  state: {
    attendant: []
  },
  getters: {
    allAttendant(state) {
      return state.attendant
    }
  }
}