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
    priceList: {},
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
    }
  },
}
