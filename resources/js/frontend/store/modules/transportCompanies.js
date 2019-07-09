export default{
  actions: {
    // async fetchPosts(ctx, limit = 5) {
    //  const res = await fetch('https://jsonplaceholder.typicode.com/posts?_limit=' + limit)
    //  const posts = await res.json()
    //  ctx.commit('updatePosts', posts)
    // }
    
  },
  mutations: {
    // updatePosts(state, posts) {
    //  state.posts = posts
    // }
    addTransportCompany(state, transportCompany) {
      state.transportCompanies.push(transportCompany)
    }
  },
  state: {
    transportCompanies: [
      { id: '1', name: 'ООО "Ромашка"'  },
      { id: '2', name: 'ИП Иванов И.И.'  }
    ]
  },
  getters: {
    allTransportCompanies(state) {
      return state.transportCompanies
    }
  }
}