export default {
  actions: {},
  mutations: {},
  state: {
    availableLanguages: [
      { id: 1, name: 'Русский'},
      { id: 2, name: 'Английский'},
      { id: 3, name: 'Немецкий'},
      { id: 4, name: 'Французский'},
      { id: 5, name: 'Китайский'},
      { id: 6, name: 'Испанский'},
      { id: 7, name: 'Итальянский'},
      { id: 8, name: 'Финский'}
    ],
  },
  getters: {
    allAvailableLanguages(state) {
      return state.availableLanguages
    }
  }
}