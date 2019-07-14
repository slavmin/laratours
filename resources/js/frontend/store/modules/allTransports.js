export default {
  actions: {
    async fetchTransport(ctx) {
      axios.get('http://127.0.0.1:8000/api/tour-options')
        .then(response => {
          const transport = response.data[0].transport_options
          ctx.commit('updateTransport', transport)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateTransport(state, transport) {
      state.transport = transport
    }
  },
  state: {
    transport: []
  },
  getters: {
    allTransports(state) {
      return state.transport
    }
  }
}