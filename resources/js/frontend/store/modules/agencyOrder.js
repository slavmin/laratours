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
    async updateProfilesData({ commit }, data) {
      commit('fillProfilesData', data)
    }
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
      })
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
      state.profiles.forEach((order) => {
        defaultMealPriceArray.forEach((day) => {
          let tmp = []
          day.forEach((price) => {
            tmp.push(price)
          })
          order.mealPriceArray.push(tmp)
        })
      })
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
      profile.mealByDay = state.mealByDay
      let choosenMeal = profile.mealByDay[data.day - 1][data.index].find(meal => meal.name == data.newMeal.name)
      choosenMeal.manualChoose = true
      if (data.prevMeal.manualChoose) data.prevMeal.manualChoose = false
    },
    setProfilePrice(state, data) {
      const pricelist = state.priceList
      let profile = state.profiles.find(profile => profile.id == data.profileId)
      profile.name = data.name
      let profilePrice = 0
      let profileCommission = 0
      console.log(state)
      switch (data.profileCustomerType) {
        case 'CHD':
          let price = pricelist.find((price) => {
            let age = JSON.parse(price.age)
            if (age && (age.ageFrom <= data.age && data.age < age.ageTo)) {
              return price
            }
          })
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
              console.log('error')
          }
          break
        default:
          console.log('error')
      }
      if (profile.name != '') {
        profile.price = profilePrice
        profile.commission = profileCommission
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
    },
    toggleProfileFlag(state, profileId) {
      let profile = state.profiles.find(profile => profile.id == profileId)
      profile.resetProfile = !profile.resetProfile
    },
    fillProfilesData(state, data) {
      for (let index in data) {
        let stateProfile = state.profiles[index]
        let dataProfile = data[index]
        stateProfile.address = dataProfile.address
        stateProfile.busSeatId = dataProfile.busSeatId
        stateProfile.dob = dataProfile.dob
        stateProfile.email = dataProfile.email
        stateProfile.gender = dataProfile.gender
        stateProfile.first_name = dataProfile.first_name
        stateProfile.last_name = dataProfile.last_name
        stateProfile.meal = dataProfile.meal
        stateProfile.mealByDay = dataProfile.mealByDay
        stateProfile.mealPriceArray = dataProfile.mealPriceArray
        stateProfile.passport = dataProfile.passport
        stateProfile.price = dataProfile.price
        stateProfile.room = dataProfile.room
        stateProfile.isPens = dataProfile.isPens == 'true' ? true : false
        stateProfile.isForeigner = dataProfile.isForeigner == 'true' ? true : false
        stateProfile.isSinglePlace = dataProfile.isSinglePlace == 'true' ? true : false
      }
    }
  },
  state: {
    editMode: false,
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
    getMealByDay: state => day => {
      return state.mealByDay[day - 1]
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
    }
  },
}
