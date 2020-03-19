<template>
  <v-card
    class="meal-card"
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
          v-model="selectedDays"
          :items="daysArray"
          multiple
          item-color="#aa282a"
          :disabled="isSelected"
          :rules="[v => v.length > 0 || 'Выберите день']"
          label="День тура"
          outline
          required
        />
      </v-form>
      <div
        v-for="(price, i) in item.prices"
        :key="i"
      >
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
  name: 'Meal',
  props: {
    meal: {
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
            object_id: this.meal.id,
            object_attribute_id: this.item.id,
            object_type: 'meal',
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
            object_attribute_id: this.item.id,
            object_type: 'meal',
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
          object_attribute_id: this.item.id,
        })
        .finally(() => (this.loader = false))
    },
  },
}
</script>