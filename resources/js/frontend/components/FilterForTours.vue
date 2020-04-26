<template>
  <v-container>
    <v-row>
      <h2 class="text-center white--text">
        <v-btn dark text @click="showFilters = !showFilters">
          Фильтры ({{ activeFiltersCount }})
          <v-icon> expand_{{ showFilters ? 'less' : 'more' }} </v-icon>
        </v-btn>
      </h2>
    </v-row>
    <div v-if="showFilters">
      <form action="/operator/tour" method="GET">
        <v-row row wrap>
          <v-col>
            <v-text-field
              v-model="filterValues.tour_name"
              name="tour_name"
              label="Название тура"
              dark
              clearable
            />
          </v-col>
          <v-col>
            <input type="hidden" name="city_id" :value="filterValues.city_id" />
            <v-autocomplete
              v-model="filterValues.city_id"
              item-text="name"
              item-value="id"
              :items="allCities"
              label="Город:"
              dark
              persistent-hint
              clearable
            />
          </v-col>
        </v-row>
        <v-row row wrap justify-space-around>
          <v-col>
            <div class="white--text subheading">
              Период туров от:
            </div>
            <input
              type="hidden"
              name="date_start"
              :value="filterValues.date_start"
            />
            <v-menu
              v-model="showDateStart"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              color="white"
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="filterValues.date_start"
                  label="Начало периода"
                  prepend-icon="event"
                  dark
                  readonly
                  clearable
                  v-on="on"
                />
              </template>
              <v-date-picker
                v-model="filterValues.date_start"
                color="#aa282a"
                locale="ru-ru"
                first-day-of-week="1"
                @input="showDateStart = false"
              />
            </v-menu>
          </v-col>
          <v-col>
            <div class="white--text subheading">
              до:
            </div>
            <input
              type="hidden"
              name="date_end"
              :value="filterValues.date_end"
            />
            <v-menu
              v-model="showDateEnd"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              color="white"
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="filterValues.date_end"
                  label="Конец"
                  prepend-icon="event"
                  dark
                  readonly
                  clearable
                  v-on="on"
                />
              </template>
              <v-date-picker
                v-model="filterValues.date_end"
                color="#aa282a"
                locale="ru-ru"
                first-day-of-week="1"
                @input="showDateEnd = false"
              />
            </v-menu>
          </v-col>
        </v-row>
        <v-row class="justify-space-around">
          <v-btn dark small color="red" @click="clear">
            Сбросить
          </v-btn>
          <v-btn type="submit" dark small color="green">
            <v-icon>search</v-icon>
          </v-btn>
        </v-row>
      </form>
    </div>
  </v-container>
</template>
<script>
export default {
  name: 'TourFilters',
  props: {
    reqParams: {
      type: Object,
      default: () => {
        return []
      },
    },
    cities: {
      type: Object,
      default: () => {
        return []
      },
    },
  },
  data() {
    return {
      showFilters: true,
      orderId: null,
      tourName: '',
      statusesTranslated: [
        { id: 0, text: 'Не подтвержден' },
        { id: 1, text: 'Подтвержден' },
        { id: 2, text: 'Оплачен' },
        { id: 3, text: 'Отменен' },
        { id: 4, text: 'Отклонен' },
        { id: 5, text: 'Завершен' },
      ],
      status: null,
      filterValues: {
        id: null,
        status: null,
        city_id: null,
        date_start: null,
        tour_name: null,
      },
      showDateStart: false,
      showDateEnd: false,
    }
  },
  computed: {
    filterUrl: function() {
      let result = '/operator/order?'
      if (this.orderId != null) {
        result = result + `&id=${this.orderId}`
      }
      if (this.status != null) {
        result = result + `&status=${this.status}`
      }
      return result
    },
    activeFiltersCount: function() {
      let result = 0
      for (const key in this.filterValues) {
        if (this.filterValues[key] != null) {
          result += 1
        }
      }
      return result
    },
    allCities() {
      let result = []
      for (let key in this.cities) {
        result.push({
          id: parseInt(key),
          name: this.cities[key],
        })
      }
      return result
    },
  },
  mounted() {
    for (const key in this.reqParams) {
      if (key === 'tour_name') {
        let tour_name = this.reqParams.tour_name
        tour_name ? '' : (tour_name = null)
        this.filterValues.tour_name = tour_name
      }
      if (key === 'city_id') {
        let city_id = parseInt(this.reqParams.city_id)
        city_id ? '' : (city_id = null)
        this.filterValues.city_id = city_id
      }
      if (key === 'date_start') {
        let date_start = this.reqParams.date_start
        date_start ? '' : (date_start = null)
        this.filterValues.date_start = date_start
      }
      if (key === 'date_end') {
        let date_end = this.reqParams.date_end
        date_end ? '' : (date_end = null)
        this.filterValues.date_end = date_end
      }
    }
  },
  methods: {
    fetch() {
      const url = `/operator/order?id=${this.orderId}`
      axios.get(this.filterUrl).then(response => {
        console.log(response.data.data)
        this.updateTours(response.data.data)
      })
    },
    filter() {
      this.fetch()
    },
    clear() {
      this.filterValues.city_id = null
      this.filterValues.date_start = null
      this.filterValues.date_end = null
      this.filterValues.tour_name = null
      location.replace('/operator/tour')
    },
  },
}
</script>