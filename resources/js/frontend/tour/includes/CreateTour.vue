<template>
  <v-flex> 
    {{ dateStart }}
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
      <v-btn 
        color="red"
        @click="sendRequest"
      >
        text
      </v-btn>
    </form>
  </v-flex>
</template>
<script>
function* queue(data) {
  for (let i = 0; i < data.length; i++) {
    yield data[i]
  }
  return 'end'
}
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
      type: Array,
      default: () => {
        return []
      },
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
    },
    arrayOfTours: function() {
      let result = []
      let tour = Object.assign({}, this.tour)
      let tourExtra = JSON.parse(this.tour.extra)
      this.dateStart.forEach((date) => {
        tourExtra.options.dateStart = this.dateStart
        tour.extra = JSON.stringify(tourExtra)
        result.push(tour)
      })
      return result
    }
  },
  mounted() {
    console.log(JSON.parse(this.tour.extra))
    console.log(this.dateStart)
  },
  methods: {
    sendRequest() {
      const q = queue(this.arrayOfTours)
      let flag = false
      while(!flag) {
        let data = q.next()
        console.log(data.value)
        flag = data.done
      }
    },
  }
}
</script>