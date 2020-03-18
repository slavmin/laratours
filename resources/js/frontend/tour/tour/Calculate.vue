<template>
  <div>
    <v-row>
      <v-col cols="6">
        <h2 class="grey--text">
          Калькуляция
        </h2>
      </v-col>
      <v-spacer />
      <v-col cols="3">
        <v-select
          v-model="selectedCustomerTypeId"
          :items="tourData.customers"
          color="#aa282a"
          item-text="name"
          item-value="id"
          label="Тип туриста"
        />
      </v-col>
    </v-row>
    <v-row v-if="selectedCustomerTypeId">
      <v-col cols="12">
        <Transport
          v-if="tourData.transport.length > 0"
          :items="tourData.transport"
        />
        <Museum
          v-if="tourData.museum.length > 0"
          :items="tourData.museum"
        />
        <Hotel
          v-if="tourData.hotel.length > 0"
          :items="tourData.hotel"
        />
        <Meal
          v-if="tourData.meal.length > 0"
          :items="tourData.meal"
        />
        <Guide
          v-if="tourData.guide.length > 0"
          :items="tourData.guide"
        />
        <Attendant
          v-if="tourData.attendant.length > 0"
          :items="tourData.attendant"
        />
        <Extra
          v-if="tourData.extras.length > 0"
          :items="tourData.extras"
        />
      </v-col>
      <v-overlay
        :value="loader"
        style="z-index: 10000;"
      >
        <v-progress-circular
          indeterminate
          size="64"
        />
      </v-overlay>
    </v-row>
    <v-divider />
    <v-row>
      <v-col cols="6">
        <h2 class="grey--text">
          Итого
        </h2>
      </v-col>
      <v-spacer />
      <v-col cols="3">
        <v-select
          v-model="selectedCustomerTypeId"
          :items="tourData.customers"
          color="#aa282a"
          item-text="name"
          item-value="id"
          label="Тип туриста"
        />
      </v-col>
    </v-row>
    <Total
      v-if="!loader"
      :tour-data="tourData"
      :customer-type-id="selectedCustomerTypeId"
      :adult-type-id="adultType.id"
    />
    <v-divider />
    <v-row>
      <v-col cols="6">
        <h2 class="grey--text">
          Цены для всех типов туристов
        </h2>
      </v-col>
    </v-row>
    <TotalForAll
      v-if="!loader"
      :tour-data="tourData"
      :tour-id="tourId"
    />
  </div>
