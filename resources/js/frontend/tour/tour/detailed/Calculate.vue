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
        <v-divider />
        <Drivers
          :v-if="drivers.length > 0"
          :drivers="drivers"
        />
        <PersonalGuides
          :v-if="personalGuides.length > 0"
          :guides="personalGuides"
        />
        <PersonalAttendants
          :v-if="personalAttendants.length > 0"
          :attendants="personalAttendants"
        />
        <PersonalFreeAdls
          :v-if="personalFreeAdls.length > 0"
          :freeadls="personalFreeAdls"
        />
      </v-col>
      <v-overlay
        :value="
          loader"
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
import Transport from './calculate/Transport'
import Museum from './calculate/Museum'
import Hotel from './calculate/Hotel'
import Meal from './calculate/Meal'
import Guide from './calculate/Guide'
import Attendant from './calculate/Attendant'
import Extra from './calculate/Extra'
import Drivers from './calculate/Drivers'
import PersonalGuides from './calculate/PersonalGuides'
import PersonalAttendants from './calculate/PersonalAttendants'
import PersonalFreeAdls from './calculate/PersonaFreeAdls'
import Total from './calculate/Total'
import TotalForAll from './calculate/TotalForAll'
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
    Drivers,
    PersonalGuides,
    PersonalAttendants,
    PersonalFreeAdls,
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
      drivers: [],
      personalGuides: [],
      personalAttendants: [],
      personalFreeAdls: [],
    }
  },
  mounted() {
    this.fetchTourData()
    this.fetchFreeAdls()
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
        .then(r => {
          console.log(r)
          this.tourData = r.data
        })
        .then(r => {
          this.setDefaultCustomerTypeId()
          this.parseDrivers()
          this.parseGuides()
          this.parseAttendants()
        })
        .finally(() => (this.loader = false))
    },
    fetchFreeAdls() {
      axios
        .get('/api/get-detailed-tour-objects', {
          params: {
            tour_id: this.tourId,
            model_alias: 'freeadl',
          },
        })
        .then(r => {
          this.personalFreeAdls = r.data.freeadls
        })
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
        let price = parseFloat(item.properties.value).toFixed(2)
        return this.pricePerSeat(price)
      }
      if (item.model_alias == 'attendant') {
        let price = parseFloat(item.properties.value).toFixed(2)
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
        margin = item.properties.margin ? item.properties.margin : 0
      }
      //For Tour extras
      else {
        margin = item.margin ? item.margin : 0
      }
      const result = this.marginFormula(price, margin)
      return result.toFixed(2)
    },
    marginFormula(price, margin) {
      return price + (price * parseInt(margin)) / 100
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
      result = this.commissFormula(marginPrice, commission)
      return result
    },
    commissFormula(marginPrice, commission) {
      return commission
        ? (marginPrice / (1 - parseInt(commission) / 100)).toFixed(2)
        : marginPrice
    },
    parseDrivers() {
      this.drivers = []
      this.tourData.transport.forEach(transport => {
        const hotelsCount = transport.properties.hotel
        const mealsCount = transport.properties.meal
        const days = JSON.parse(transport.properties.days_array)
        const length = hotelsCount >= mealsCount ? hotelsCount : mealsCount
        for (let i = 0; i < length; i++) {
          this.drivers.push({
            hotel: i + 1 <= hotelsCount,
            meal: i + 1 <= mealsCount,
            days: days,
          })
        }
      })
    },
    parseGuides() {
      this.personalGuides = []
      this.tourData.guide.forEach(guide => {
        const hotelsCount = guide.properties.hotel
        const mealsCount = guide.properties.meal
        const events = JSON.parse(guide.properties.events)
        const days = JSON.parse(guide.properties.days_array)
        this.personalGuides.push({
          name: guide.name,
          hotel: hotelsCount,
          meal: mealsCount,
          days: days,
          events: events,
        })
      })
    },
    parseAttendants() {
      this.personalAttendants = []
      this.tourData.attendant.forEach(attendant => {
        const hotelsCount = attendant.properties.hotel
        const mealsCount = attendant.properties.meal
        const events = JSON.parse(attendant.properties.events)
        const days = JSON.parse(attendant.properties.days_array)
        this.personalAttendants.push({
          name: attendant.name,
          hotel: hotelsCount,
          meal: mealsCount,
          days: days,
          events: events,
        })
      })
    },
    getPersonalPrice(type, index) {
      if (type == 'driver') {
        const driver = this.drivers[index]
        let result = 0
        driver.days.forEach(day => {
          if (driver.hotel === true) {
            result += this.getPersonalHotelPrice(day)
          }
          if (driver.meal === true) {
            result += this.getPersonalMealPrice(day)
          }
        })
        return this.pricePerSeat(result)
      }
      if (type == 'guide') {
        const guide = this.personalGuides[index]
        let result = 0
        guide.days.forEach(day => {
          if (guide.hotel == true) {
            result += this.getPersonalHotelPrice(day)
          }
          if (guide.meal == true) {
            result += this.getPersonalMealPrice(day)
          }
        })
        if (Array.isArray(guide.events)) {
          guide.events.forEach(eventId => {
            this.getPersonalEventsPrice(eventId)
          })
        }
        return this.pricePerSeat(result)
      }
      if (type == 'attendant') {
        const attendant = this.personalAttendants[index]
        let result = 0
        attendant.days.forEach(day => {
          if (attendant.hotel == true) {
            result += this.getPersonalHotelPrice(day)
          }
          if (attendant.meal == true) {
            result += this.getPersonalMealPrice(day)
          }
        })
        if (Array.isArray(attendant.events)) {
          attendant.events.forEach(eventId => {
            this.getPersonalEventsPrice(eventId)
          })
        }
        return this.pricePerSeat(result)
      }
      if (type == 'freeadl') {
        const freeadl = this.personalFreeAdls[index]
        let result = 0
        const days = JSON.parse(freeadl.days_array)
        const events = JSON.parse(freeadl.events)
        days.forEach(day => {
          if (freeadl.hotel == true) {
            result += this.getPersonalHotelPrice(day)
          }
          if (freeadl.meal == true) {
            result += this.getPersonalMealPrice(day)
          }
        })
        events.forEach(eventId => {
          this.getPersonalEventsPrice(eventId)
        })
        return this.pricePerSeat(result)
      }
    },
    getPersonalHotelPrice(day) {
      const hotel = this.tourData.hotel.find(item => {
        const hotelDays = JSON.parse(item.properties.days_array)
        return hotelDays.includes(day)
      })
      let result = 0
      if (hotel !== undefined) {
        result = this.getPrice(hotel, this.adultType.id)
      }
      return result
    },
    getPersonalMealPrice(day) {
      const meal = this.tourData.meal.find(item => {
        const mealDays = JSON.parse(item.properties.days_array)
        return mealDays.includes(day)
      })
      let result = 0
      if (meal !== undefined) {
        result = this.getPrice(meal)
      }
      return result
    },
    getPersonalEventsPrice(eventId) {
      // console.log(eventId, this.tourData)
    },
    marginPersonalPrice(type, index, margin) {
      let price = 0
      price = this.getPersonalPrice(type, index)
      const result = this.marginFormula(
        parseFloat(price),
        parseInt(margin ? margin : 0)
      )
      return result.toFixed(2)
    },
    commissPersonalPrice(type, index, margin, commission) {
      let price = 0
      price = this.marginPersonalPrice(type, index, margin)
      const result = this.commissFormula(
        parseFloat(price),
        parseInt(commission ? commission : 0)
      )
      return result
    },
    throttledSave: _.debounce(function(item, isExtra = false) {
      this.loader = true
      axios
        .post('/api/update-detailed-tour-object-attribute-property', {
          object_attribute_id: item.id,
          tour_id: this.tourId,
          margin: !isExtra ? item.properties.margin : item.margin,
          commission: !isExtra ? item.properties.commission : item.commission,
          is_extra: isExtra,
        })
        .finally(() => (this.loader = false))
    }, 1500),
  },
}
</script>