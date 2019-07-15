export default {
  actions: {
    async fetchCustomerTypes(ctx) {
      axios.get('http://127.0.0.1:8000/api/tour-options')
        .then(response => {
          console.log(response)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateCustomerTypes(state, customerTypes) {
      state.customerTypes = customerTypes
    },
    incrementToken(state) {
      state.refreshToken += 1
    }
  },
  state: {
    customerTypes: [],
    refreshToken: 0
  },
  getters: {
    allCustomerTypes(state) {
      return state.customerTypes
    },
    refreshToken(state) {
      return state.refreshToken
    }
  }
}