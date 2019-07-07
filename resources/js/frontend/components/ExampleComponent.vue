<template>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-code"></i> Example Vue Component
        </div>
        <div class="card-body">
            I'm an example Vue component!!!
        </div>
        <h2>Постов: {{ postsCount }}</h2>
        <div v-for="post in allPosts" :key="post.id">
            <h3>{{ post.title }}</h3>
            <p>{{ post.body }}</p>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    computed: mapGetters(['allPosts', 'postsCount']),
    methods: mapActions(['fetchPosts']),
    async mounted() {
        this.fetchPosts()
    }
}
</script>
