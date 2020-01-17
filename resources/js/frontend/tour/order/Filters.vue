<template>
  <v-container grid-list-xs>
    <v-layout
      row
      wrap
    >
      <h2 class="text-center white--text">
        <v-btn
          dark
          flat
          @click="showFilters = !showFilters"
        >
          Фильтры
          <v-icon>
            expand_{{ showFilters ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
      </h2>
    </v-layout>
    <v-layout
      v-if="showFilters"
      row
      wrap
      justify-center
    >
      <form
        action="/operator/order"
        method="GET"
      >
        <v-layout
          row
          wrap
        >
          <v-flex>
            <v-text-field
              v-model="filterValues.id"
              name="id"
              label="Номер заявки"
              dark
              clearable
            />
          </v-flex>
          <v-flex>
            <v-text-field
              v-model="filterValues.tourist_name"
              name="tourist_name"
              label="ФИО туриста"
              dark
              clearable
            />
          </v-flex>
          <v-flex>
            <v-select
              v-model="filterValues.status"
              :items="statusesTranslated"
              item-value="id"
              dark
              label="Статус"
              clearable
            />
            <input
              type="hidden"
              name="status"
              :value="filterValues.status"
            >
          </v-flex>
          <v-flex>
            <input
              type="hidden"
              name="city_id"
              :value="filterValues.city_id"
            >
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
          </v-flex>
        </v-layout>
        <v-layout
          row
          wrap
          justify-space-around
        >
          <v-flex>
            <input
              type="hidden"
              name="date_start"
              :value="filterValues.date_start"
            >
            <v-menu
              v-model="showDateStart"
              :close-on-content-click="false"
              :nudge-right="40"
              lazy
              transition="scale-transition"
              offset-y
              full-width
              color="white"
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="filterValues.date_start"
                  label="Дата начала"
                  prepend-icon="event"
                  dark
                  readonly
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
          </v-flex>
          <v-flex>
            <input
              type="hidden"
              name="date_end"
              :value="filterValues.date_end"
            >
            <v-menu
              v-model="showDateEnd"
              :close-on-content-click="false"
              :nudge-right="40"
              lazy
              transition="scale-transition"
              offset-y
              full-width
              color="white"
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="filterValues.date_end"
                  label="Дата окончания"
                  prepend-icon="event"
                  dark
                  readonly
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
          </v-flex>
        </v-layout>
        <v-layout
          row
          wrap
          justify-space-around
        >
          <v-btn
            dark
            small
            color="red"
            @click="clear"
          >
            Сбросить
          </v-btn>
          <v-btn
            type="submit"
            dark
            small
            color="green"
          >
            <v-icon>search</v-icon>
          </v-btn>
        </v-layout>
      </form>
    </v-layout>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'OrderFilters',
  props: {
    reqParams: {
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
        tourist_name: null,
      },
      showDateStart: false,
      showDateEnd: false,
    }
  },
  computed: {
    ...mapGetters(['allCities']),
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
  },
  mounted() {
    this.fetchCities()
    console.log(this.reqParams)
    for (const key in this.reqParams) {
      if (key === 'id') {
        let id = parseInt(this.reqParams.id)
        id ? '' : (id = null)
        this.filterValues.id = id
      }
      if (key === 'status') {
        let status = parseInt(this.reqParams.status)
        if (status == 0) {
          this.filterValues.status = 0
          return
        }
        status ? '' : (status = null)
        this.filterValues.status = status
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
      if (key === 'tourist_name') {
        let tourist_name = this.reqParams.tourist_name
        tourist_name ? '' : (tourist_name = null)
        this.filterValues.tourist_name = tourist_name
      }
    }
  },
  methods: {
    ...mapActions(['updateTours', 'fetchCities']),
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
      this.filterValues.id = null
      this.filterValues.status = null
      this.filterValues.city_id = null
      this.filterValues.date_start = null
      this.filterValues.date_end = null
      this.filterValues.tourist_name = null
      location.replace('/operator/order')
    },
  },
}
</script>