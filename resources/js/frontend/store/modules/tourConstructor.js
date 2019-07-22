export default {
  actions: {
    async fetchAllTourOptions(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          ctx.commit('setAllTourOptions', response.data[0])
        })
        .catch(e => console.log(e))
    },
    async updateTourOptions({ commit }, options) {
      commit('setTourOptions', options)
    },
    async updateTourTransport({ commit }, transport) {
      commit('setTourTransport', transport)
    },
    async updateActualMuseum({ commit }) {
      commit('setActualMuseum')
    },
    async updateConstructorCurrentStage({ commit }, stage) {
      commit('setConstructorCurrentStage', stage)
    },
    async updateNewMuseumOptions({ commit }, updData) {
      commit('setNewMuseumOptions', updData) // Toggle museum objectable 'selected'
    },
    async updateTourMuseum({ commit }) {
      commit('setTourMuseum')
    },
  },
  mutations: {
    setAllTourOptions(state, tourOptions) {
      state.tourOptions = tourOptions
    },
    setTourOptions(state, options) {
      state.tour.options = options
      console.log(state)
    },
    setTourTransport(state, transport) {
      state.tour.transport.push(transport)
    },
    setConstructorCurrentStage(state, stage) {
      state.constructorCurrentStage = stage
    },
    setActualMuseum(state) {
      let result = []
      state.tourOptions.museum_options.map((museum) => {
          if (state.tour.options.cities.indexOf(museum.city_id) !== -1) {
            result.push({
              ...museum
            })
          }
        }
      )
      result.forEach((museum) => {
          museum.objectables.forEach((obj) => {
            obj.selected = false
          })
        }
      )
      state.actualMuseum = result
    },
    setNewMuseumOptions: (state, updData) => {
      let updMuseum = updData.museum
      let updItem = updData.item
      let itemIndex = updMuseum.objectables.findIndex(obj => obj.id === updItem.id)
      if (itemIndex !== -1) {
        updMuseum.objectables.splice(itemIndex, 1, updItem)
      }
      // const index = state.actualMuseum.findIndex(museum => museum.id === updMuseum.id)
      // if (index !== -1) {
      //   state.actualMuseum.splice(index, 1, updMuseum)
      // }
    }, 
    setTourMuseum: (state) => {
      state.actualMuseum.forEach((museum) => {
        museum.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.museum.push(obj)
          }
        })
      })
      console.log(state.tour)
    }
  },
  state: {
    tourOptions: [],
    tour: {
      options: {},
      transport: [],
      museum: [],
    },
    constructorCurrentStage: 'Initial stage',
    actualCities: [],
    actualMuseum: [],
  },
  getters: {
    allTourOptions(state) {
      return state.tourOptions
    },
    getConstructorCurrentStage(state) {
      return state.constructorCurrentStage
    },
    // getActualCities(state) {
    //   return state.tour.options.cities
    // },
    getActualTransport(state) {
      let result = []
      if (state.tourOptions.transport_options != undefined) {
          state.tourOptions.transport_options.map((item) => {
            if (state.tour.options.cities.indexOf(item.city_id) !== -1) {
              result.push(item)
            }
          }
        )
      }
      
      return result
    },
    getActualMuseum(state) {
      return state.actualMuseum
    },
    getTour(state) {
      return state.tour
    }
  }
}