<template>
  <v-row>
    <v-col cols="12">
      <h2 class="grey--text">
        Выберите сопровождающего:
      </h2>
      <v-row justify-center>
        <v-col
          v-for="attendant in actualAttendants"
          :key="attendant.id"
        >
          <Attendant
            :attendant="attendant"
            :days="days"
            :tour-date="tourDate"
            :tour-id="tourId"
            :was-selected="selectedAttendantsIds.includes(attendant.id)"
            :customers="customers"
          />
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
import Attendant from './Attendant'
export default {
  name: 'ChooseAttendant',
  components: {
    Attendant,
  },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      actualAttendants: [],
      days: 0,
      tourDate: null,
      selectedAttendantsIds: [],
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
    this.fetchMuseums()
  },
  methods: {
    fetchObjects() {
      axios
        .get('/api/get-detailed-tour-objects', {
          params: {
            tour_id: this.tourId,
            model_alias: 'attendant',
          },
        })
        .then(r => {
          this.actualAttendants = r.data.attendant_options
          this.days = r.data.days
          this.tourDate = r.data.tour_date
          this.selectedAttendantsIds = r.data.choosen_attendants
          this.customers = r.data.customers
        })
    },
    fetchMuseums() {
      axios
        .get('/api/get-detailed-tour-excursions', {
          params: {
            tour_id: this.tourId,
          },
        })
        .then(r => (this.museums = r.data))
    },
  },
}
</script>

<style lang="css" scoped>
.attendant-card {
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
