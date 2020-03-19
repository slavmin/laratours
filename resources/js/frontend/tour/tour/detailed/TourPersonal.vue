<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        "Бесплатные" взрослые
      </h3>
      <v-row justify-center>
        <v-col
          v-for="freeAdl in freeAdls"
          :key="freeAdl.id"
        >
          <FreeAdl
            :free-adl="freeAdl"
            :days="days"
            :tour-date="tourDate"
            :tour-id="tourId"
            :was-selected="freeAdl.hasOwnProperty('name')"
          />
        </v-col>
      </v-row>
      <v-btn
        dark
        color="#aa282a"
        @click="addFreeAdl"
      >
        <v-icon>add</v-icon>
      </v-btn>
    </v-col>
  </v-row>
</template>
<script>
import FreeAdl from './FreeAdl'
export default {
  name: 'TourPersonal',
  components: { FreeAdl },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      actualGuides: [],
      days: 0,
      tourDate: null,
      freeAdls: [],
      customers: [],
      museums: [],
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
    addFreeAdl() {
      this.freeAdls.push({})
    },
    fetchObjects() {
      axios
        .get('/api/get-detailed-tour-objects', {
          params: {
            tour_id: this.tourId,
            model_alias: 'freeadl',
          },
        })
        .then(r => {
          this.freeAdls = r.data.freeadls
          this.days = r.data.days
          this.tourDate = r.data.tour_date
          this.selectedGuidesIds = r.data.choosen_guides
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
.freeadl-card {
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