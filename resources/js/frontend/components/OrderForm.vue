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
          />
          <BusScheme
            edit-mode
            :transport="transport[0][0]"
            :profile-id="i"
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
    tourPrices: {
      type: Array,
      default: () => [],
    },
    customerOptions: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      panel: [0],
      customers: [],
      seatsInCurrentOrder: [],
    }
  },
  computed: {
    ...mapGetters({
      orderPrice: 'getOrderPrice',
    }),
    prices: function() {
      let result = []
      this.tourPrices.forEach(price => {
        result.push({
          value: parseFloat(price.price),
          text: this.customerOptions[price.tour_customer_type_id],
        })
      })
      return result
    },
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