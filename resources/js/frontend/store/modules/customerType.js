export default {
  actions: {
    // async fetchCustomerTypes(ctx) {
    //   axios.get('/api/tour-options')
    //     .then(response => {
    //       console.log(response)
    //     })
    //     .catch(e => console.log(e))
    // }
  },
  mutations: {
    updateCustomerTypes(state, customerTypes) {
      state.customerTypes = customerTypes
    },
    // customerTypes: function() {
    //   let result = []
    //   Object.keys(this.customers).map((key) => {
    //     if (key != '') {
    //       result.push({
    //         id: key,
    //         name: this.customers[key]
    //       })
    //     }
    //   })
    //   return result
    // }
  },
  state: {
    customerTypes: [],
  },
  getters: {
    allCustomerTypes(state) {
      return state.customerTypes
    }
  }
}