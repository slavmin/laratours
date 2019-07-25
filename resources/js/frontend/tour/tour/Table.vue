<template>
  <v-layout column> 
    <h1>Туры</h1>
    <v-layout 
      row
      wrap
      justify-center
    >
      <v-data-table
        :headers="headers"
        :items="tours"
        class="elevation-1"
      >
        <template v-slot:items="props">
          <td>
            {{ props.item.name }}
          </td>
          <td class="text-xs-right">
            <span 
              v-for="(city, i) in props.item.cities_list"
              :key="i"
              class="grey--text"
            > 
              {{ getCityName(city) }}
            </span>
          </td>
          <td class="text-xs-right">
            {{ props.item.tour_type_id }}
          </td>
          <td class="text-xs-right">
            {{ JSON.parse(props.item.description).options.days }}
          </td>
          <td class="text-xs-right">
            {{ JSON.parse(props.item.description).correctedPrice }}
          </td>
          <td>
            <About 
              :tour="props.item"
            />
          </td>
        </template>
      </v-data-table>
    </v-layout>
  </v-layout>
</template>

<script>
import About from './About'
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'TourTable',
  components: {
    About,
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    tours: {
      type: Array,
      default: () => {
        return []
      }
    },
  },
  data () {
    return {
      headers: [
        {
          text: 'Название тура',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'Города', value: 'сity' },
        { text: 'Тип тура', value: 'type' },
        { text: 'Дней', value: 'days' },
        { text: 'Стоимость', value: 'price' },
        { text: 'Описание', value: 'about' }
      ],
    }
  },
  computed: {
    ...mapGetters([
      'allCities',
    ]),
  },
  created() {
    this.fetchAttendant()
    this.fetchCities()
    console.log(this.tours)
  },
  methods: {
    ...mapActions([
      'fetchAttendant',
      'fetchCities',
    ]),
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
  },

};
</script>

<style lang="css" scoped>
</style>
