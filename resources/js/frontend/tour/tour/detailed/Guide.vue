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
        <v-text-field
          v-model="price"
          item-color="#aa282a"
          :dark="isSelected"
          :disabled="isSelected"
          :rules=" [v => !!v || 'Заполните']"
          color="#aa282a"
          label="Цена"
          required
        />
      </v-form>
      <div v-show="!isSelected">
        <v-btn
          color="#aa282a"
          dark
          small
          text
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
              v-model="hotel"
              :value="parseInt(1)"
              label="Проживание"
              color="#aa282a"
            />
            <v-divider />
            <v-switch
              v-model="meal"
              :value="parseInt(1)"
              label="Питание"
              color="#aa282a"
            />
          </div>
        </div>
      </div>
      <div v-show="!isSelected">
        <v-btn
          color="#aa282a"
          dark
          small
          text
          @click="showEvents = !showEvents"
        >
          Экскурсии
          <v-icon right>
            expand_{{ showEvents ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div v-show="showEvents">
          <v-switch
            v-for="museum in $parent.museums"
            :key="museum.id"
            v-model="selectedMuseums"
            :value="museum.id"
            :label="museum.name"
            color="#aa282a"
          />
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
  name: 'Guide',
  props: {
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
      price: null,
      showGuideDetails: false,
      hotel: 0,
      meal: 0,
      showEvents: false,
      selectedMuseums: [],
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
            object_type: 'guide',
            tour_id: this.tourId,
            days: this.selectedDays.length,
            'days_array[]': this.selectedDays,
            value: this.price,
            hotel: this.hotel,
            meal: this.meal,
            'events[]': this.selectedMuseums,
          })
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
          this.price = r.data.value
          this.hotel = r.data.hotel
          this.meal = r.data.meal
          this.selectedMuseums = JSON.parse(r.data.events)
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
          object_type: 'guide',
        })
        .finally(() => (this.loader = false))
    },
  },
}
</script>