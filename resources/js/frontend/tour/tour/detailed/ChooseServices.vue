<template>
  <div>
    <v-row>
      <v-col cols="12">
        <h2 class="grey--text">
          Допы
        </h2>
      </v-col>
    </v-row>
    <TourExtras :tour-id="tourId" />
    <TourPersonal :tour-id="tourId" />
    <hr />
    <TourProgram :tour-id="tourId" />
  </div>
</template>
<script>
import TourExtras from './TourExtras'
import TourPersonal from './TourPersonal'
import TourProgram from './TourProgram'
export default {
  name: 'ChooseServices',
  components: {
    TourExtras,
    TourPersonal,
    TourProgram,
  },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
}
</script>