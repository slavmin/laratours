<template>
  <v-card
    class="museum-card"
    pa-3
    :class="[
      {'is-selected' : isSelected}, 
      {'is-custom-order': isCustomOrder}
    ]"
    max-width="250px"
    outlined
  >
    <v-card-title>
      {{ item.name }}
    </v-card-title>
    <v-card-text>
      <v-form
        ref="form"
        v-model="valid"
      >
        <v-select
          v-model="selectedDay"
          :items="daysArray"
          color="#aa282a"
          item-color="#aa282a"
          :dark="item.selected"
          :disabled="isSelected"
          label="День тура"
          :rules="[v => !!v || 'Выберите день посещения']"
          required
        />
      </v-form>
      <!-- Regular events -->
      <div v-if="!JSON.parse(item.extra).isCustomOrder">
        <div
          v-for="(price, i) in item.prices"
          :key="i"
          row
          justify-content-between
          wrap
        >
          <span class="grey--text text--darken-1">
            {{ customers[price.tour_customer_type_id] }}:
          </span>
          <p style="display: inline-block;">
            {{ price.price }}
          </p>
        </div>
        <br>
        <div class="mt-2">
          Длительность: {{ JSON.parse(item.extra).duration }}ч.
        </div>
      </div>
      <!-- Custom events. ЗАКАЗ НАРЯД -->
      <div v-if="JSON.parse(item.extra).isCustomOrder">
        <v-row>
          <v-col xs8>
            <span class="grey--text text--darken-1">
              Цена:
            </span>
            <p style="display: inline-block;">
              {{ JSON.parse(item.extra).price }}
            </p>
            <br>
            <span class="grey--text text--darken-1">
              Кол-во человек:
            </span>
            <p style="display: inline-block;">
              {{ JSON.parse(item.extra).count }}
            </p>
          </v-col>
          <v-col xs4>
            <v-text-field
              v-model.number="customOrderCount"
              :disabled="item.selected"
              label="Штук"
              type="number"
            />
          </v-col>
        </v-row>

        <div
          v-if="customOrderCount"
          class="body-2"
        >
          <v-divider />
          <span class="grey--text text--darken-1">
            Итого:
          </span>
          <p style="display: inline-block;">
            {{ customOrderTotalPrice() }}
          </p>
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
      <v-btn
        v-if="!isSelected"
        color="#aa282a"
        small
        dark
        @click="addToTour"
      >
        Выбрать
      </v-btn>
    </v-card-actions>
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
  name: 'Excursion',
  components: {},
  props: {
    museum: {
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
    customers: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      valid: false,
      dialog: false,
      selectedDay: null,
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
      customOrderCount: null,
      customOrderPrice: null,
      customOrderTotalPrice: () => {
        return this.customOrderCount * this.customOrderPrice
      },
    }
  },
  computed: {
    daysArray: function() {
      let result = []
      for (let n = 1; n <= this.days; n++) result.push(n)
      return result
    },
    isCustomOrder: function() {
      const extra = JSON.parse(this.item.extra)
      const result = extra.isCustomOrder
      return result
    },
  },
  mounted() {
    if (this.wasSelected) {
      this.isSelected = true
      this.fetchItemData()
    }
    if (this.isCustomOrder) {
      this.customOrderPrice = JSON.parse(this.item.extra).price
    }
  },
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true
      }
    },
    addToTour() {
      this.validate()
      if (this.valid) {
        this.loader = true
        axios
          .post('/api/add-detailed-tour-object-attribute', {
            object_id: this.museum.id,
            object_attribute_id: this.item.id,
            object_type: 'museum',
            tour_id: this.tourId,
            'days_array[]': [this.selectedDay],
            duration: this.isCustomOrder ? this.customOrderCount : null,
            value: this.isCustomOrder ? this.customOrderTotalPrice() : null,
          })
          // .then(r => console.log(r))
          .finally(() => {
            this.loader = false
            this.isSelected = true
          })
      }
    },
    fetchItemData() {
      this.loader = true
      axios
        .get('/api/get-detailed-tour-object-attribute-properties', {
          params: {
            object_attribute_id: this.item.id,
            object_type: 'museum',
            tour_id: this.tourId,
          },
        })
        .then(r => {
          this.selectedDay = JSON.parse(r.data.days_array)[0]
          if (r.data.tour_price_type_id) {
            this.selectedPriceId = r.data.tour_price_type_id
            this.duration = r.data.duration
          } else {
            this.isManualPrice = true
            this.manualPriceValue = r.data.value
          }
          this.customOrderCount = r.data.duration
        })
        .finally(() => (this.loader = false))
    },
    removeFromTour() {
      this.loader = true
      this.isSelected = false
      axios
        .post('/api/remove-detailed-tour-object-attribute', {
          tour_id: this.tourId,
          object_attribute_id: this.item.id,
        })
        // .then(r => console.log(r))
        .finally(() => (this.loader = false))
    },
  },
}
</script>