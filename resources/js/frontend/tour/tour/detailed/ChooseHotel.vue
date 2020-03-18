<template>
  <v-row>
    <v-col cols="12">
      <h2 class="grey--text">
        Выберите размещение:
      </h2>
      <v-row
        v-for="hotel in actualHotels"
        :key="hotel.id"
        justify-center
      >
        <v-col
          cols="12"
          class="display-2"
        >
          {{ hotel.name }}
        </v-col>
        <v-col
          v-for="item in hotel.objectables"
          :key="item.id"
        >
          <Room
            :hotel="hotel"
            :item="item"
            :nights="nights"
            :tour-date="tourDate"
            :tour-id="tourId"
            :was-selected="selectedObjectAttributesIds.includes(item.id)"
            :customers="customers"
          />
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
import Room from './Room'
export default {
  name: 'ChooseHotel',
  components: {
    Room,
  },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      actualHotels: [],
      nights: 0,
      tourDate: null,
      selectedObjectAttributesIds: [],
      customers: [],
    }
  },
  computed: {
    daysArray: function() {
      let result = []
      for (let n = 1; n <= this.days; n++) result.push(n)
      return result
    },
  },
  mounted() {
    this.fetchObjects()
  },
  methods: {
    fetchObjects() {
      axios
        .get('/api/get-detailed-tour-objects', {
          params: {
            tour_id: this.tourId,
            model_alias: 'hotel',
          },
        })
        .then(r => {
          this.actualHotels = r.data.hotel_options
          this.nights = r.data.nights
          this.tourDate = r.data.tour_date
          this.selectedObjectAttributesIds = r.data.object_attributes
          this.customers = r.data.customers
        })
    },
  },
}
</script>

<style lang="css" scoped>
.hotel-card {
  background-color: #e8f5e9;
}
.is-selected {
  background-color: #ffab16;
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
