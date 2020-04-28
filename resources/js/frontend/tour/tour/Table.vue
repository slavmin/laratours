<template>
  <div style="max-width: 1600px;">
    <v-layout>
      <v-spacer />
      <TablePagination :items="items" />
    </v-layout>
    <v-layout
      row
      wrap
      justify-center
    >
      <v-data-table
        :headers="headers"
        :items="tours"
        class="elevation-1"
        hide-actions
        :pagination.sync="pagination"
      >
        <template v-slot:items="props">
          <td :class="props.item.published ? '' : 'unpublished'">
            <v-checkbox
              v-model="props.item.del"
              color="red"
              @change="tourToDel(props.item.id)"
            />
          </td>
          <td :class="props.item.published ? '' : 'unpublished'">
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
              {{ getCitiesNames(JSON.parse(props.item.extra).options.cities) }}
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
            <div v-if="JSON.parse(props.item.extra).calc.priceList[0]">
              Тип туриста:
              {{ 
                props.item.extra 
                  ? JSON.parse(props.item.extra).calc.priceList[0].name
                  : '' 
              }}
              <br>
              Нетто:
              {{ 
                props.item.extra 
                  ? JSON.parse(props.item.extra).calc.priceList[0].nettoStandardPrice
                  : '' 
              }}
              <br>
              С наценкой:
              {{ 
                props.item.extra 
                  ? parseFloat(JSON.parse(props.item.extra).calc.priceList[0].standardPrice).toFixed(2)
                  : '' 
              }}
              <br>
              С комиссией:
              {{ 
                props.item.extra 
                  ? parseFloat(JSON.parse(props.item.extra).calc.priceList[0].commissionStandardPrice).toFixed(2)
                  : '' 
              }}
              <v-divider />
              Комиссия:
              {{ 
                props.item.extra 
                  ? parseFloat(
                    JSON.parse(props.item.extra).calc.priceList[0].commissionStandardPrice 
                      - JSON.parse(props.item.extra).calc.priceList[0].standardPrice
                  ).toFixed(2)
                  : '' 
              }}
              <br>
              Прибыль:
              {{ 
                props.item.extra 
                  ? parseFloat(
                    JSON.parse(props.item.extra).calc.priceList[0].standardPrice 
                      - JSON.parse(props.item.extra).calc.priceList[0].nettoStandardPrice
                  ).toFixed(2)
                  : '' 
              }}
            </div>
            <div
              v-if="JSON.parse(props.item.extra).constructorType == 'Тур от партнёра'"
            >
              от {{ getPartnerMinPrice(JSON.parse(props.item.extra)) }}
              Партнёрский тур
            </div>
          </td>
          <td :class="props.item.published ? '' : 'unpublished'">
            <About :tour="props.item" />
            <BusNotify :tour="props.item" />
            <v-btn
              color="green"
              dark
              small
              :href="`/modules/gibdd-map?tour_id=${props.item.id}`"
              target="_blank"
            >
              Схема
            </v-btn>
          </td>
          <td :class="props.item.published ? '' : 'unpublished'">
            {{ getOrdersCount(props.item.orderprofiles) }}
            /
            {{ JSON.parse(props.item.extra).qnt }}
          </td>
          <td :class="props.item.published ? '' : 'unpublished'">
            {{ getCreatedFormattedDate(props.item.created_at) }}
          </td>
          <td :class="props.item.published ? '' : 'unpublished'">
            <v-layout
              row
              wrap
              align-top
            >
              <CopyTour
                :tour="props.item"
                :token="token"
              />
              <v-btn
                color="green"
                small
                fab
                dark
                title="Редактировать тур"
                :href="`/operator/tour/${props.item.id}/edit`"
              >
                <i class="material-icons">
                  edit
                </i>
              </v-btn>
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
                  fab
                  small
                  title="Удалить"
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
    <v-layout>
      <v-btn
        v-if="tourIdsToDel.length > 0"
        color="red"
        dark
        small
        @click="deleteTours"
      >
        Удалить выбранные туры ({{ tourIdsToDel.length }})
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
    <v-layout>
      <v-spacer />
      <TablePagination :items="items" />
    </v-layout>
  </div>
</template>

<script>
import About from './About'
import Publish from './Publish'
import { mapActions, mapGetters } from 'vuex'
import moment from 'moment'
import CopyTour from './CopyTour'
import TablePagination from './TablePagination'
import BusNotify from '../includes/documents/BusNotify'
export default {
  name: 'TourTable',
  components: {
    About,
    Publish,
    CopyTour,
    TablePagination,
    BusNotify,
  },
  props: {
    token: {
      type: String,
      default: '',
    },
    tours: {
      type: Array,
      default: () => {
        return []
      },
    },
    items: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
  data() {
    return {
      headers: [
        {},
        {
          text: 'Название тура',
          align: 'left',
          sortable: false,
          value: 'name',
        },
        { text: 'Дата', value: 'date' },
        { text: 'Города', value: 'сity' },
        { text: 'Тип тура', value: 'type' },
        { text: 'Дней', value: 'days' },
        { text: 'Стоимость', value: 'price' },
        { text: 'Документы', value: 'docs' },
        { text: 'Забронировано', value: 'ordered' },
        { text: 'Создан', value: 'created' },
        { text: 'Действия', value: 'actions' },
      ],
      tourIdsToDel: [],
      showLoader: false,
      pagination: {
        rowsPerPage: 15,
      },
    }
  },
  computed: {
    ...mapGetters(['allCities', 'getTourTypes']),
  },
  created() {
    this.fetchAttendant()
    this.fetchCities()
    this.fetchTourTypes()
    console.log(JSON.parse(this.items.data[0].extra))
  },
  methods: {
    ...mapActions(['fetchAttendant', 'fetchCities', 'fetchTourTypes']),
    getCitiesNames(cities) {
      let result = ''
      cities.forEach(id => {
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
      orders.forEach(order => {
        order.content.forEach(profile => (result += 1))
      })
      return result
    },
    deleteTours() {
      this.showLoader = true
      this.tourIdsToDel.forEach(tourId => {
        const url = '/operator/tour/' + tourId
        const tour = {
          _token: this.token,
          _method: 'DELETE',
          id: tourId,
        }
        axios
          .post(url, tour)
          .then()
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
    },
    getPartnerMinPrice(tourExtra) {
      const noPrice = 'Цена взрослого не указана'
      let price = 0
      if (tourExtra.partnerTour.prices) {
        price = tourExtra.partnerTour.prices.find(item => {
          return (
            item.name.toLowerCase().includes('взр') ||
            item.name.toLowerCase().includes('двухместн')
          )
        })
      }
      const result = price ? price.value : noPrice
      return result
    },
  },
}
</script>

<style lang="scss" scoped>
.unpublished {
  background-color: #f8f8f8;
}
</style>
