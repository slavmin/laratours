export default {
    actions: {
        async updateEditorContent({
            commit
        }, content) {
            commit('setEditorContent', content)
        },
    },
    mutations: {
        setEditorContent(state, content) {
            state.partnerEditorContent = content
        }
    },
    state: {
        partnerEditorContent: ''
    },
    getters: {
        getEditorContent(state) {
            return state.partnerEditorContent
        }
    }
}
