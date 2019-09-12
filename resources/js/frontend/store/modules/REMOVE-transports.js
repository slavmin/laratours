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
        }
      })
    },
    deleteTransport(state, transportId) {
      let delTransport = state.transports.find(item => item.id == transportId)
      state.transports = state.transports.filter(transport => transport !== delTransport)
    },
    editTransport(state, transport) {
      console.log(transport)
      let editTransport = state.transports.find(item => item.id == transport.id)
      console.log(editTransport)
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
        },
        prices: [1000, 2800, 7000, 15000]
      },
      { 
        id: 2, 
        name: 'Volkswagen', 
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
        },
        prices: [1200, 2900, 7500, 16000]
      },
      { 
        id: 3, 
        name: 'Газель NEXT', 
        cityId: 1, 
        grade: ['VIP'], 
        qnt: 22, 
        transportCompanyId: 2,
        description: 'Тонированая',
        scheme: {
          rows: 6,
          cols: 4,
          driver: ['1-1'],
          doors: ['1-4'],
          guide: ['2-4'],
          pass: ['1-3', '2-3', '3-3', '4-3', '5-3'],
          unavailable: ['1-2'],
          totalPassengersCount: 20
        },
        prices: [1500, 3000, 8000, 18000]
      }
    ]
  },
  getters: {
    allTransports(state) {
      return state.transports
    }
  }
}