export default {
  actions: {
    async fetchPosts(ctx, limit = 5) {
      const res = await fetch(
        'https://jsonplaceholder.typicode.com/posts?_limit=' + limit
      )
      const posts = await res.json()
      ctx.commit('updatePosts', posts)
    },
  },
  mutations: {
    updatePosts(state, posts) {
      state.posts = posts
    },
  },
  state: {
    posts: ['test', 'one', 'two'],
  },
  getters: {
    allPosts(state) {
      return state.posts
    },
    postsCount(state) {
      return state.posts.length
    },
  },
}
