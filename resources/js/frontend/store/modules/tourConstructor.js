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
    async updateActualHotel({ commit }) {
      commit('setActualHotel')
    },
    async updateNewHotelOptions({ commit }, updData) {
      commit('setNewHotelOptions', updData) // Toggle hotel objectable 'selected'
    },
    async updateTourHotel({ commit }) {
      commit('setTourHotel')
    },
    async updateActualGuide({ commit }) {
      commit('setActualGuide')
    },
    async updateNewGuideOptions({ commit }, updGuide) {
      commit('setNewGuideOptions', updGuide) // Toggle guide 'selected'
    },
    async updateTourGuide({ commit }) {
      commit('setTourGuide')
    },
    async updateActualAttendant({ commit }) {
      commit('setActualAttendant')
    },
    async updateNewAttendantOptions({ commit }, updAttendant) {
      commit('setNewAttendantOptions', updAttendant) // Toggle attendant 'selected'
    },
    async updateTourAttendant({ commit }) {
      commit('setTourAttendant')
    },
    async updateCustomPrice({ commit }, customPrice) {
      commit('setCustomPrice', customPrice)
    },
    async updateEditorsContent({ commit }, content) {
      commit('setEditorsContent', content)
    },
    async updateMuseumInEditMode({ commit }, updData) {
      commit('setMuseumInEditMode', updData)
    },
    async updateEditorsContent({ commit }, content) {
      commit('setEditorsContent', content)
    },
  },
  mutations: {
    setAllTourOptions(state, tourOptions) {
      state.tourOptions = tourOptions
    },
    setTourOptions(state, options) {
      state.tour.options = options
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
            obj.day = 0
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
      const index = state.actualMuseum.findIndex(museum => museum.id === updMuseum.id)
      if (index !== -1) {
        state.actualMuseum.splice(index, 1, updMuseum)
      }
    }, 
    setTourMuseum: (state) => {
      state.actualMuseum.forEach((museum) => {
        museum.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.museum.push({ museum, obj })
          }
        })
      })
    },
    setActualHotel(state) {
      let result = []
      state.tourOptions.hotel_options.map((hotel) => {
          if (state.tour.options.cities.indexOf(hotel.city_id) !== -1) {
            result.push({
              ...hotel
            })
          }
        }
      )
      result.forEach((hotel) => {
          hotel.objectables.forEach((obj) => {
            obj.selected = false
            obj.day = 0
            obj.roomsCount = NaN
          })
        }
      )
      state.actualHotel = result
    },
    setNewHotelOptions: (state, updData) => {
      let updHotel = updData.hotel
      let updItem = updData.item
      let about = updData.about
      let itemIndex = updHotel.objectables.findIndex(obj => obj.id === updItem.id)
      if (itemIndex !== -1) {
        updHotel.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualHotel.findIndex(hotel => hotel.id === updHotel.id)
      if (index !== -1) {
        state.actualHotel.splice(index, 1, updHotel)
      }
    }, 
    setTourHotel: (state) => {
      state.actualHotel.forEach((hotel) => {
        hotel.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.hotel.push({ hotel, obj })
          }
        })
      })
    },
    setActualGuide(state) {
      let result = []
      state.tourOptions.guide_options.map((guide) => {
        let guideCity = JSON.parse(guide.description).city
          if (state.tour.options.cities.indexOf(guideCity) !== -1) {
            result.push({
              ...guide,
              selected: false,
              day: NaN,
              duration: NaN,
            })
          }
        }
      )
      state.actualGuide = result
    },
    setNewGuideOptions: (state, updGuide) => {
      const index = state.actualGuide.findIndex(guide => guide.id === updGuide.id)
      if (index !== -1) {
        state.actualGuide.splice(index, 1, updGuide)
      }
    },  
    setTourGuide: (state) => {
      state.actualGuide.forEach((guide) => {
        if (guide.selected) {
          state.tour.guide.push(guide)
        }
      })
    },
    setActualAttendant(state) {
      let result = []
      state.tourOptions.attendant_options.map((attendant) => {
        let attendantCity = JSON.parse(attendant.description).city
          if (state.tour.options.cities.indexOf(attendantCity) !== -1) {
            result.push({
              ...attendant,
              selected: false,
              day: NaN,
              duration: NaN,
              about: '',
            })
          }
        }
      )
      state.actualAttendant = result
    },
    setNewAttendantOptions: (state, updAttendant) => {
      const index = state.actualAttendant.findIndex(attendant => attendant.id === updAttendant.id)
      if (index !== -1) {
        state.actualAttendant.splice(index, 1, updAttendant)
      }
    },   
    setTourAttendant: (state) => {
      state.actualAttendant.forEach((attendant) => {
        if (attendant.selected) {
          state.tour.attendant.push(attendant)
        }
      })
    },
    setCustomPrice: (state, price) => {
      state.tour.customPrice.push(price)
    },
    setEditorsContent: (state, content) => {
      state.tour.editorsContent = content
    },
    setMuseumInEditMode: (state, updData) => {
      state.tour.museum = updData
    },
    setEditorsContent: (state, content) => {
      state.tour.editorsContent = content
    }
  },
  state: {
    tourOptions: [],
    tour: {
      options: {},
      transport: [],
      museum: [],
      hotel: [],
      guide: [],
      attendant: [],
      customPrice: [],
      editorsContent: [],
    },
    constructorCurrentStage: 'Initial stage',
    // constructorCurrentStage: 'Guide is set',
    actualCities: [],
    actualMuseum: [],
    actualHotel: [],
    actualGuide: [],
    actualAttendant: [],
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
      // Add price-fields to Transport
      state.tour.transport.forEach((transport) => {
        if (transport.correction > 0) {
          transport.correctedPrice = 
            transport.totalPrice + 
            (transport.totalPrice * transport.correction / 100) 
        } else {
          transport.correctedPrice = transport.totalPrice
        }
      })
      // Add price-fields to Museum
      state.tour.museum.forEach((museum) => {
        if (museum.correction > 0) {
          museum.correctedPrice = 
            museum.obj.price + 
            (museum.obj.price * museum.correction / 100) 
        } else {
          museum.correctedPrice = museum.obj.price
        }
      })
      // Add price-fields to Hotel
      state.tour.hotel.forEach((hotel) => {
        if (hotel.correction > 0) {
          hotel.correctedPrice = 
            hotel.obj.price + 
            (hotel.obj.price * hotel.correction / 100) 
        } else {
          hotel.correctedPrice = hotel.obj.price
        }
      })
      // Add price-fields to Guide
      state.tour.guide.forEach((guide) => {
        if (guide.correction > 0) {
          guide.correctedPrice = 
            guide.price + 
            (guide.price * guide.correction / 100) 
        } else {
          guide.correctedPrice = guide.price
        }
      })
      // Add price-fields to Attendant
      state.tour.attendant.forEach((attendant) => {
        if (attendant.correction > 0) {
          attendant.correctedPrice = 
            attendant.price + 
            (attendant.price * attendant.correction / 100) 
        } else {
          attendant.correctedPrice = attendant.price
        }
      })
      return state.tour
    },
    getActualHotel(state) {
      return state.actualHotel
    },
    getActualGuide(state) {
      return state.actualGuide
    },
    getActualAttendant(state) {
      return state.actualAttendant
    },
    getCustomPrice(state) {
      return state.tour.customPrice
    },
    getCorrectedPrice(state) {
      let summ = 0
      state.tour.transport.forEach((transport) => {
        summ += parseInt(transport.correctedPrice)
      })
      state.tour.museum.forEach((museum) => {
        summ += parseInt(museum.correctedPrice)
      })
      state.tour.hotel.forEach((hotel) => {
        summ += parseInt(hotel.correctedPrice)
      })
      state.tour.guide.forEach((guide) => {
        summ += parseInt(guide.correctedPrice)
      })
      state.tour.attendant.forEach((attendant) => {
        summ += parseInt(attendant.correctedPrice)
      })
      state.tour.customPrice.forEach((price) => {
        summ += parseInt(price.value)
      })
      return summ
    }
  }
}