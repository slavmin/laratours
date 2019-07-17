export default {
  actions: {
    async fetchHotel(ctx) {
      axios.get('/api/tour-options')
        .then(response => {
          const hotel = response.data[0].hotel_options
          console.log(hotel)
          ctx.commit('updateHotel', hotel)
        })
        .catch(e => console.log(e))
    }
  },
  mutations: {
    updateHotel(state, hotel) {
      state.hotel = hotel
    }
  },
  state: {
    hotel: []
  },
  getters: {
    allHotel(state) {
      return state.hotel
    }
  }
}