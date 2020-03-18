<template>
  <div>
    <v-row>
      <v-col cols="12">
        <h2 class="grey--text">
          Допы и персонал:
        </h2>
      </v-col>
    </v-row>
    <TourExtras :tour-id="tourId" />
    <!-- <TourPersonal /> -->
  </div>
</template>
<script>
import TourExtras from './TourExtras'
// import TourPersonal from './TourPersonal'
export default {
  name: 'ChooseServices',
  components: {
    TourExtras,
    // TourPersonal,
  },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
}
</script>