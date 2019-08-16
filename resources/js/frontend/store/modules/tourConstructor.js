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
    async updateActualTransport({ commit }) {
      commit('setActualTransport')
    },
    async updateNewTransportOptions({ commit }, updData) {
      commit('setNewTransportOptions', updData)
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
    async updateActualMeal({ commit }) {
      commit('setActualMeal')
    },
    async updateTourMeal({ commit }) {
      commit('setTourMeal')
    },
    async updateActualGuide({ commit }) {
      commit('setActualGuide')
    },
    async updateNewMealOptions({ commit }, updData) {
      commit('setNewMealOptions', updData) //Toggle meal objectable 'selected'
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
    async updateTourName({ commit }, name) {
      commit('setTourName', name)
    },
    async updateTourTotalPrice({ commit }) {
      commit('calculateTourTotalPrice')
    },
    async updateTourCorrectedPrice({ commit }) {
      commit('calculateTourCorrectedPrice')
    },
    async updateCorrectionToAll({ commit }, correction) {
      commit('setCorrectionToAll', correction)
    },
    async updateCorrectedPriceValues({ commit }) {
      commit('setCorrectedPriceValues')
    }
  },
  mutations: {
    setAllTourOptions(state, tourOptions) {
      state.tourOptions = tourOptions
    },
    setTourOptions(state, options) {
      state.tour.options = options
    },
    setActualTransport(state) {
      let result = []
      console.log('setActualTransport')
      if (state.tourOptions.transport_options != undefined) {
          state.tourOptions.transport_options.map((item) => {
            if (state.tour.options.cities.indexOf(parseInt(item.city_id)) != -1) {
              result.push(item)
            }
          }
        )
      }
      result.forEach((transport) => {
        transport.objectables.forEach((obj) => {
          obj.selected = false
          obj.duration = {
            hours: 0,
            kilometers: 0,
            show: true,
          }
          obj.manualPrice = 0
        })
      })
      console.log('actual transport: ', result)
      state.actualTransport = result
    },
    setNewTransportOptions: (state, updData) => {
      let updTransport = updData.company
      let updItem = updData.item
      let itemIndex = updTransport.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updTransport.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualTransport.findIndex(transport => transport.id == updTransport.id)
      if (index != -1) {
        state.actualTransport.splice(index, 1, updTransport)
      }
    }, 
    setTourTransport(state) {
      state.tour.transport = []
      state.actualTransport.forEach((transport) => {
        transport.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.transport.push({ 
              transport, 
              obj,
              correction: 0,
              correctedPrice: 0,
            })
            const objQnt = JSON.parse(obj.extra).scheme.totalPassengersCount
            state.tour.qnt = objQnt 
          }
        })
      })
      console.log(state.tour.transport)
    },
    setConstructorCurrentStage(state, stage) {
      state.constructorCurrentStage = stage
    },
    setActualMuseum(state) {
      let result = []
      console.log('setActualMuseum')
      state.tourOptions.museum_options.map((museum) => {
          if (state.tour.options.cities.indexOf(parseInt(museum.city_id)) != -1) {
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
      let itemIndex = updMuseum.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updMuseum.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualMuseum.findIndex(museum => museum.id == updMuseum.id)
      if (index != -1) {
        state.actualMuseum.splice(index, 1, updMuseum)
      }
    }, 
    setTourMuseum: (state) => {
      state.tour.museum = []
      state.actualMuseum.forEach((museum) => {
        museum.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.museum.push({ 
              museum, 
              obj,
              correction: 0,
              correctedPrice: 0, 
            })
          }
        })
      })
    },
    setActualHotel(state) {
      let result = []
      console.log('setActualHotel')
      state.tourOptions.hotel_options.map((hotel) => {
          if (state.tour.options.cities.indexOf(parseInt(hotel.city_id)) != -1) {
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
      let itemIndex = updHotel.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updHotel.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualHotel.findIndex(hotel => hotel.id == updHotel.id)
      if (index != -1) {
        state.actualHotel.splice(index, 1, updHotel)
      }
    }, 
    setTourHotel: (state) => {
      state.tour.hotel = []
      state.actualHotel.forEach((hotel) => {
        hotel.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.hotel.push({ 
              hotel, 
              obj,
              correction: 0,
              correctedPrice: 0, 
            })
          }
        })
      })
    },
    setActualMeal(state) {
      let result = []
      console.log('setActualMeal')
      state.tourOptions.meal_options.map((meal) => {
          if (state.tour.options.cities.indexOf(parseInt(meal.city_id)) != -1) {
            result.push({
              ...meal
            })
          }
        }
      )
      result.forEach((meal) => {
          meal.objectables.forEach((obj) => {
            obj.selected = false
          })
        }
      )
      state.actualMeal = result
    },
    setNewMealOptions(state, updData) {
      let updMeal = updData.meal
      let updItem = updData.item
      let about = updData.about
      let itemIndex = updMeal.objectables.findIndex(obj => obj.id == updItem.id)
      if (itemIndex != -1) {
        updMeal.objectables.splice(itemIndex, 1, updItem)
      }
      const index = state.actualMeal.findIndex(meal => meal.id == updMeal.id)
      if (index != -1) {
        state.actualMeal.splice(index, 1, updMeal)
      }
    },
    setTourMeal(state) {
      state.tour.meal = []
      state.actualMeal.forEach((meal) => {
        meal.objectables.forEach((obj) => {
          if (obj.selected) {
            state.tour.meal.push({ 
              meal, 
              obj,
              correction: 0,
              correctedPrice: 0, 
            })
          }
        })
      })
    },
    setActualGuide(state) {
      let result = []
      state.tourOptions.guide_options.map((guide) => {
        let guideCity = JSON.parse(guide.description).city
          if (state.tour.options.cities.indexOf(parseInt(guideCity)) != -1) {
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
      const index = state.actualGuide.findIndex(guide => guide.id == updGuide.id)
      if (index != -1) {
        state.actualGuide.splice(index, 1, updGuide)
      }
    },  
    setTourGuide: (state) => {
      state.tour.guide = []
      state.actualGuide.forEach((guide) => {
        if (guide.selected) {
          state.tour.guide.push({
            guide,
            correction: 0,
            correctedPrice: 0,
          })
        }
      })
    },
    setActualAttendant(state) {
      let result = []
      state.tourOptions.attendant_options.map((attendant) => {
        let attendantCity = JSON.parse(attendant.description).city
          if (state.tour.options.cities.indexOf(parseInt(attendantCity)) != -1) {
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
      const index = state.actualAttendant.findIndex(attendant => attendant.id == updAttendant.id)
      if (index != -1) {
        state.actualAttendant.splice(index, 1, updAttendant)
      }
    },   
    setTourAttendant: (state) => {
      state.tour.attendant = []
      state.actualAttendant.forEach((attendant) => {
        if (attendant.selected) {
          state.tour.attendant.push({
            attendant,
            correction: 0,
            correctedPrice: 0,
          })
        }
      })
    },
    setCustomPrice: (state, price) => {
      state.tour.customPrice.push(price)
    },
    setMuseumInEditMode: (state, updData) => {
      state.tour.museum = updData
    },
    setEditorsContent: (state, content) => {
      state.tour.editorsContent = content
    },
    setTourName: (state, name) => {
      state.tour.options.name = name
    },
    calculateTourTotalPrice: (state) => {
      let summ = 0
      state.tour.transport.forEach((transport) => {
        summ += parseInt(transport.obj.price)
      })
      state.tour.museum.forEach((museum) => {
        summ += parseInt(JSON.parse(museum.obj.extra).priceList[0].price)
      })
      state.tour.hotel.forEach((hotel) => {
        summ += parseInt(hotel.obj.totalPrice)
      })
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.obj.price)
      })
      state.tour.guide.forEach((guide) => {
        summ += parseInt(guide.totalPrice)
      })
      state.tour.attendant.forEach((attendant) => {
        summ += parseInt(attendant.totalPrice)
      })
      state.tour.customPrice.forEach((price) => {
        summ += parseInt(price.value)
      })
      state.tour.totalPrice = summ
    },
    calculateTourCorrectedPrice: (state) => {
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
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.correctedPrice)
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
      state.tour.correctedPrice = summ
    },
    setCorrectionToAll: (state, correction) => {
      if (correction == NaN || correction == '') {
        correction = 0
      }
      state.tour.transport.forEach((transport) => {
        transport.correction = parseInt(correction)
      })
      state.tour.museum.forEach((museum) => {
        museum.correction = correction
      })
      state.tour.hotel.forEach((hotel) => {
        hotel.correction = correction
      })
      state.tour.meal.forEach((meal) => {
        meal.correction = correction
      })
      state.tour.guide.forEach((guide) => {
        guide.correction = correction
      })
      state.tour.attendant.forEach((attendant) => {
        attendant.correction = correction
      })
    },
    setCorrectedPriceValues(state) {
      console.log('hello from setcorrected')
      // Add price-fields to Transport
      state.tour.transport.forEach((transport) => {
        if (transport.correction > 0) {
          console.log(transport)
          transport.correctedPrice = 
            transport.obj.price + 
            (transport.obj.price * parseInt(transport.correction) / 100) 
        } else {
          transport.correctedPrice = transport.obj.price
        }
      })
      // Add price-fields to Museum
      state.tour.museum.forEach((museum) => {
        if (museum.correction > 0) {
          museum.correctedPrice = 
            JSON.parse(museum.obj.extra).priceList[0].price + 
            (JSON.parse(museum.obj.extra).priceList[0].price * museum.correction / 100) 
        } else {
          museum.correctedPrice = JSON.parse(museum.obj.extra).priceList[0].price
        }
      })
      // Add price-fields to Hotel
      state.tour.hotel.forEach((hotel) => {
        if (hotel.correction > 0) {
          hotel.correctedPrice = 
            parseInt(hotel.obj.totalPrice) + 
            (hotel.obj.totalPrice * hotel.correction / 100) 
        } else {
          hotel.correctedPrice = parseInt(hotel.obj.totalPrice)
        }
      })
      // Add price-fields to Meal
      state.tour.meal.forEach((meal) => {
        if (meal.correction > 0) {
          meal.correctedPrice = 
            parseInt(meal.obj.price) + 
            (meal.obj.price * meal.correction / 100) 
        } else {
          meal.correctedPrice = parseInt(meal.obj.price)
        }
      })
      // Add price-fields to Guide
      state.tour.guide.forEach((guide) => {
        if (guide.correction > 0) {
          guide.correctedPrice = 
            guide.totalPrice + 
            (guide.totalPrice * guide.correction / 100) 
        } else {
          guide.correctedPrice = guide.totalPrice
        }
      })
      // Add price-fields to Attendant
      state.tour.attendant.forEach((attendant) => {
        if (attendant.correction > 0) {
          attendant.correctedPrice = 
            attendant.totalPrice + 
            (attendant.totalPrice * attendant.correction / 100) 
        } else {
          attendant.correctedPrice = attendant.totalPrice
        }
      })
    }
  },
  state: {
    tourOptions: [],
    tour: {
      options: {
        name: '',
        tourType: 0,
        cities: [],
        tourGrade: [],
        tourLanguages: [1],
        days: NaN,
        nights: NaN,
        dateStart: new Date().toISOString().substr(0, 10),
      },
      transport: [],
      museum: [],
      hotel: [],
      meal: [],
      guide: [],
      attendant: [],
      customPrice: [],
      editorsContent: [],
      totalPrice: NaN,
      ordered: 0,
      qnt: 0,
    },
    constructorCurrentStage: 'Initial stage',
    // constructorCurrentStage: 'Guide is set',
    actualCities: [],
    actualMuseum: [],
    actualHotel: [],
    actualMeal: [],
    actualGuide: [],
    actualAttendant: [],
    actualTransport: [],
  },
  getters: {
    allState(state) {
      return state
    },
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
      return state.actualTransport
    },
    getActualMuseum(state) {
      return state.actualMuseum
    },
    getTour(state) {
      return state.tour
    },
    getActualHotel(state) {
      return state.actualHotel
    },
    getActualMeal(state) {
      return state.actualMeal
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
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.correctedPrice)
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
    },
    getTourName(state) {
      return state.tour.options.name
    }
  }
}