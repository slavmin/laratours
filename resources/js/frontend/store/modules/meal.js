export default {
  actions: {
    async fetchMeal(ctx) {
      // axios.get('/api/tour-options')
      //   .then(response => {
      //     const meal = response.data[0]
      //     console.log(meal)
      //     ctx.commit('updateMeal', meal)
      //   })
      //   .catch(e => console.log(e))
    },
    async pushMealToStorage({ commit }, meal) {
      commit('updateMeal', meal)
    },
  },
  mutations: {
    updateMeal(state, meal) {
      state.meal = meal
      console.log(state.meal)
    }
  },
  state: {
    meal: []
  },
  getters: {
    allMeal(state) {
      return state.meal
    }
  }
}