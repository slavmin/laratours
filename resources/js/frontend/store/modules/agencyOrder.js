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
    async updateMealByDay({ commit }, tour) {
      commit('setMealByDay', tour)
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
            default: true,
            mealId: meal.obj.id,
            name: `${meal.meal.name}. ${meal.obj.name}, ${meal.obj.description}. (по-умолчанию)`,
            price: meal.obj.price,
          })
          meal.alternativeObj.forEach((alt) => {
            if (meal.obj.name == alt.name) {
              mealWithAlternatives.push({
                mealId: alt.id,
                name: `${meal.meal.name}. ${alt.name}, ${alt.description}`,
                price: alt.price,
              })
            }
          })
          result[day - 1].push(mealWithAlternatives)
        })
      })
      state.mealByDay = result
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
    mealByDay: [],
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
    getMealByDay: state => day => {
      return state.mealByDay[day - 1]
    }
  },
}
