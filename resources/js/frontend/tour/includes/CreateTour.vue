<template>
  <v-flex> 
    <form
      method="POST" 
      action="/operator/tour"
    >
      <input
        type="hidden"
        name="_method"
        value="POST"
      >
      <input 
        type="hidden" 
        name="_token" 
        :value="token"
      >   
      <input 
        type="hidden" 
        name="name" 
        :value="tour.name"
      > 
      <input 
        type="hidden" 
        name="tour_type_id" 
        :value="tour.tour_type_id"
      > 
      <input 
        type="hidden" 
        name="cities_list[]" 
        :value="tour.cities_list"
      > 
      <input 
        type="hidden" 
        name="duration" 
        :value="tour.duration"
      > 
      <input 
        type="hidden"
        :value="extraWithNewDate"
        name="extra"
      > 
      <v-btn 
        dark
        color="green"
        type="submit"
      >
        Создать тур
      </v-btn>
    </form>
  </v-flex>
</template>
<script>
export default {
  name: 'CreateTour',
  props: {
    token: {
      type: String,
      default: ''
    },
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
    dateStart: {
      type: String,
      default: '',
    }
  },
  data() {
    return {
      key: ''
    }
  },
  computed: {
    extraWithNewDate: function() {
      let tourExtra = JSON.parse(this.tour.extra)
      tourExtra.options.dateStart = this.dateStart
      return JSON.stringify(tourExtra)
    }
  },
  mounted() {
    console.log(JSON.parse(this.tour.extra))
    console.log(this.dateStart)
  }
}
</script>