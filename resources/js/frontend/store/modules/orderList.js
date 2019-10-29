export default {
  actions: {
    async updateTours({ commit }, orders) {
      commit('setTours', orders)
    }
  },
  mutations: {
    setTours(state, orders) {
      orders.forEach((order) => {
        if (state.tours.length === 0) {
          state.tours.push({
            tourId: order.tour_id,
            orders: [{...order}],
          })
        }
        else {
          let row = state.tours.find(tour => tour.tourId == order.tour_id)
          if (row) {
            row.orders.push(order)
          }
          else {
            state.tours.push({
              tourId: order.tour_id,
              orders: [{...order}]
            })
          }
        }
      })
    },
  },
  state: {
    tours: [],
  },
  getters: {
    getTours(state) {
      return state.tours
    },
  },
}