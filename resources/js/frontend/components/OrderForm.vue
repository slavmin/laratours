<template>
  <div>
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
            :prices="prices"
            :private-form="privateForm"
            :tour-date="tourDate"
          />
          <BusScheme
            edit-mode
            :transport="transport[0][0]"
            :profile-id="i"
            :choosen-seat="busSeats[i]"
          />
        </v-expansion-panel-content>
      </v-expansion-panel>
    </v-expansion-panels>
    <v-row justify="end">
      <v-col cols="12">
        <h5 class="text-right">
          Общая цена:
          <div class="display-1">
            {{ orderPrice }}
          </div>
        </h5>
        <input
          name="total_price"
          type="hidden"
          :value="orderPrice"
        >
      </v-col>
    </v-row>
  </div>
</template>

<script>
import TouristForm from './TouristForm'
import BusScheme from './BusScheme'
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'OrderForm',
  components: { TouristForm, BusScheme },
  props: {
    privateForm: {
      type: Boolean,
      default: false,
    },
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
    prices: {
      type: Array,
      default: () => [],
    },
    customerOptions: {
      type: Object,
      default: () => {},
    },
    tourDate: {
      type: String,
      default: null,
    },
  },
  data() {
    return {
      panel: [0],
      customers: [],
      seatsInCurrentOrder: [],
      busSeats: [],
    }
  },
  computed: {
    ...mapGetters({
      orderPrice: 'getOrderPrice',
    }),
  },
  created() {
    if (this.privateForm) {
      this.customers = this.old
      this.panel = []
      this.customers.forEach((customer, i) => {
        this.panel.push(i)
        this.busSeats.push(customer.busSeatId)
      })
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