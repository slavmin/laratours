<template>
  <v-row>
    <v-col cols="12">
      <h2 class="grey--text">
        Выберите музеи и экскурсии:
      </h2>
      <v-row
        v-for="museum in actualMuseums"
        :key="museum.id"
        justify-center
      >
        <v-col
          cols="12"
          class="display-2"
        >
          {{ museum.name }}
        </v-col>
        <v-col
          v-for="item in museum.objectables"
          :key="item.id"
        >
          <Excursion
            :museum="museum"
            :item="item"
            :days="days"
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
import Excursion from './Excursion'
export default {
  name: 'ChooseMuseum',
  components: {
    Excursion,
  },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      actualMuseums: [],
      days: 0,
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
            model_alias: 'museum',
          },
        })
        .then(r => {
          console.log(r)
          this.actualMuseums = r.data.museum_options
          this.days = r.data.days
          this.tourDate = r.data.tour_date
          this.selectedObjectAttributesIds = r.data.object_attributes
          this.customers = r.data.customers
        })
    },
  },
}
</script>

<style lang="css" scoped>
.museum-card {
  background-color: #e8f5e9;
}
.is-custom-order {
  background-color: rgb(77, 238, 187);
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
