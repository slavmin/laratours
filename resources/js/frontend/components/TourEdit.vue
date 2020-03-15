<template>
  <div>
    <v-card-text>
      <v-row>
        <v-col cols="12">
          <v-form
            id="form"
            ref="form"
            v-model="formValid"
            :action="route"
            method="POST"
            lazy-validation
          >
            <input
              type="hidden"
              name="_method"
              :value="method"
            >
            <input
              type="hidden"
              name="_token"
              :value="token"
            >
            <input
              type="hidden"
              name="tour_constructor_type_id"
              :value="selectedConstructorTypeId"
            >
            <input
              v-for="id in selectedCountriesIds"
              :key="`country-${id}`"
              type="hidden"
              name="countries_list[]"
              :value="id"
            >
            <input
              type="hidden"
              name="country_id"
              :value="startCountryId"
            >
            <input
              v-for="id in selectedCitiesIds"
              :key="`city-${id}`"
              type="hidden"
              name="cities_list[]"
              :value="id"
            >
            <input
              type="hidden"
              name="city_id"
              :value="startCityId"
            >
            <input
              type="hidden"
              name="tour_type_id"
              :value="selectedTourTypeId"
            >
            <v-select
              v-model="selectedConstructorTypeId"
              :items="constructorTypeOptions"
              item-value="id"
              item-text="name"
              :rules="typeRules"
              color="#aa282a"
              label="Тип конструктора"
            />
            <v-select
              v-model="selectedTourTypeId"
              :items="tourTypeOptions"
              :rules="typeRules"
              label="Тип тура"
              append-outer-icon="find_in_page"
              color="#aa282a"
              required
            />
            <v-text-field
              v-model="tourName"
              label="Название тура"
              name="name"
              :rules="nameRules"
              append-outer-icon="title"
              color="#aa282a"
              outline
              required
            />
            <v-row>
              <v-col
                cols="12"
                md="6"
              >
                <v-autocomplete
                  v-model="selectedCountriesIds"
                  :items="countriesOptions"
                  :rules="countriesRules"
                  label="Страны"
                  color="#aa282a"
                  multiple
                  chips
                  required
                >
                  <template v-slot:selection="data">
                    <v-chip
                      :input-value="data.selected"
                      close
                      class="chip--select-multi"
                      @click="data.select"
                      @click:close="chipRemoveCountry(data.item)"
                    >
                      {{ data.item.text }}
                    </v-chip>
                  </template>
                </v-autocomplete>
              </v-col>
              <v-col
                cols="12"
                md="6"
              >
                <v-autocomplete
                  v-model="startCountryId"
                  :items="countriesOptions"
                  :rules="countriesRules"
                  label="Страна начала тура"
                  color="#aa282a"
                  chips
                  required
                >
                  <template v-slot:selection="data">
                    <v-chip
                      :input-value="data.selected"
                      close
                      class="chip--select-multi"
                      @click="data.select"
                      @click:close="startCountryId = NaN"
                    >
                      {{ data.item.text }}
                    </v-chip>
                  </template>
                </v-autocomplete>
              </v-col>
            </v-row>
            <v-row>
              <v-col
                cols="12"
                md="6"
              >
                <v-autocomplete
                  v-if="selectedCountriesIds.length > 0"
                  v-model="selectedCitiesIds"
                  :items="citiesOptions"
                  :rules="citiesRules"
                  label="Города"
                  color="#aa282a"
                  multiple
                  chips
                  required
                >
                  <template v-slot:selection="data">
                    <v-chip
                      :input-value="data.selected"
                      close
                      class="chip--select-multi"
                      @click="data.select"
                      @click:close="chipRemoveCity(data.item)"
                    >
                      {{ data.item.text }}
                    </v-chip>
                  </template>
                </v-autocomplete>
              </v-col>
              <v-col
                cols="12"
                md="6"
              >
                <v-autocomplete
                  v-if="selectedCountriesIds.length > 0"
                  v-model="startCityId"
                  :items="citiesOptions"
                  :rules="citiesRules"
                  name="city_id"
                  label="Город начала тура"
                  color="#aa282a"
                  chips
                  required
                >
                  <template v-slot:selection="data">
                    <v-chip
                      :input-value="data.selected"
                      close
                      class="chip--select-multi"
                      @click="data.select"
                      @click:close="startCityId = NaN"
                    >
                      {{ data.item.text }}
                    </v-chip>
                  </template>
                </v-autocomplete>
              </v-col>
            </v-row>
            <v-divider />
            <v-menu
              v-model="showDateStart"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="startDate"
                  name="dates[]"
                  label="Дата начала"
                  :rules="dateRules"
                  prepend-icon="event"
                  color="#aa282a"
                  readonly
                  v-on="on"
                />
              </template>
              <v-date-picker
                v-model="startDate"
                :min="dateToday"
                color="#aa282a"
                locale="ru-ru"
                first-day-of-week="1"
                @input="showDateStart = false"
              />
            </v-menu>
            <v-row>
              <v-col
                cols="12"
                md="4"
              >
                <v-text-field
                  v-model="tourDays"
                  name="duration"
                  label="Дней"
                  :rules="daysRules"
                  mask="###"
                  color="#aa282a"
                />
              </v-col>
              <v-col
                cols="12"
                md="4"
              >
                <v-text-field
                  v-model="tourNights"
                  name="nights"
                  label="Ночей"
                  :rules="nightsRules"
                  mask="###"
                  color="#aa282a"
                />
              </v-col>
              <v-col
                cols="12"
                md="4"
              >
                <v-text-field
                  v-model="tourQnt"
                  :rules="qntRules"
                  label="Количество туристов"
                  name="qnt"
                  mask="###"
                  color="#aa282a"
                />
              </v-col>
            </v-row>
          </v-form>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn
        text
        color="#aa282a"
        @click="reset"
      >
        очистить
      </v-btn>
      <v-spacer />
      <v-tooltip top>
        <template v-slot:activator="{ on }">
          <v-btn
            dark
            color="#aa282a"
            @click="submit"
            v-on="on"
          >
            Далее
          </v-btn>
        </template>
        <span>Сохранить тур и перейти к выбору объектов тура</span>
      </v-tooltip>
    </v-card-actions>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: 'TourEdit',
  props: {
    method: {
      type: String,
      default: '',
    },
    route: {
      type: String,
      default: '',
    },
    token: {
      type: String,
      default: '',
    },
    tour: {
      type: Object,
      default: () => {},
    },
    countriesCitiesOptions: {
      type: Object,
      default: () => {},
    },
    tourTypeOptionsRaw: {
      type: Object,
      default: () => {},
    },
    constructorTypeOptions: {
      type: Array,
      default: () => {},
    },
    tourDates: {
      type: Array,
      default: () => {},
    },
  },
  data() {
    return {
      value: '',
      tourName: '',
      selectedConstructorTypeId: [],
      selectedTourTypeId: [],
      selectedCountriesIds: [],
      startCountryId: NaN,
      selectedCitiesIds: [],
      startCityId: NaN,
      showDateStart: false,
      startDate: '',
      dateStart: '',
      tourDays: '',
      tourNights: '',
      tourQnt: '',
      formValid: false,
      nameRules: [v => !!v || 'Введите название тура'],
      dateRules: [v => !!v || 'Введите дату начала тура'],
      daysRules: [v => !!v || 'Укажите количество дней'],
      nightsRules: [v => !!v || 'Укажите количество ночей'],
      countriesRules: [
        v => v.length != 0 || 'Выберите как минимум одну страну',
      ],
      citiesRules: [v => v.length != 0 || 'Выберите как минимум один город'],
      typeRules: [v => v.length != 0 || 'Выберите тип'],
      qntRules: [v => !!v || 'Укажите количество туристов'],
    }
  },
  computed: {
    countriesOptions: function() {
      let result = []
      for (const key in this.countriesCitiesOptions) {
        result.push({
          value: parseInt(key),
          text: this.countriesCitiesOptions[key].name,
        })
      }
      return result
    },
    citiesOptions: function() {
      let result = []
      this.selectedCountriesIds.forEach(countryId => {
        const cities = this.countriesCitiesOptions[countryId].cities
        for (const key in cities) {
          result.push({
            value: parseInt(key),
            text: cities[key],
          })
        }
      })
      return result
    },
    tourTypeOptions: function() {
      let result = []
      for (const key in this.tourTypeOptionsRaw) {
        result.push({
          value: parseInt(key),
          text: this.tourTypeOptionsRaw[key],
        })
      }
      return result
    },
    dateToday: function() {
      return moment().format('YYYY-MM-DD')
    },
  },
  mounted() {
    this.parseTour()
  },
  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true
      }
    },
    reset() {
      this.$refs.form.reset()
    },
    submit() {
      this.validate()
      if (this.formValid) document.getElementById('form').submit()
    },
    chipRemoveCountry(item) {
      this.selectedCountriesIds = this.selectedCountriesIds.filter(id => {
        return id != item.value
      })
    },
    chipRemoveCity(item) {
      this.selectedCitiesIds = this.selectedCitiesIds.filter(id => {
        return id != item.value
      })
    },
    parseTour() {
      this.tourName = this.tour.name
      this.selectedConstructorTypeId = this.tour.tour_constructor_type_id
      this.selectedTourTypeId = this.tour.tour_type_id
      this.tour.countries_list.forEach(countryId => {
        this.selectedCountriesIds.push(parseInt(countryId))
      })
      this.startCountryId = parseInt(this.tour.country_id)
      this.tour.cities_list.forEach(cityId => {
        this.selectedCitiesIds.push(parseInt(cityId))
      })
      this.startCityId = parseInt(this.tour.city_id)
      this.startDate = moment(this.tourDates[0].date, 'DD/MM/YYYY').format(
        'YYYY-MM-DD'
      )
      this.tourDays = this.tour.duration
      this.tourNights = this.tour.nights
      this.tourQnt = this.tour.qnt
    },
  },
}
</script>