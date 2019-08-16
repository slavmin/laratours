<template>
  <v-layout column> 
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
            <span> 
              {{ getCitiesNames(props.item.cities_list) }}
            </span>
          </td>
          <td class="text-xs-right">
            {{ getTourTypes[props.item.tour_type_id] }}
          </td>
          <td class="text-xs-right">
            {{ 
              props.item.extra 
                ? JSON.parse(props.item.extra).options.days 
                : '' 
            }}
          </td>
          <td class="text-xs-right grey--text">
            Нетто:
            {{ 
              props.item.extra 
                ? JSON.parse(props.item.extra).totalPrice
                : '' 
            }}
            <br>
            С наценкой:
            {{ 
              props.item.extra 
                ? JSON.parse(props.item.extra).correctedPrice 
                : '' 
            }}
          </td>
          <td>
            <About 
              :tour="props.item"
            />
          </td>
          <td>
            0
            /
            {{ JSON.parse(props.item.extra).qnt }}
          </td>
          <td>
            <v-layout 
              row 
              wrap
              align-top
            >
              <Edit
                :edit-tour="props.item"
                :token="token"
              />
              <form 
                :action="'/operator/tour/' + props.item.id"
                method="POST"
              > 
                <input 
                  type="hidden"
                  name="_method"
                  value="DELETE"
                >
                <input 
                  type="hidden"
                  name="_token"
                  :value="token"
                >
                <v-btn 
                  color="red"
                  flat
                  fab
                  outline
                  small
                  dark
                  type="submit"
                >
                  <i class="material-icons">
                    delete
                  </i>
                </v-btn>
              </form>
            </v-layout>
          </td>
        </template>
      </v-data-table>
    </v-layout>
  </v-layout>
</template>

<script>
import About from './About'
import Edit from './Edit'
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'TourTable',
  components: {
    About,
    Edit,
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
        { text: 'Описание', value: 'about' },
        { text: 'Забронировано', value: 'ordered' },
        { text: 'Действия', value: 'actions' }
      ],
    }
  },
  computed: {
    ...mapGetters([
      'allCities',
      'getTourTypes',
    ]),
  },
  created() {
    this.fetchAttendant()
    this.fetchCities()
    this.fetchTourTypes()
  },
  methods: {
    ...mapActions([
      'fetchAttendant',
      'fetchCities',
      'fetchTourTypes',
    ]),
    getCitiesNames(cities) {
      const citiesArray = Array.from(cities[0])
      let result = ''
      citiesArray.forEach((id) => {
        result += this.getCityName(id) + ' '
      })
      return result
    },
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    }
  },

};
</script>

<style lang="css" scoped>
</style>
