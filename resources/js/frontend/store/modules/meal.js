export default {
  actions: {
    async fetchMeal(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          const meal = response.data[0].meal_options
          console.log(meal)
          ctx.commit('updateMeal', meal)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateMeal(state, meal) {
      state.meal = meal
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