<template>
  <v-card
    class="hotel-card"
    :class="{'is-selected' : isSelected}"
    pa-3
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
          v-model="selectedNights"
          :items="nightsArray"
          multiple
          item-color="#aa282a"
          :disabled="isSelected"
          :rules="[v => v.length > 0 || 'Выберите ночь остановки']"
          label="Ночь тура"
          outline
          required
        />
      </v-form>
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
  name: 'Room',
  props: {
    hotel: {
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
    nights: {
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
      selectedNights: [],
      loader: false,
      isSelected: false,
    }
  },
  computed: {
    nightsArray: function() {
      let result = []
      for (let n = 1; n <= this.nights; n++) result.push(n)
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
            object_id: this.hotel.id,
            object_attribute_id: this.item.id,
            object_type: 'hotel',
            tour_id: this.tourId,
            days: this.selectedNights.length,
            'days_array[]': this.selectedNights,
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
            object_type: 'hotel',
            tour_id: this.tourId,
          },
        })
        .then(r => {
          this.selectedNights = JSON.parse(r.data.days_array)
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
        .finally(() => (this.loader = false))
    },
  },
}
</script>