</template>
<script>
import Transport from './detailed/calculate/Transport'
import Museum from './detailed/calculate/Museum'
import Hotel from './detailed/calculate/Hotel'
import Meal from './detailed/calculate/Meal'
import Guide from './detailed/calculate/Guide'
import Attendant from './detailed/calculate/Attendant'
import Extra from './detailed/calculate/Extra'
import Total from './detailed/calculate/Total'
import TotalForAll from './detailed/calculate/TotalForAll'
export default {
  name: 'Calculate',
  components: {
    Transport,
    Museum,
    Hotel,
    Meal,
    Guide,
    Attendant,
    Extra,
    Total,
    TotalForAll,
  },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      tourData: {
        transport: [],
        museum: [],
        hotel: [],
        meal: [],
        guide: [],
        attendant: [],
        extras: [],
        customers: [],
      },
      loader: false,
      selectedCustomerTypeId: null,
      adultType: {},
    }
  },
  mounted() {
    this.fetchTourData()
  },
  methods: {
    fetchTourData() {
      this.loader = true
      axios
        .get('/api/get-detailed-tour-objects', {
          params: {
            tour_id: this.tourId,
            model_alias: 'tour',
          },
        })
        .then(r => (this.tourData = r.data))
        .then(r => {
          this.setDefaultCustomerTypeId()
        })
        .finally(() => (this.loader = false))
    },
    setDefaultCustomerTypeId() {
      this.adultType = this.tourData.customers.find(customer => {
        return customer.name.toLowerCase() == 'взрослый'
      })
      this.selectedCustomerTypeId = this.adultType.id
    },
    getPrice(item, customerTypeId = this.selectedCustomerTypeId) {
      // For Tour Extras
      if (!item.hasOwnProperty('properties')) {
        return this.pricePerSeat(item.value)
      }
      // For everything else
      if (item.properties.value != null) {
        return this.pricePerSeat(item.properties.value)
      }
      if (item.objectable_type == 'App\\Models\\Tour\\TourMuseum') {
        return this.priceByType(item, customerTypeId)
      }
      if (item.objectable_type == 'App\\Models\\Tour\\TourHotel') {
        return (
          this.priceByType(item, customerTypeId) *
          parseInt(item.properties.days)
        )
      }
      if (item.objectable_type == 'App\\Models\\Tour\\TourMeal') {
        let price = 0
        if (item.prices.length > 0) {
          price = parseFloat(item.prices[0].price).toFixed(2)
        }
        return price * parseInt(item.properties.days)
      }
      if (item.model_alias == 'guide') {
        let price = this.priceByType(item, customerTypeId)
        return this.pricePerSeat(price)
      }
      if (item.model_alias == 'attendant') {
        let price = this.priceByType(item, customerTypeId)
        return this.pricePerSeat(price)
      }
      return 0
    },
    getPriceCustomerName(item) {
      let currentPrice = item.prices.find(price => {
        return price.tour_customer_type_id == this.selectedCustomerTypeId
      })
      if (!currentPrice) {
        currentPrice = item.prices.find(price => {
          return price.tour_customer_type_id == this.adultType.id
        })
      }
      const result = this.tourData.customers.find(customer => {
        return currentPrice.tour_customer_type_id == customer.id
      })
      return result.name
    },
    pricePerSeat(price) {
      let result = 0
      if (this.tourData.tour_qnt) {
        result = parseFloat(price) / this.tourData.tour_qnt
      } else {
        result = parseFloat(price)
      }
      result = result.toFixed(2)
      return result
    },
    priceByType(item, customerTypeId = this.selectedCustomerTypeId) {
      let result = item.prices.find(price => {
        return price.tour_customer_type_id == customerTypeId
      })
      if (!result) {
        result = item.prices.find(price => {
          return price.tour_customer_type_id == this.adultType.id
        })
      }
      return parseFloat(result.price).toFixed(2)
    },
    marginPrice(item, customerTypeId = this.selectedCustomerTypeId) {
      const price = parseFloat(this.getPrice(item, customerTypeId))
      let margin = 0
      // For Everything else
      if (item.hasOwnProperty('properties')) {
        margin = item.properties.margin ? parseInt(item.properties.margin) : 0
      }
      //For Tour extras
      else {
        margin = item.margin ? parseInt(item.margin) : 0
      }
      const result = price + (price * margin) / 100
      return result.toFixed(2)
    },
    commissPrice(item, customerTypeId = this.selectedCustomerTypeId) {
      const marginPrice = this.marginPrice(item, customerTypeId)
      let result = 0
      let commission = 0
      // For Everything else
      if (item.hasOwnProperty('properties')) {
        commission = item.properties.commission
      }
      // For Tour Extras
      else {
        commission = item.commission
      }
      result = commission
        ? (marginPrice / (1 - parseInt(commission) / 100)).toFixed(2)
        : marginPrice
      return result
    },
    throttledSave: _.debounce(function(item, isExtra = false) {
      this.loader = true
      console.log(item, isExtra)
      axios
        .post('/api/update-detailed-tour-object-attribute-property', {
          object_attribute_id: item.id,
          tour_id: this.tourId,
          margin: !isExtra ? item.properties.margin : item.margin,
          commission: !isExtra ? item.properties.commission : item.commission,
          is_extra: isExtra,
        })
        .then(r => console.log(r))
        .finally(() => (this.loader = false))
    }, 1500),
  },
}
</script>