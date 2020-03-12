<template>
  <v-card
    class="guide-card"
    :class="{'is-selected' : isSelected}"
    pa-3
    max-width="250px"
    outlined
  >
    <v-card-title>
      {{ guide.name }}
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
          item-color="#aa282a"
          :dark="isSelected"
          :disabled="isSelected"
          :rules="[v => v.length > 0 || 'Выберите день']"
          label="День тура"
          required
        />
      </v-form>
      <div
        v-for="(price, i) in guide.prices"
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
      <!-- <div v-show="!guide.selected">
        <v-btn
          color="#aa282a"
          dark
          flat
          @click="showGuideDetails = !showGuideDetails"
        >
          <v-icon class="mr-2">
            hotel
          </v-icon>
          <v-icon>
            fastfood
          </v-icon>
          <v-icon right>
            expand_{{ showGuideDetails ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div v-show="showGuideDetails">
          <div>
            <v-switch
              v-model="options.hotel"
              label="Проживание"
              color="#aa282a"
            />
            <v-checkbox
              v-if="options.hotel"
              v-model="options.isHotelSngl"
              label="Сингл"
              color="#aa282a"
            />
            <v-divider />
            <v-switch
              v-model="options.meal"
              label="Питание"
              color="#aa282a"
            />
          </div>
        </div>
      </div>
      <div v-show="!guide.selected">
        <v-btn
          color="#aa282a"
          dark
          flat
          @click="showEvents = !showEvents"
        >
          Экскурсии
          <v-icon right>
            expand_{{ showEvents ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div v-show="showEvents">
          <v-switch
            v-for="(museum, i) in museums"
            :key="`${guide.name}-${i}`"
            v-model="museum.selected"
            :label="`День: ${museum.day}. ${museum.museum}: ${museum.event}. Цена: ${museum.price}`"
            color="#aa282a"
          />
        </div>
      </div> -->
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
  </v-card>
</template>

<script>
export default {
  name: 'Guide',
  props: {
    meal: {
      type: Object,
      default: () => {
        return {}
      },
    },
    guide: {
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
      selectedDays: [],
      loader: false,
      isSelected: false,
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
    if (this.wasSelected) {
      this.isSelected = true
      this.fetchItemData()
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
            object_attribute_id: this.guide.id,
            parent_model_alias: 'guide',
            tour_id: this.tourId,
            days: this.selectedDays.length,
            'days_array[]': this.selectedDays,
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
            object_attribute_id: this.guide.id,
            tour_id: this.tourId,
          },
        })
        .then(r => {
          this.selectedDays = JSON.parse(r.data.days_array)
        })
        .finally(() => (this.loader = false))
    },
    removeFromTour() {
      this.loader = true
      this.isSelected = false
      axios
        .post('/api/remove-detailed-tour-object-attribute', {
          tour_id: this.tourId,
          object_attribute_id: this.guide.id,
          parent_model_alias: 'guide',
        })
        .finally(() => (this.loader = false))
    },
  },
}
</script>