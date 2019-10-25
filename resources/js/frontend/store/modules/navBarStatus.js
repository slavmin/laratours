export default {
  actions: {
    updateNavBarStatus({ commit }, data) {
      commit('setNavBarStatus', data)
    },
    updateUserName({ commit }, name) {
      commit('setUserName', name)
    }
  },
  mutations: {
    setNavBarStatus(state, data) {
      if (data.status == 'auth') {
        state.auth = data.flag
      }
      if (data.status == 'guest') {
        state.guest = data.flag
      }
      if (data.status == 'operator') {
        state.operator = data.flag
      }
      if (data.status == 'agency') {
        state.agency = data.flag
      }
    },
    setUserName(state, name) {
      state.userName = name
      console.log(state)
    }
  },
  state: {
    auth: false,
    guest: false,
    operator: false,
    agency: false,
    userName: '',
  },
  getters: {
    getAuthStatus(state) {
      return state.auth
    },
    getGuestStatus(state) {
      return state.guest
    },
    getNavBarStatue(state) {
      return state
    }
  }
}