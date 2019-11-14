export default {
  actions: {
    async updateOrderedSeats({ commit }, seats) {
      commit('setOrderedSeats', seats)
    },
    async updateSeatsInCurrentOrder({ commit }, seat) {
      commit('setSeatsInCurrentOrder', seat)
    },
    async removeSeatFromCurrent({ commit }, seat) {
      commit('filterCurrentSeats', seat)
    },
    async updateOrderProfiles({ commit }, id) {
      commit('setOrderProfiles', id)
    },
    async updatePriceList({ commit }, priceList) {
      commit('setPriceList', priceList)
    },
    async updateChdRange({ commit }, priceList) {
      commit('setChdRange', priceList)
    },
    async updatePensRange({ commit }, priceList) {
      commit('setPensRange', priceList)
    },
    async updateMealByDay({ commit }, tour) {
      commit('setMealByDay', tour)
    },
    async updateProfileMeal({ commit }, data) {
      commit('setProfileMeal', data)
    },
    updateProfileExtraEvents({ commit }, data) {
      commit('setProfileExtraEvents', data)
    },
    async updateProfilePrice({ commit }, data) {
      commit('setProfilePrice', data)
    },
    async updateOrderPrice({ commit }) {
      commit('setOrderPrice')
    },
    async updateOrderCommission({ commit }){
      commit('setOrderCommission')
    },
    async resetProfile({ commit }, profileId) {
      commit('clearProfile', profileId)
    },
    async updateResetProfileFlag({ commit }, profileId) {
      commit('toggleProfileFlag', profileId)
    },
    async updateEditMode({ commit }) {
      commit('setEditMode')
    },
    updateProfilesData({ commit }, data) {
      commit('fillProfilesData', data)
    },
    async updateProfileBusSeatId({ commit }, data) {
      commit('setProfileBusSeatId', data)
    },
    async removeBusSeatIdFromCurrent({ commit }, data) {
      commit('delBusSeatIdFromCurrent', data)
    },
    async updateOrderContacts({commit}, contacts) {
      commit('setOrderContacts', contacts)
    },
    async updateOrderStatus({ commit }, status) {
      commit('setOrderStatus', status)
    },
    async updateExtraEvents({ commit }, tour) {
      commit('setExtraEvents', tour)
    },
  },
  mutations: {
    setEditMode(state) {
      state.editMode = true
    },
    setOrderedSeats(state, seats) {
      state.orderedSeats = seats
    },
    setSeatsInCurrentOrder(state, seat) {
      state.seatsInCurrentOrder.push(seat)
      state.seatsInCurrentOrder = _.uniq(state.seatsInCurrentOrder)
    },
    filterCurrentSeats(state, choosenSeat) {
      if (choosenSeat){
        state.seatsInCurrentOrder = state.seatsInCurrentOrder.filter(seat => seat != choosenSeat)
      }
    },
    setOrderProfiles(state, id) {
      state.profiles.push({
        id: id,
        name: '',
        address: '',
        price: 0,
        commission: 0,
        mealPrice: 0,
        mealPriceArray: [],
        mealByDay: [],
        priceWithoutMeal: 0,
        resetProfile: 0,
        isPens: false,
        isForeigner: false,
        isSinglePlace: false,
        isRfIntPass: false,
        busSeatId: '',
        extraEventsPrice: 0,
        extraEventsCommission: 0,
        extraEventsIdArray: [],
      })
      if (state.editMode) {
        let profile = _.last(state.profiles)
        profile.mealByDay = state.mealByDay
        profile.mealPrice = state.defaultMealPrice
        profile.mealPriceArray = state.defaultMealPriceArray
      }
    },
    setPriceList(state, priceList) {
      state.priceList = priceList
    },
    setChdRange(state, priceList) {
      priceList.forEach((item) => {
        if (item.age && !JSON.parse(item.age).isPens) {
          const data = JSON.parse(item.age)
          if (state.chdRange.from > data.ageFrom) state.chdRange.from = data.agefrom
          if (state.chdRange.to < data.ageTo) state.chdRange.to = data.ageTo
        }
      })
    },
    setPensRange(state, priceList) {
      priceList.forEach((item) => {
        if (item.age && JSON.parse(item.age).isPens) {
          const data = JSON.parse(item.age)
          state.pensRange = {
            maleFrom: data.agePensMale,
            femaleFrom: data.agePensFemale,
          }
        }
      })
    },
    setMealByDay(state, tour) {
      let result = []
      const daysCount = parseInt(JSON.parse(tour.extra).options.days)
      for (let i = 0; i < daysCount; i++) {
        result.push([])
      } 
      JSON.parse(tour.extra).meal.forEach((meal) => {
        meal.obj.daysArray.forEach((day) => {
          let mealWithAlternatives = []
          mealWithAlternatives.push({
            name: 'Без питания',
            price: 0,
          })
          mealWithAlternatives.push({
            default: true,
            mealId: meal.obj.id,
            name: `${meal.meal.name}. ${meal.obj.name}, ${meal.obj.description}. (по-умолчанию)`,
            correction: parseInt(meal.correction),
            commission: parseInt(meal.commission),
            price: meal.obj.price + (meal.obj.price * meal.correction / 100),
          })
          meal.alternativeObj.forEach((alt) => {
            if (meal.obj.name == alt.name) {
              mealWithAlternatives.push({
                mealId: alt.id,
                name: `${meal.meal.name}. ${alt.name}, ${alt.description}`,
                correction: parseInt(meal.correction),
                commission: parseInt(meal.commission),
                price: alt.price + (alt.price * meal.correction / 100),
              })
            }
          })
          result[day - 1].push(mealWithAlternatives)
        })
      })
      state.mealByDay = result
      let defaultMealPriceArray = []
      state.mealCount = 0
      state.mealByDay.forEach((mealTime, index) => {
        defaultMealPriceArray[index] = []
        mealTime.forEach((mealMenu) => {
          let meal = mealMenu.find(menu => menu.default)
          let price = meal.price
          defaultMealPriceArray[index].push(price)
          state.mealCount += 1
        })
      })
      state.defaultMealPriceArray = defaultMealPriceArray
      state.defaultMealPrice = 0
      state.defaultMealPriceArray.forEach((day) => {
        day.forEach(price => state.defaultMealPrice += price)
      })
      if (!state.editMode) {
        state.profiles.forEach((profile) => {
          defaultMealPriceArray.forEach((day) => {
            let tmp = []
            day.forEach((price) => {
              tmp.push(price)
            })
            profile.mealPriceArray.push(tmp)
          })
        })
      }
      if (state.editMode) {
        state.profiles.forEach((profile) => {
          if (profile.mealByDay.length == 0) {
            profile.mealByDay = state.mealByDay
          }
          if (profile.mealPriceArray.length == 0) {
            profile.mealPriceArray = state.defaultMealPriceArray
          }
        })
      }
    },
    setProfileMeal(state, data) {
      let profile = state.profiles.find(profile => profile.id == data.profileId)
      profile.mealPriceArray[data.day - 1][data.index] = data.newMeal.price
      let mealPrice = 0
      profile.mealPriceArray.forEach((day) => {
        day.forEach(price => mealPrice += price)
      })
      profile.mealPrice = mealPrice
      if (profile.name != '') {
        profile.price = profile.priceWithoutMeal + profile.mealPrice
      }
      if (!state.editMode) profile.mealByDay = state.mealByDay
      let choosenMeal = profile.mealByDay[data.day - 1][data.index].find(meal => meal.name == data.newMeal.name)
      choosenMeal.manualChoose = true
      profile.mealByDay[data.day - 1][data.index].map((meal) => {
        if (meal.name != choosenMeal.name) {
          meal.manualChoose = false
        }
      })
    },
    setProfileExtraEvents(state, data) {
      let profile = state.profiles.find(profile => profile.id == data.profileId)
      if (data.profileChoosenExtraEvents.includes(data.event.id)) {
        // add event.commissionPrice to profile.price
        profile.extraEventsIdArray = data.profileChoosenExtraEvents
        profile.extraEventsPrice = profile.extraEventsPrice + data.event.commissionPrice
        profile.extraEventsCommission = profile.extraEventsCommission + 
          (data.event.commissionPrice - data.event.correctedPrice)
      }
      else {
        // remove event.commissionPrice from profile.price
        profile.extraEventsIdArray = data.profileChoosenExtraEvents
        profile.extraEventsPrice = profile.extraEventsPrice - data.event.commissionPrice
        profile.extraEventsCommission = profile.extraEventsCommission - 
          (data.event.commissionPrice - data.event.correctedPrice)
      }
    },
    setProfilePrice(state, data) {
      const pricelist = state.priceList
      let profile = state.profiles.find(profile => profile.id == data.profileId)
      profile.name = data.name
      let profilePrice = 0
      let profileCommission = 0
      switch (data.profileCustomerType) {
        case 'CHD':
          let price = pricelist.find((price) => {
            let age = JSON.parse(price.age)
            if (age && (age.ageFrom <= data.age && data.age < age.ageTo)) {
              return price
            }
          })
          // Hack to fix no-price if child younger than prices in pricelist
          if (!price) {
            price = pricelist.find((price) => {
              return price.isChd
            })
          }
          console.log(price)
          switch (data.profilePlace) {
            case 'EXTRA':
              profilePrice = price.commissionExtraPrice
              profileCommission = price.commissionExtraPrice - price.addPrice
              break
            case 'SNGL':
              profilePrice = price.commissionSinglePrice
              profileCommission = price.commissionSinglePrice - price.singlePrice
              break
            case 'STD':
              console.log(profilePrice)
              profilePrice = price.commissionStandardPrice
              profileCommission = price.commissionStandardPrice - price.standardPrice
              break
            default:
              console.log('error')
          }
          break
        case 'PENS':
          price = state.priceList.find((price) => price.age && JSON.parse(price.age).isPens)
          switch (data.profilePlace) {
            case 'EXTRA':
              profilePrice = price.commissionExtraPrice
              profileCommission = price.commissionExtraPrice - price.addPrice
              break
            case 'SNGL':
              profilePrice = price.commissionSinglePrice
              profileCommission = price.commissionSinglePrice - price.singlePrice
              break
            case 'STD':
              profilePrice = price.commissionStandardPrice
              profileCommission = price.commissionStandardPrice - price.standardPrice
              break
            default:
              console.log('error')
          }
          break
        case 'FRGN':
          price = state.priceList.find(price => price.name.includes('Иностр'))
          switch (data.profilePlace) {
            case 'EXTRA':
              profilePrice = price.commissionExtraPrice
              profileCommission = price.commissionExtraPrice - price.addPrice
              break
            case 'SNGL':
              profilePrice = price.commissionSinglePrice
              profileCommission = price.commissionSinglePrice - price.singlePrice
              break
            case 'STD':
              profilePrice = price.commissionStandardPrice
              profileCommission = price.commissionStandardPrice - price.standardPrice
              break
            default:
              console.log('error')
          }
          break
        case 'ADL':
          price = state.priceList.find(price => price.name.includes('Взросл'))
          switch (data.profilePlace) {
            case 'EXTRA':
              profilePrice = price.commissionExtraPrice
              profileCommission = price.commissionExtraPrice - price.addPrice
              break
            case 'SNGL':
              profilePrice = price.commissionSinglePrice
              profileCommission = price.commissionSinglePrice - price.singlePrice
              break
            case 'STD':
              profilePrice = price.commissionStandardPrice
              profileCommission = price.commissionStandardPrice - price.standardPrice
              break
            default:
              console.log('error', profile, priceList)
          }
          break
        default:
        console.log('error data: ', data, profile)
      }
      // console.log(profile.name)
      if (profile.name != '') {
        profile.price = profilePrice + profile.extraEventsPrice
        profile.commission = profileCommission + profile.extraEventsCommission
      }
      profile.priceWithoutMeal = 
        profilePrice - state.defaultMealPrice 
    },
    setOrderPrice(state) {
      let result = 0
      state.profiles.forEach(profile => result += parseInt(profile.price))
      state.orderPrice = result
    },
    setOrderCommission(state) {
      let result = 0
      state.profiles.forEach(profile => result += profile.commission)
      state.orderCommission = result
    },
    clearProfile(state, profileId) {
      let profile = state.profiles.find(profile => profile.id == profileId)
      profile.price = 0
      profile.commission = 0
      profile.priceWithoutMeal = 0
      profile.mealPriceArray = state.defaultMealPriceArray
      profile.mealPrice = state.defaultMealPrice
      profile.resetProfile = true
      profile.extraEventsPrice = 0
      profile.extraEventsCommission = 0
      profile.extraEventsIdArray = []
    },
    toggleProfileFlag(state, profileId) {
      let profile = state.profiles.find(profile => profile.id == profileId)
      profile.resetProfile = !profile.resetProfile
    },
    fillProfilesData(state, data) {
      for (let index in data) {
        let stateProfile = state.profiles[index]
        let dataProfile = data[index]
        console.log(stateProfile)
        stateProfile.address = dataProfile.address
        stateProfile.busSeatId = dataProfile.busSeatId
        stateProfile.dob = dataProfile.dob
        stateProfile.email = dataProfile.email
        stateProfile.gender = dataProfile.gender
        stateProfile.first_name = dataProfile.first_name
        stateProfile.last_name = dataProfile.last_name
        stateProfile.meal = dataProfile.meal
        stateProfile.mealByDay = JSON.parse(dataProfile.mealByDay).content
        stateProfile.mealPriceArray = JSON.parse(dataProfile.mealPriceArray).content
        stateProfile.passport = dataProfile.passport
        stateProfile.price = dataProfile.price
        stateProfile.room = dataProfile.room
        stateProfile.isPens = dataProfile.isPens == 'true' ? true : false
        stateProfile.isForeigner = dataProfile.isForeigner == 'true' ? true : false
        stateProfile.isSinglePlace = dataProfile.isSinglePlace == 'true' ? true : false
        stateProfile.isRfIntPass = dataProfile.isRfIntPass == 'true' ? true : false
        if (dataProfile.extraEventsData) {
          stateProfile.extraEventsPrice = JSON.parse(dataProfile.extraEventsData).content.extraEventsPrice
          stateProfile.extraEventsCommission = JSON.parse(dataProfile.extraEventsData).content.extraEventsCommission
          stateProfile.extraEventsIdArray = JSON.parse(dataProfile.extraEventsData).content.extraEventsIdArray
        }
        console.log(stateProfile, dataProfile)
      }
    },
    setProfileBusSeatId(state, data) {
      let profile = state.profiles.find(p => p.id == data.profileId)
      profile.busSeatId = data.busSeatId
    },
    delBusSeatIdFromCurrent(state, data) {
      console.log(state.seatsInCurrentOrder, data)
      let profile = state.profiles.find(p => p.id == data.profileId)
      profile.busSeatId = ''
      state.seatsInCurrentOrder = state.seatsInCurrentOrder.filter(s => s != data.busSeatId)
      console.log(profile, state)
    },
    setOrderContacts(state, contacts) {
      state.orderContacts = contacts
    },
    setOrderStatus(state, status) {
      state.orderStatus = status
    },
    setExtraEvents(state, tour) {
      state.extraEvents = JSON.parse(tour.extra).extraEvents
    }
  },
  state: {
    editMode: false,
    orderStatus: '',
    orderedSeats: [],
    seatsInCurrentOrder: [],
    chdRange: {
      from: 0,
      to: 8,
    },
    pensRange: {
      maleFrom: 60,
      femaleFrom: 55,
    },
    priceList: [],
    mealByDay: [],
    profiles: [],
    defaultMealPriceArray: [],
    defaultMealPrice: 0,
    orderPrice: 0,
    orderCommission: 0,
    mealCount: 0,
    orderContacts: {
      email: '',
      phone: '',
      name: '',
    },
    extraEvents: [],
  },
  getters: {
    getOrderedSeats(state) {
      return state.orderedSeats
    },
    getSeatsInCurrentOrder(state) {
      return state.seatsInCurrentOrder
    },
    getProfile: state => id => {
      return state.profiles.find(profile => profile.id == id)
    },
    getChdRange(state) {
      return state.chdRange
    },
    getPensRange(state) {
      return state.pensRange
    },
    getChdPrice: state => age => {
      let price = {}
      state.priceList.forEach((item) => {
        if (item.age && !JSON.parse(item.age).isPens) {
          const data = JSON.parse(item.age)
          if (age >= data.ageFrom && age < data.ageTo ) {
            price = item
          }
        }
      })
      return price
    },
    getPensPrice(state) {
      const price = state.priceList.find((item) => {
        return item.age && JSON.parse(item.age).isPens
      })
      return price
    },
    getMealByDay: state => data => {
      if (!state.editMode) {
        return state.mealByDay[data.day - 1]
      }
      if (state.editMode) {
        let profile = state.profiles.find(p => p.id == data.profileId)
        // If empty profile, return default meal
        if (profile.mealPriceArray.length == 0) {
          return state.mealByDay[data.day - 1]
        } 
        // Else, return meal by day from profile
        else {
          return profile.mealByDay[data.day - 1]
        }
      }
    },
    getDefaultMealPriceArray(state) {
      return state.defaultMealPriceArray
    },
    getProfilePrice: state => profileId => {
      const profile = state.profiles.find(profile => profile.id == profileId)
      if (profile) {
        return profile.price
      }
    },
    getProfileCommission: state => profileId => {
      const profile = state.profiles.find(profile => profile.id == profileId)
      if (profile) {
        return profile.commission
      }
    },
    getOrderPrice(state) {
      return state.orderPrice
    },
    getOrderCommission(state) {
      return state.orderCommission
    },
    getResetProfileFlag: state => profileId => {
      return state.profiles.find(profile => profile.id == profileId).resetProfile
    },
    getMealCount(state) {
      return state.mealCount
    },
    getProfileMealData: state => profileId => {
      const profile = state.profiles.find(profile => profile.id == profileId)
      if (profile) {
        return {
          mealByDay: profile.mealByDay,
          mealPriceArray: profile.mealPriceArray,
        }
      }
    },
    getProfileBusSeatId: state => profileId => {
      const profile = state.profiles.find(profile => profile.id == profileId)
      if (profile) {
        return profile.busSeatId
      }
    },
    getOrderContacts(state) {
      return state.orderContacts
    },
    getOrderStatus(state) {
      return state.orderStatus
    },
    getExtraEvents: state => data => {
      let result = []
      // console.log(data.profileCustomerType)
      state.extraEvents.forEach((extraEvent) => {
        const eventPriceList = JSON.parse(extraEvent.obj.extra).priceList
        // console.log(eventPriceList, extraEvent)
        let price = {}
        switch (data.profileCustomerType) {
          case 'CHD':
            price = eventPriceList.find((price) => {
              let age = JSON.parse(price.customerAge)
              // console.log(data.age, age)
              if (age && (age.ageFrom <= data.age && data.age < age.ageTo)) {
                return price
              }
            })
            // Hack to fix no-price if child younger than prices in pricelist
            if (!price) {
              price = eventPriceList.find(price => price.customerName.includes('Взросл'))         
            }
            // console.log('chd price: ', price, eventPriceList)

            break
          case 'PENS':
            price = eventPriceList.find((price) => price.customerAge && JSON.parse(price.customerAge).isPens)
            
            // console.log('pens price: ', price, eventPriceList)
            break
          case 'FRGN':
            price = eventPriceList.find(price => price.customerName.includes('Иностр'))
            
            // console.log('frgn price: ', price, eventPriceList)
            break
          case 'ADL':
            // console.log(eventPriceList)
            price = eventPriceList.find(price => price.customerName.includes('Взросл'))
            
            // console.log('adl price: ', price, eventPriceList)
            break
          default:
          // console.log('error in extra events: ', data)
        }
        let recalculatedEvent = Object.assign({}, extraEvent)
        recalculatedEvent.correctedPrice = price.price + 
          price.price * parseFloat(recalculatedEvent.correction) / 100
        recalculatedEvent.commissionPrice = recalculatedEvent.correctedPrice +
          recalculatedEvent.correctedPrice * parseFloat(recalculatedEvent.commission) / 100
        result.push(recalculatedEvent)
      })
      return result
    },
    getProfileExtraEventsData: state => profileId => {
      const profile = state.profiles.find(profile => profile.id == profileId)
      if (profile) {
        return {
          extraEventsPrice: profile.extraEventsPrice,
          extraEventsCommission: profile.extraEventsCommission,
          extraEventsIdArray: profile.extraEventsIdArray,
        }
      }
    },
  },
}
