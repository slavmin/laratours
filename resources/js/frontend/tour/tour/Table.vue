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
          <td
            :class="props.item.published ? '' : 'unpublished'"
          >
            <v-checkbox 
              v-model="props.item.del" 
              color="red"
              @change="tourToDel(props.item.id)"
            />
          </td>
          <td
            :class="props.item.published ? '' : 'unpublished'"
          >
            {{ props.item.name }}
            <div
              v-if="!props.item.published"
              class="text-xs-left red--text"
              style="font-size: 10px;"
            >
              Тур не опубликован
            </div>
          </td>
          <td 
            class="text-xs-right"
            :class="props.item.published ? '' : 'unpublished'"
          >
            {{ props.item.extra 
              ? JSON.parse(props.item.extra).options.dateStart 
              : '' }}
          </td> 
          <td 
            class="text-xs-right"
            :class="props.item.published ? '' : 'unpublished'"
          >
            <span> 
              {{ getCitiesNames(props.item.cities_list) }}
            </span>
          </td>
          <td 
            class="text-xs-right"
            :class="props.item.published ? '' : 'unpublished'"
          >
            {{ getTourTypes[props.item.tour_type_id] }}
          </td>
          <td 
            class="text-xs-right"
            :class="props.item.published ? '' : 'unpublished'"
          >
            {{ 
              props.item.extra 
                ? JSON.parse(props.item.extra).options.days 
                : '' 
            }}
          </td>
          <td 
            class="text-xs-right grey--text"
            :class="props.item.published ? '' : 'unpublished'"
          >
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
          <td
            :class="props.item.published ? '' : 'unpublished'"
          >
            <About 
              :tour="props.item"
            />
          </td>
          <td
            :class="props.item.published ? '' : 'unpublished'"
          >
            {{ getOrdersCount(props.item.orderprofiles) }}
            /
            {{ JSON.parse(props.item.extra).qnt }}
          </td>
          <td
            :class="props.item.published ? '' : 'unpublished'"
          >
            {{ getCreatedFormattedDate(props.item.created_at) }}
          </td>
          <td
            :class="props.item.published ? '' : 'unpublished'"
          >
            <v-layout 
              row 
              wrap
              align-top
            >
              <CopyTour
                :tour="props.item"
                :token="token"
              />
              <Edit
                :tour="props.item"
                :token="token"
              />
              <Publish 
                :tour="props.item"
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
      <v-layout>
        <v-btn 
          v-if="tourIdsToDel.length > 0"
          color="red"
          dark
          small
          @click="deleteTours"
        >
          Удалить выбранные туры
          <v-progress-circular
            v-if="showLoader"
            class="ml-2"
            :width="2"
            :size="18"
            color="white"
            indeterminate
          />
        </v-btn>
        <v-spacer />
      </v-layout>
    </v-layout>
  </v-layout>
</template>

<script>
import About from './About'
import Edit from './Edit'
import Publish from './Publish'
import { mapActions, mapGetters } from 'vuex'
import moment from 'moment'
import CopyTour from './CopyTour'
export default {

  name: 'TourTable',
  components: {
    About,
    Edit,
    Publish,
    CopyTour,
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
        {},
        {
          text: 'Название тура',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'Дата', value: 'date' },
        { text: 'Города', value: 'сity' },
        { text: 'Тип тура', value: 'type' },
        { text: 'Дней', value: 'days' },
        { text: 'Стоимость', value: 'price' },
        { text: 'Описание', value: 'about' },
        { text: 'Забронировано', value: 'ordered' },
        { text: 'Создан', value: 'created' },
        { text: 'Действия', value: 'actions' },
      ],
      tourIdsToDel: [],
      showLoader: false,
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
    },
    getCreatedFormattedDate(date) {
      const a = moment(date)
      moment.locale('ru')
      return a.format('DD MMM YYYY')
    },
    getOrdersCount(orders) {
      let result = 0
      orders.forEach((order) => {
        order.content.forEach(profile => result += 1)
      })
      return result
    },
    deleteTours() {
      this.showLoader = true
      console.log(this.tourIdsToDel)
      this.tourIdsToDel.forEach((tourId) => {
        const url = '/operator/tour/' + tourId
        const tour = {
          '_token': this.token,
          '_method': 'DELETE',
          id: tourId
        }
        console.log(tour)
        axios.post(url, tour)
          .then(r => console.log(r))
          .catch(e => console.log(e))
      })
      setTimeout(function() {
        document.location.reload(true)
      }, 2000)
    },
    tourToDel(id) {
      if (this.tourIdsToDel.includes(id)) {
        this.tourIdsToDel = this.tourIdsToDel.filter(tourId => tourId != id)
      } else {
        this.tourIdsToDel.push(id)
      }
    }
  },
  
};
</script>

<style lang="scss" scoped>
.unpublished {
  background-color: #f8f8f8,
}
</style>
