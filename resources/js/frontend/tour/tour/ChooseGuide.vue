<template>
  <v-row>
    <v-col cols="12">
      <h2 class="grey--text">
        Выберите гида:
      </h2>
      <v-row justify-center>
        <v-col
          v-for="guide in actualGuides"
          :key="guide.id"
        >
          <Guide
            :guide="guide"
            :days="days"
            :tour-date="tourDate"
            :tour-id="tourId"
            :was-selected="selectedGuidesIds.includes(guide.id)"
            :customers="customers"
          />
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>

<script>
import Guide from './Guide'
export default {
  name: 'ChooseGuide',
  components: {
    Guide,
  },
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
      selectedGuidesIds: [],
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
            model_alias: 'guide',
          },
        })
        .then(r => {
          console.log(r)
          this.actualGuides = r.data.guide_options
          this.days = r.data.days
          this.tourDate = r.data.tour_date
          this.selectedGuidesIds = r.data.choosen_guides
          this.customers = r.data.customers
        })
    },
  },
}
</script>

<style lang="css" scoped>
.guide-card {
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
