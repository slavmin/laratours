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
      commit('setTourAlternativeMeal')
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
    },
    async updateEditTour({ commit }, tour) {
      commit('setEditTour', tour)
    },
    async updateCurrentCustomerType({ commit }, value) {
      commit('setCurrentCustomerType', value)
    },
    async generateTourCalcCustomerTypes({ commit }, customerTypes) {
      commit('setTourCalcCustomerTypes', customerTypes)
    },
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
      state.actualTransport = result
      state.tour.transport.forEach((selectedTransport) => {
        state.actualTransport.forEach((actualTransport) => {
          actualTransport.objectables.forEach((obj) => {
            if (obj.id == selectedTransport.obj.id) {
              obj.day = selectedTransport.obj.day
              obj.daysArray = selectedTransport.obj.daysArray
              obj.duration = selectedTransport.obj.duration
              obj.manualPrice = selectedTransport.obj.manualPrice
              obj.price = selectedTransport.obj.price
              obj.selected = selectedTransport.obj.selected
            }
          })
        })
      })
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
              pricePerSeat: parseInt(obj.price / state.tour.qnt),
              correctedPricePerSeat: 0,
            })
          }
        })
      })
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
      state.tour.museum.forEach((selectedMuseum) => {
        state.actualMuseum.forEach((actualMuseum) => {
          actualMuseum.objectables.forEach((obj) => {
            if (obj.id == selectedMuseum.obj.id) {
              obj.day = selectedMuseum.obj.day
              obj.price = selectedMuseum.obj.price
              obj.selected = selectedMuseum.obj.selected
              console.log(selectedMuseum.obj, obj)
            }
          })
        })
      })
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
      state.tour.hotel.forEach((selectedHotel) => {
        state.actualHotel.forEach((actualHotel) => {
          actualHotel.objectables.forEach((obj) => {
            if (obj.id == selectedHotel.obj.id) {
              obj.day = selectedHotel.obj.day
              obj.daysArray = selectedHotel.obj.daysArray
              obj.totalPrice = selectedHotel.obj.totalPrice
              obj.selected = selectedHotel.obj.selected
            }
          })
        })
      })
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
      state.tour.meal.forEach((selectedMeal) => {
        state.actualMeal.forEach((actualMeal) => {
          actualMeal.objectables.forEach((obj) => {
            if (obj.id == selectedMeal.obj.id) {
              obj.day = selectedMeal.obj.day
              obj.daysArray = selectedMeal.obj.daysArray
              obj.totalPrice = selectedMeal.obj.totalPrice
              obj.selected = selectedMeal.obj.selected
            }
          })
        })
      })
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
    setTourAlternativeMeal(state) {
      state.tour.alternativeMeal = state.actualMeal
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
              totalPrice: 0,
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
            pricePerSeat: parseInt(guide.totalPrice / state.tour.qnt)
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
              totalPrice: 0,
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
            pricePerSeat: parseInt(attendant.totalPrice / state.tour.qnt)
          })
        }
      })
    },
    setCustomPrice: (state, price) => {
      state.tour.customPrice.push({
        ...price,
        correction: 0,
        correctedPrice: 0,
        pricePerSeat: parseInt(price.value / state.tour.qnt)
      })
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
        summ += parseInt(transport.pricePerSeat)
      })
      state.tour.museum.forEach((museum) => {
        // Search price by current customer Id
        let price = JSON.parse(museum.obj.extra).priceList.find((item) => {
          return item.customerId == state.tour.calc.currentCustomer
        })
        // If event have no price with current customer Id set default customer
        if (price == undefined) price = JSON.parse(museum.obj.extra).priceList[state.tour.calc.defaultCustomer]
        summ += parseInt(price.price)
      })
      state.tour.hotel.forEach((hotel) => {
        summ += parseInt(hotel.obj.totalPrice)
        // CHD prices
        let isChd = false
        let currentPrice = state.tour.calc.priceList.find((item) => {
          return item.id == state.tour.calc.currentCustomer
        })
        isChd = currentPrice.isChd
        if (isChd) {
          summ -= parseInt(hotel.obj.totalPrice)
          const data = JSON.parse(hotel.obj.extra)
          const stdPrice = parseInt(data.priceList.chd.std)
          summ += (stdPrice * hotel.obj.day)
        }
      })
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.obj.totalPrice)
      })
      state.tour.guide.forEach((guide) => {
        summ += parseInt(guide.pricePerSeat)
      })
      state.tour.attendant.forEach((attendant) => {
        summ += parseInt(attendant.pricePerSeat)
      })
      state.tour.customPrice.forEach((price) => {
        summ += parseInt(price.pricePerSeat)
      })
      state.tour.totalPrice = summ
    },
    calculateTourCorrectedPrice: (state) => {
      let summ = 0
      let standardHotel = 0
      let singleHotel = 0
      let extraHotel = 0
      state.tour.transport.forEach((transport) => {
        summ += transport.correctedPricePerSeat
      })
      state.tour.museum.forEach((museum) => {
        summ += parseInt(museum.correctedPrice)
      })
      state.tour.meal.forEach((meal) => {
        summ += parseInt(meal.correctedPrice)
      })
      state.tour.guide.forEach((guide) => {
        summ += parseInt(guide.correctedPricePerSeat)
      })
      state.tour.attendant.forEach((attendant) => {
        summ += parseInt(attendant.correctedPricePerSeat)
      })
      state.tour.customPrice.forEach((price) => {
        summ += parseInt(price.correctedPricePerSeat)
      })
      state.tour.hotel.forEach((hotel) => {
        // ADL prices
        const data = JSON.parse(hotel.obj.extra)
        const stdPrice = parseInt(data.priceList.adl.std)
        standardHotel += parseInt(
          (stdPrice * hotel.obj.day)
          +
          (stdPrice * hotel.obj.day * hotel.correction) / 100
        )
        const singlePrice = parseInt(data.priceList.adl.sngl)
        singleHotel += parseInt(
          (singlePrice * hotel.obj.day)
          +
          (singlePrice * hotel.obj.day * hotel.correction) / 100
        )
        const extraPrice = parseInt(data.priceList.adl.extra)
        extraHotel += parseInt(
          (extraPrice * hotel.obj.day)
          + 
          (extraPrice * hotel.obj.day * hotel.correction) / 100
        )
        // CHD prices
        let isChd = false
        let currentPrice = state.tour.calc.priceList.find((item) => {
          return item.id == state.tour.calc.currentCustomer
        })
        isChd = currentPrice.isChd
        if (isChd) {
          standardHotel = 0
          extraHotel = 0
          console.log('chd mode')
          const stdPrice = parseInt(data.priceList.chd.std)
          standardHotel += parseInt(
            (stdPrice * hotel.obj.day)
            +
            (stdPrice * hotel.obj.day * hotel.correction) / 100
          )
          const extraPrice = parseInt(data.priceList.chd.extra)
          extraHotel += parseInt(
          (extraPrice * hotel.obj.day)
          + 
          (extraPrice * hotel.obj.day * hotel.correction) / 100
        )
        }
      })
      let calcCustomer = state.tour.calc.priceList.find((item) => {
        return item.id == state.tour.calc.currentCustomer
      })
      calcCustomer.standardPrice = summ + standardHotel
      calcCustomer.singlePrice = summ + singleHotel
      calcCustomer.addPrice = summ + extraHotel
      state.tour.correctedPrice = summ + standardHotel
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
      state.tour.customPrice.forEach((price) => {
        price.correction = correction
      })
    },
    setCorrectedPriceValues(state) {
      // Add price-fields to Transport
      state.tour.transport.forEach((transport) => {
        if (transport.correction > 0) {
          transport.correctedPricePerSeat = 
          parseInt(
            (transport.pricePerSeat + 
              transport.pricePerSeat * parseInt(transport.correction) / 100)
          )
        } else {
          transport.correctedPricePerSeat = parseInt(transport.pricePerSeat)
        }
      })
      // Add price-fields to Museum
      state.tour.museum.forEach((museum) => {
        // Search price by current customer Id
        let price = JSON.parse(museum.obj.extra).priceList.find((item) => {
          return item.customerId == state.tour.calc.currentCustomer
        })
        // If event have no price with current customer Id set default customer
        if (price == undefined) price = JSON.parse(museum.obj.extra).priceList[state.tour.calc.defaultCustomer]
        // Calculate corrected price
        if (museum.correction > 0) {
          museum.correctedPrice = 
            price.price + 
            (price.price * museum.correction / 100) 
        } else {
          museum.correctedPrice = price.price
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
            parseInt(meal.obj.totalPrice) + 
            (meal.obj.totalPrice * meal.correction / 100) 
        } else {
          meal.correctedPrice = parseInt(meal.obj.totalPrice)
        }
      })
      // Add price-fields to Guide
      state.tour.guide.forEach((guide) => {
        if (guide.correction > 0) {
          guide.correctedPricePerSeat = 
            guide.pricePerSeat + 
            (guide.pricePerSeat * guide.correction / 100) 
        } else {
          guide.correctedPricePerSeat = guide.pricePerSeat
        }
      })
      // Add price-fields to Attendant
      state.tour.attendant.forEach((attendant) => {
        if (attendant.correction > 0) {
          attendant.correctedPricePerSeat = 
            attendant.pricePerSeat + 
            (attendant.pricePerSeat * attendant.correction / 100) 
        } else {
          attendant.correctedPricePerSeat = attendant.pricePerSeat
        }
      })
      // Add price-fields to Custom Price (Services)
      state.tour.customPrice.forEach((price) => {
        if (price.correction > 0) {
          price.correctedPricePerSeat = 
          parseInt(price.pricePerSeat) + 
            (parseInt(price.pricePerSeat) * parseInt(price.correction) / 100) 
        } else {
          price.correctedPricePerSeat = parseInt(price.pricePerSeat)
        }
      })
    },
    setEditTour(state, tour) {
      state.tour = JSON.parse(tour.extra)
      state.editMode = true
      state.tour.id = tour.id
      console.log('edit tour: ',state.tour)
    },
    setCurrentCustomerType(state, value) {
      state.tour.calc.currentCustomer = value
    },
    setTourCalcCustomerTypes(state, customerTypes) {
      customerTypes.forEach((customer) => {
        if (customer.name.includes("Взрослый")) {
          state.tour.calc.defaultCustomer = customer.id
          state.tour.calc.currentCustomer = customer.id
        }
        state.tour.calc.priceList.push({
          ...customer,
          standardPrice: 0,
          singlePrice: 0,
          addPrice: 0,
          isChd: false,
          isInf: false,
        })
      })
    }
  },
  state: {
    editMode: false,
    tourOptions: [],
    tour: {
      id: NaN,
      options: {
        name: '',
        tourType: 0,
        cities: [],
        tourGrade: [],
        tourLanguages: [1],
        days: NaN,
        nights: NaN,
        dateStart: new Date().toISOString().substr(0, 10),
        qnt: 0,
      },
      transport: [],
      museum: [],
      hotel: [],
      meal: [],
      alternativeMeal: [],
      guide: [],
      attendant: [],
      customPrice: [],
      editorsContent: [],
      totalPrice: NaN,
      ordered: 0,
      qnt: 0,
      calc: {
        currentCustomer: 0,
        priceList: [],
      },
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
        summ += parseInt(transport.correctedPricePerSeat)
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
        summ += parseInt(price.correctedPricePerSeat)
      })
      return summ
    },
    getTourName(state) {
      return state.tour.options.name
    },
    getCurrentTourCustomers(state) {
      let result = []
      state.tour.museum.forEach((museum) => {
        JSON.parse(museum.obj.extra).priceList.forEach((price) => {
          result.push({
            id: price.customerId,
            name: price.customerName,
            age: price.customerAge,
          })
        })
      })
      return _.uniqWith(result, _.isEqual)
    },
    getTourCalc(state) {
      return state.tour.calc
    },
    getEditMode(state) {
      return state.editMode
    }
  }
}