export default {
  actions: {
    updateNavBarStatus({ commit }, data) {
      commit('setNavBarStatus', data)
    },
    updateUserName({ commit }, name) {
      commit('setUserName', name)
    },
    updateActualLinks({ commit }, data) {
      commit('setActualLinks', data)
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
    },
    setActualLinks(state, data) {
      state.links = data
    }
  },
  state: {
    auth: false,
    guest: false,
    operator: false,
    agency: false,
    userName: '',
    links: [],
  },
  getters: {
    getAuthStatus(state) {
      return state.auth
    },
    getGuestStatus(state) {
      return state.guest
    },
    getNavBarStatus(state) {
      return state
    },
    getNavLinks(state) {
      return state.links
    }
  }
}