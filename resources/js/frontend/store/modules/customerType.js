export default {
  actions: {
    async fetchCustomerTypes(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          console.log(response)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateCustomerTypes(state, customerTypes) {
      state.customerTypes = customerTypes
    }
  },
  state: {
    customerTypes: [],
    refreshToken: 0
  },
  getters: {
    allCustomerTypes(state) {
      return state.customerTypes
    }
  }
}