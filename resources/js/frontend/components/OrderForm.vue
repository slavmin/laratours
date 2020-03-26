<template>
  <v-expansion-panels
    multiple
    :value="panel"
    popout
    focusable
    hover
  >
    <v-expansion-panel
      v-for="i in [0, 1, 2]"
      :key="i"
    >
      <v-expansion-panel-header>
        Турист {{ i + 1 }}
      </v-expansion-panel-header>
      <v-expansion-panel-content>
        <TouristForm
          :customer="customers[i]"
          :index="i"
        />
        <BusScheme
          edit-mode
          :transport="transport[0][0]"
          :profile-id="i"
        />
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<script>
import TouristForm from './TouristForm'
import BusScheme from './BusScheme'
import { mapActions } from 'vuex'
export default {
  name: 'OrderForm',
  components: { TouristForm, BusScheme },
  props: {
    old: {
      type: Object,
      default: () => {},
    },
    transport: {
      type: Array,
      default: () => [],
    },
    profiles: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      panel: [0],
      customers: [],
      seatsInCurrentOrder: [],
    }
  },
  mounted() {
    if (this.old !== undefined && this.old.hasOwnProperty('customer')) {
      this.customers = this.old.customer
    }
    this.orderedSeats()
  },
  methods: {
    ...mapActions(['updateOrderedSeats']),
    orderedSeats() {
      let result = []
      this.profiles.map(profile => {
        let content = Object.assign({}, profile.content)
        for (let key in content) {
          if (content[key].hasOwnProperty('busSeatId')) {
            result.push(content[key].busSeatId)
          }
        }
      })
      this.updateOrderedSeats(result)
    },
  },
}
</script>