<template>
  <v-container 
    grid-list-xs
    fluid  
  >
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <h1 class="text-center grey--text mb-5">
          Доступные туры:
        </h1>
        <h2 class="text-center grey--text">
          Фильтры:
        </h2>
        <v-layout 
          row 
          wrap
          justify-center
        >
          <v-flex xs2>
            <v-select
              v-model="selectedCities"
              :items="citiesArray"
              color="green"
              label="Город"
            />
          </v-flex>
          <v-flex xs4>
            <v-menu
              ref="menu"
              v-model="menu"
              :close-on-content-click="false"
              :nudge-right="40"
              :return-value.sync="dates"
              lazy
              transition="scale-transition"
              offset-y
              full-width
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-combobox
                  v-model="dates"
                  multiple
                  chips
                  small-chips
                  label="Даты"
                  prepend-icon="event"
                  readonly
                  v-on="on"
                />
              </template>
              <v-date-picker 
                v-model="dates" 
                multiple 
                no-title 
                scrollable
                color="green"
                locale="ru-ru"
              >
                <v-spacer />
                <v-btn 
                  flat 
                  color="primary" 
                  @click="menu = false"
                >
                  Cancel
                </v-btn>
                <v-btn 
                  flat 
                  color="primary" 
                  @click="$refs.menu.save(dates)"
                >
                  OK
                </v-btn>
              </v-date-picker>
            </v-menu>
          </v-flex>
        </v-layout>
        <Table
          :items="filterItems"
          :cities="cities"
          :token="token"
        />
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Table from './Table'
import moment from 'moment'
export default {
  name: 'AgencyToursIndex',
  components: {
    Table,
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    items: {
      type: Object,
      default: () => {
        return {}
      }
    },
    cities: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      selectedCities: [],
      dates: [],
      menu: false,
    }
  },
  computed: {
    citiesArray: function() {
      return _.toArray(this.cities)
    },
    filterItems: function() {
      // Get cities id from array of cities names
      let citiesId = []
      citiesId.push(_.indexOf(this.citiesArray, this.selectedCities))
      // this.selectedCities.forEach((city) => {
      //   citiesId.push(_.indexOf(this.citiesArray, city))
      // })
      // Filter items by cities id
      let filteredItems = []
      this.items.data.forEach((item) => {
        if (citiesId[0] == item.cities_list[0]) {
          filteredItems.push(item)
        }
      })
      // Filter items by dates
      let result = []
      if (filteredItems.length > 0) {
        filteredItems.forEach((item) => {
          const dateStart = JSON.parse(item.description).options.dateStart
          if (moment(dateStart).isAfter(this.dates[0])) {
            result.push(item)
          }
        })
      }
      return filteredItems.length == 0 ? this.items.data : result
    }
  },
  created() {
    console.log(this.items)
  },
  methods: {
    // filterItems() {
    //   // Get cities id from array of cities names
    //   let citiesId = []
    //   this.selectedCities.forEach((city) => {
    //     citiesId.push(_.indexOf(this.citiesArray, city))
    //   })
    //   // Filter items by cities id
    //   let filteredItems = []
    //   this.items.data.forEach((item) => {
    //     // console.log(item.cities_list)
    //     if (citiesId[0] == item.cities_list[0]) {
    //       filteredItems.push(item)
    //     }
    //   })
    //   console.log(filteredItems)
    // }
    datePicked() {
    }
  }
}
</script>

<style>

</style>
