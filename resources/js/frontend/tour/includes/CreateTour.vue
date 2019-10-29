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
      <!-- <v-btn 
        dark
        color="#aa282a"
        type="submit"
      >
        Создать тур
      </v-btn> -->
    </form>
    <v-layout
      row
      wrap
      align-center
    >
      <v-checkbox
        v-model="published"
        color="#aa282a"
        label="Опубликовать сразу"
      />
      <v-btn 
        dark
        :color="showLoader ? 'grey' : '#aa282a'"
        @click="sendRequest"
      >
        {{ showLoader ? 'Создаю' : 'Создать' }}
        <v-progress-circular
          v-show="showLoader"
          class="ml-2"
          :width="2"
          :size="18"
          color="white"
          indeterminate
        />
      </v-btn>
    </v-layout>
  </v-flex>
</template>
<script>
import axios from 'axios'
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
      url: '/operator/tour',
      showLoader: false,
      published: false,
      count: 0,
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
        tourExtra.options.dateStart = date
        tour.extra = JSON.stringify(tourExtra)
        result.push(tour)
      })
      return result
    }
  },
  mounted() {},
  methods: {
    sendRequest() {
      this.showLoader = true
      console.log(this.showLoader)
      let n = 0
      this.dateStart.forEach((date) => { 
        n++
        console.log(n) 
        let extra = JSON.parse(this.tour.extra)
        extra.options.dateStart = date
        let tour = {
          '_token': this.token,
          '_method': 'POST',
          name: this.tour.name,
          tour_type_id: this.tour.tour_type_id,
          cities_list: this.tour.cities_list,
          duration: this.tour.duration, 
          extra: JSON.stringify(extra),
          published: this.published,
        }
        axios.post(this.url, tour)
          .then(r => this.count += 1)
          .catch(e => console.log(e))
      })
      const time = this.dateStart.length * 200
      setTimeout(function() {
        document.location.reload(true)
      }, time)
    },
  }
}
</script>