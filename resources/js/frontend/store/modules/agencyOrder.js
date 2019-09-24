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
  },
  mutations: {
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
      state.orders.push({
        id: id,
        price: 0,
        mealPrice: 0,
        mealPriceArray: [],
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
      state.mealByDay.forEach((mealTime, index) => {
        defaultMealPriceArray[index] = []
        mealTime.forEach((mealMenu) => {
          let meal = mealMenu.find(menu => menu.default)
          let price = meal.price
          defaultMealPriceArray[index].push(price)
        })
      })
      state.defaultMealPriceArray = defaultMealPriceArray
      console.log(state)
      state.orders.forEach((order) => {
        defaultMealPriceArray.forEach((day) => {
          let tmp = []
          day.forEach((price) => {
            tmp.push(price)
          })
          order.mealPriceArray.push(tmp)
        })
        console.log(order)
      })
    },
    setProfileMeal(state, data) {
      let order = state.orders.find(order => order.id == data.profileId)
      order.mealPriceArray[data.day - 1][data.index] = data.newMeal.price
      let mealPrice = 0
      order.mealPriceArray.forEach((day) => {
        day.forEach(price => mealPrice += price)
      })
      order.mealPrice = mealPrice
      console.log(order.mealPrice)
    },
  },
  state: {
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
    orders: [],
    defaultMealPriceArray: [],
  },
  getters: {
    getOrderedSeats(state) {
      return state.orderedSeats
    },
    getSeatsInCurrentOrder(state) {
      return state.seatsInCurrentOrder
    },
    getProfile: state => id => {
      return state.orders.find(order => order.id == id)
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
  },
}
