export default {
  actions: {
    async fetchCities(ctx) {
      axios.get('http://127.0.0.1:8000/api/tour-options')
        .then(response => {
          const countries = response.data[0].countries_cities_options
          let cities = []
          for (let key in countries[1].cities) {
            cities.push({
              id: key,
              name: countries[1].cities[key]
            })
          }
          ctx.commit('updateCities', cities)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateCities(state, cities) {
      state.cities = cities
    }
  },
  state: {
    cities: []
  },
  getters: {
    allCities(state) {
      return state.cities
    }
  }
}