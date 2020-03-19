<template>
  <v-card
    :id="'transport-' + transport.id + '-card-' + item.id"
    class="transport-card"
    :class="{'is-selected' : isSelected}"
    pa-3
    max-width="250px"
    outlined
  >
    <v-card-title>
      {{ item.name }}
      <i
        class="material-icons ml-2"
        style="color: grey; font-size: 20px;"
        :title="item.description"
      >
        info
      </i>
    </v-card-title>
    <v-card-text>
      <v-form
        ref="form"
        v-model="valid"
      >
        <v-select
          v-model="selectedDays"
          :items="daysArray"
          multiple
          clearable
          item-color="#aa282a"
          :disabled="isSelected"
          label="День тура"
          outline
          :rules="[v => v.length > 0 || 'Выберите дни работы транспорта']"
          required
          @change="validate"
        />
      </v-form>
      <v-row>
        <v-col>
          <v-radio-group
            v-model="selectedPriceId"
            :disabled="isManualPrice"
          >
            <v-radio
              v-for="price in prices"
              :key="`${item.id}-price-${price.tour_price_type_id}`"
              :label="`${price.tour_price_type_name} ${price.price}`"
              :value="price.tour_price_type_id"
              color="#aa282a"
            />
          </v-radio-group>
          <v-checkbox
            v-model="isManualPrice"
            color="#aa282a"
            label="Вручную"
          />
        </v-col>
      </v-row>
      <div v-if="selectedPriceId && !isManualPrice">
        <v-text-field
          v-model="duration"
          name="name"
          color="#aa282a"
          label="Количество"
        />
      </div>
      <div v-if="isManualPrice">
        <v-text-field
          v-model="manualPriceValue"
          color="#aa282a"
          label="Общая стоимость"
        />
      </div>
      <div v-if="totalPrice()">
        Итого:
        <span class="body-1">
          {{ totalPrice() }}
        </span>
      </div>
      <div v-show="!isSelected">
        <v-btn
          color="#aa282a"
          dark
          text
          @click="showDriverDetails = !showDriverDetails"
        >
          Водители: {{ drivers.length }}
          <v-icon right>
            expand_{{ showDriverDetails ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div v-show="showDriverDetails">
          <v-btn
            v-show="driversCount != 1"
            color="red"
            small
            fab
            dark
            :disabled="driversCount === 1"
            @click="decrement"
          >
            <v-icon>remove</v-icon>
          </v-btn>
          <v-btn
            color="#aa282a"
            small
            fab
            dark
            @click="increment"
          >
            <v-icon>add</v-icon>
          </v-btn>
          <v-divider />
          <div
            v-for="(driver, i) in drivers"
            :key="i"
          >
            <p class="body-2">
              Водитель {{ i + 1 }}
            </p>
            <v-switch
              v-model="driver.hotel"
              label="Проживание"
              color="#aa282a"
            />
            <v-divider />
            <v-switch
              v-model="driver.meal"
              label="Питание"
              color="#aa282a"
            />
            <v-divider />
          </div>
        </div>
      </div>
    </v-card-text>
    <v-card-actions>
      <v-btn
        v-if="isSelected"
        color="#aa282a"
        small
        dark
        @click="removeFromTour"
      >
        Убрать
      </v-btn>
      <v-spacer />
      <v-row
        v-if="!isSelected"
        justify="center"
      >
        <v-btn
          color="#aa282a"
          small
          :disabled="!valid"
          :dark="valid"
          @click="addToTour"
        >
          Выбрать
        </v-btn>
        <v-tooltip
          v-if="!valid"
          bottom
        >
          <template v-slot:activator="{ on }">
            <v-icon
              color="grey"
              dark
              small
              v-on="on"
            >
              help
            </v-icon>
          </template>
          <span>Выберите дни работы транспорта</span>
        </v-tooltip>
      </v-row>
    </v-card-actions>
    <v-alert
      :value="showAttention"
      color="blue"
    >
      <strong>Внимание!</strong>
      Выбран один водитель без питания и проживания.
    </v-alert>
    <v-overlay
      :value="loader"
      style="z-index: 10000;"
    >
      <v-progress-circular
        indeterminate
        size="64"
      />
    </v-overlay>
  </v-card>
</template>
<script>
export default {
  name: 'Transport',
  components: {},
  props: {
    transport: {
      type: Object,
      default: () => {
        return {}
      },
    },
    item: {
      type: Object,
      default: () => {
        return {}
      },
    },
    days: {
      type: Number,
      default: () => {
        return []
      },
    },
    tourId: {
      type: Number,
      default: () => {
        return []
      },
    },
    tourDate: {
      type: String,
      default: () => {
        return []
      },
    },
    wasSelected: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      showDriverDetails: false,
      driversCount: 1,
      drivers: [{ hotel: false, isHotelSngl: true, meal: false }],
      valid: false,
      dialog: false,
      selectedDays: [],
      loader: false,
      prices: [],
      selectedPriceId: null,
      duration: null,
      totalPrice: () => {
        if (this.isManualPrice) {
          return this.manualPriceValue
        } else {
          return this.duration * this.selectedPrice.price
        }
      },
      isManualPrice: false,
      manualPriceValue: null,
      isSelected: false,
    }
  },
  computed: {
    daysArray: function() {
      let result = []
      for (let n = 1; n <= this.days; n++) result.push(n)
      return result
    },
    showAttention: function() {
      // If default driver options choosen
      // drivers = [{hotel: false, isHotelSngl: true, meal: false,}]
      if (
        this.item.selected &&
        this.driversCount == 1 &&
        !this.drivers[0].hotel &&
        !this.drivers[0].meal
      ) {
        return true
      }
      return false
    },
    selectedPrice: function() {
      if (this.selectedPriceId) {
        const result = this.prices.find(price => {
          if (price.tour_price_type_id == this.selectedPriceId) {
            return price
          }
        })
        return result
      }
      return 'Выберите тип'
    },
    hotelsCount: function() {
      let result = 0
      this.drivers.forEach(driver => {
        if (driver.hotel) result += 1
      })
      return result
    },
    mealsCount: function() {
      let result = 0
      this.drivers.forEach(driver => {
        if (driver.meal) result += 1
      })
      return result
    },
  },
  mounted() {
    this.fetchPrices()
    if (this.wasSelected) {
      this.isSelected = true
      this.fetchItemData()
    }
  },
  methods: {
    increment() {
      this.driversCount += 1
      this.drivers.push({
        hotel: false,
        isHotelSngl: true,
        meal: false,
      })
    },
    decrement() {
      this.driversCount -= 1
      this.drivers.pop()
    },
    log() {
      console.log('actual: ', this.getActualTransport)
      console.log('tour: ', this.getTour)
    },
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true
      }
    },
    fetchPrices() {
      this.loader = true
      axios
        .get('/api/get-detailed-tour-object-attribute-prices', {
          params: {
            object_attribute_id: this.item.id,
            tour_id: this.tourId,
            // selected_days: this.selectedDays,
            model_alias: 'transport',
          },
        })
        .then(r => {
          // console.log(r)
          this.prices = r.data
        })
        .finally(() => (this.loader = false))
    },
    close() {
      console.log('dialog closed')
    },
    addToTour() {
      this.loader = true
      axios
        .post('/api/add-detailed-tour-object-attribute', {
          object_id: this.transport.id,
          object_attribute_id: this.item.id,
          object_type: 'transport',
          tour_id: this.tourId,
          tour_price_type_id: !this.isManualPrice ? this.selectedPriceId : null,
          value: this.totalPrice(),
          duration: !this.isManualPrice ? this.duration : null,
          days: this.selectedDays.length,
          'days_array[]': this.selectedDays,
          hotel: this.hotelsCount,
          meal: this.mealsCount,
        })
        // .then(r => console.log(r))
        .finally(() => {
          this.loader = false
          this.dialog = false
          this.isSelected = true
        })
    },
    fetchItemData() {
      this.loader = true
      axios
        .get('/api/get-detailed-tour-object-attribute-properties', {
          params: {
            object_attribute_id: this.item.id,
            tour_id: this.tourId,
          },
        })
        .then(r => {
          this.fetchPrices()
          return r
        })
        .then(r => {
          this.selectedDays = JSON.parse(r.data.days_array)
          if (r.data.tour_price_type_id) {
            this.selectedPriceId = r.data.tour_price_type_id
            this.duration = r.data.duration
          } else {
            this.isManualPrice = true
            this.manualPriceValue = r.data.value
          }
          this.parseDriversProperties(r.data.hotel, r.data.meal)
        })
        .finally(() => (this.loader = false))
    },
    removeFromTour() {
      this.loader = true
      this.isSelected = false
      axios
        .post('/api/remove-detailed-tour-object-attribute', {
          tour_id: this.tourId,
          object_type: 'transport',
          object_attribute_id: this.item.id,
        })
        // .then(r => console.log(r))
        .finally(() => (this.loader = false))
    },
    parseDriversProperties(hotelsCount, mealsCount) {
      const length = hotelsCount >= mealsCount ? hotelsCount : mealsCount
      this.drivers = []
      for (let i = 0; i < length; i++) {
        this.drivers.push({
          hotel: i + 1 <= hotelsCount,
          meal: i + 1 <= mealsCount,
        })
      }
    },
  },
}
</script>