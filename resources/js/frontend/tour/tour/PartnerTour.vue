<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
    >
      <v-flex>
        <h2 class="text-xs-center grey--text">
          Тур от партнёра
        </h2>
      </v-flex>
      <v-btn 
        dark
        fab
        class="done-btn"
        color="#aa282a"
        @click="done"
      >
        <i class="material-icons">
          arrow_forward
        </i>
      </v-btn>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'PartnerTour',
  data() {
    return {
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'getActualGuide',
      'getTour'
    ]),
  },
  methods: {
    done() {
      console.log('done')
    }
  }
};
</script>

<style lang="css" scoped>
.guide-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
