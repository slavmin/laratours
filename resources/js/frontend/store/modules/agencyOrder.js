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
    async updatePriceList({ commit }, priceList) {
      commit('setPriceList', priceList)
    },
    async updateChdRange({ commit }, priceList) {
      commit('setChdRange', priceList)
    },
    async updatePensRange({ commit }, priceList) {
      commit('setPensRange', priceList)
    },
    async updateDefaultMeal({ commit }, tour) {
      commit('setDefaultMeal', tour)
    },
    async updateAlternativeMeal({ commit }, tour) {
      commit('setAlternativeMeal', tour)
    },
    async updateChoosenMeal({ commit }, choosenMeal) {
      commit('setChoosenMeal', choosenMeal)
    }
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
    setDefaultMeal(state, tour) {
      state.defaultMeal = []
      JSON.parse(tour.extra).meal.forEach((item) => {
        state.defaultMeal.push(item)
      })
      let defaultMealPrice = 0
      state.defaultMeal.forEach((item) => {
        defaultMealPrice += item.correctedPrice
      })
      state.defaultMealPrice = defaultMealPrice
    },
    setAlternativeMeal(state, tour) {
      let result = []
      JSON.parse(tour.extra).alternativeMeal.forEach((meal) => {
        result.push({...meal})
      })
      state.alternativeMeal = result
    },
    setChoosenMeal(state, choosenMeal) {
      if (choosenMeal.noMeal) {
        state.choosenMealPrice = 0 - state.defaultMealPrice
      }
      else {
        console.log(state, choosenMeal)
        const meal = state.alternativeMeal.find(item => item.id == choosenMeal.mealId)
        const obj = meal.objectables.find(item => item.id == choosenMeal.objId)
        state.choosenMealPrice = 0 - state.defaultMealPrice + obj.price
      }
    }
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
    defaultMeal: [{
      meal: { name: '' },
      obj: { name: ''},
      price: 0,
      correct: 0,
    }],
    defaultMealPrice: 0,
    alternativeMeal: [],
    choosenMealPrice: 0,
  },
  getters: {
    getOrderedSeats(state) {
      return state.orderedSeats
    },
    getSeatsInCurrentOrder(state) {
      return state.seatsInCurrentOrder
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
    getDefaultMeal(state) {
      return state.defaultMeal
    },
    getAlternativeMeal(state) {
      return state.alternativeMeal
    },
    getChoosenMealPrice(state) {
      return state.choosenMealPrice
    }
  },
}
