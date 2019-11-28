<template>
  <form
    method="POST" 
    :action="getEditMode ? `/operator/tour/${getTour.id}` :'/operator/tour'"
  >
    <input
      type="hidden"
      name="_method"
      :value="getEditMode ? 'PATCH' : 'POST'"
    >
    <input 
      type="hidden" 
      name="_token" 
      :value="token"
    >   
    <input 
      type="hidden" 
      name="name" 
      :value="getTour.options.name"
    > 
    <input 
      type="hidden" 
      name="tour_type_id" 
      :value="getTour.options.tourType"
    > 
    <input 
      type="hidden" 
      name="cities_list[]" 
      :value="getTour.options.cities"
    > 
    <input 
      type="hidden" 
      name="duration" 
      :value="getTour.options.days"
    > 
    <input
      v-for="(date, i) in getTour.options.dates"
      :key="i"
      type="text"
      name="dates[]"
      :value="date"
    >
    <input 
      type="hidden"
      :value="JSON.stringify(tourExtra)"
      name="extra"
    > 
    <v-btn 
      dark
      color="#aa282a"
      type="submit"
    >
      Сохранить тур
    </v-btn>
  </form>
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'SaveTourForm',
  props: {
    token: {
      type: String,
      default: ''
    },
  },
  computed: {
    ...mapGetters([
      'getEditMode',
      'getTour',

    ]),
    tourExtra: function() {
      return {
        ...this.getTour, 
      }
    },
  }
}
</script>