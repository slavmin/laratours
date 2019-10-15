<template>
  <div>
    <h1>Hello, component!</h1>
    <div
      v-for="city in allCities"
      :key="city.id"
    >
      <p class="display-1 text-xs-center">
        {{ city.name }}
      </p>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'Test2',

  data() {
    return {

    };
  },
  computed: {
    ...mapGetters(['allCities']),
  },
  created() {
    this.fetchCities()
  },
  methods: {
    ...mapActions(['fetchCities'])
  },
};
</script>

<style lang="css" scoped>
</style>
