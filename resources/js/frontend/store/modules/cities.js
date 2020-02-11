export default {
    actions: {
        async fetchCities(ctx) {
            axios.get('/api/tour-options')
                .then(response => {
                    const countries = response.data[0].countries_cities_options
                    let country = []
                    for (let key in countries) {
                        if (countries[key].name == 'Россия') {
                            country = countries[key]
                        }
                    }
                    let cities = []
                    for (let key in country.cities) {
                        cities.push({
                            id: parseInt(key),
                            name: country.cities[key]
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
