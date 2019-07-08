export default{
  actions: {

  },
  mutations: {
    addTransport(state, transport) {
      state.transports.push(transport)
    },
    assignNewScheme(state, data) {
      state.transports.find((item) => {
        if (item.id === data.id) {
          item.scheme = data.scheme
          console.log(item)
        }
      })
    }
  },
  state: {
    transports: [
      { 
        id: 1, 
        name: 'Mercedes', 
        cityId: 2, 
        grade: ['Стандарт'], 
        qnt: 18, 
        transportCompanyId: 1,
        description: 'Кондиционер',
        scheme: {
          rows: 11,
          cols: 4,
          driver: ['1-1', '1-2'],
          doors: ['1-4'],
          guide: ['2-4'],
          pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3', '10-3'],
          unavailable: [],
          totalPassengersCount: 10
        }
      },
      { 
        id: 2, 
        name: 'Vokswagen', 
        cityId: 1, 
        grade: ['C-class', 'VIP'], 
        qnt: 22, 
        transportCompanyId: 2,
        description: 'Белый цвет',
        scheme: {
          rows: 8,
          cols: 4,
          driver: ['1-1'],
          doors: ['1-4'],
          guide: ['2-4'],
          pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3'],
          unavailable: ['1-2'],
          totalPassengersCount: 20
        }
      }
    ]
  },
  getters: {
    allTransports(state) {
      return state.transports
    }
  }
}