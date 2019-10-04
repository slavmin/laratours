<template>
  <v-layout 
    row 
    wrap
    justify-center
  >
    <table>
      <thead>
        <th>
          Название тура
        </th>
        <th>
          Город
        </th>
        <th>
          Дата отъезда
        </th>
        <th>
          Дней
        </th>
        <th>
          Программа тура
        </th>
        <th>
          Цена
        </th>
        <th>
          Бронирование
        </th>
      </thead>
      <tbody>
        <tr
          v-for="item in items"
          :key="item.id"
        >
          <td>
            {{ item.name }}
          </td>
          <td>
            {{ 
              item.extra 
                ? getCitiesNames(JSON.parse(item.extra).options.cities) 
                : '' 
            }}
          </td>
          <td>
            {{ 
              item.extra
                ? JSON.parse(item.extra).options.dateStart
                : ''  
            }}
          </td>
          <td>
            {{ 
              item.extra
                ? JSON.parse(item.extra).options.days
                : ''  
            }}
          </td>
          <td>
            <AboutTour 
              :content="JSON.parse(item.extra).editorsContent"
            />
          </td>
          <td>
            {{ 
              item.extra
                ? JSON.parse(item.extra).correctedPrice
                : ''  
            }}
          </td>
          <td>
            <!-- <OrderTour 
              :tour="item"
              :token="token"
            /> -->
            <v-btn
              :href="'/agency/order/create/' + item.id"
              color="green"
              dark
              small
              flat
              outline
            >
              Заказать
            </v-btn>
          </td>
        </tr>
      </tbody>
    </table>
  </v-layout>
</template>

<script>
import AboutTour from './AboutTour'
export default {
  name: 'Table',
  components: {
    AboutTour,
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    items: {
      type: Array,
      default: () => {
        return []
      }
    },
    cities: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  mounted() {
    console.log(JSON.parse(this.items[0].extra))
  },
  methods: {
    getCitiesNames(cities) {
      let cityName = ''
      console.log(cities)
      cities.forEach((cityId) => {
        _.toArray(this.cities).forEach((city, i) => {
          if (i == cityId) {
            cityName += this.cities[i] + '. '
          }
        })
      })
      return cityName
    },
  },
}
</script>

<style lang="scss" scoped>
table {
  td,
  th {
    border: 1px solid gray;
    font-size: 16px;
    padding: 12px;
  }
}
</style>
