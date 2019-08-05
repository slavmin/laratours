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
              item.description 
                ? getCityName(JSON.parse(item.description).options.cities[0]) 
                : '' 
            }}
          </td>
          <td>
            {{ 
              item.description
                ? JSON.parse(item.description).options.dateStart
                : ''  
            }}
          </td>
          <td>
            {{ 
              item.description
                ? JSON.parse(item.description).options.days
                : ''  
            }}
          </td>
          <td>
            <AboutTour 
              :content="JSON.parse(item.description).editorsContent"
            />
          </td>
          <td>
            {{ 
              item.description
                ? JSON.parse(item.description).correctedPrice
                : ''  
            }}
          </td>
          <td>
            <OrderTour 
              :tour="item"
              :token="token"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </v-layout>
</template>

<script>
import AboutTour from './AboutTour'
import OrderTour from './OrderTour'
export default {
  name: 'Table',
  components: {
    AboutTour,
    OrderTour,
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
  created() {
  },
  methods: {
    getCityName(id) {
      let cityName = ''
      _.toArray(this.cities).forEach((city, i) => {
        if (i == id) {
          cityName = city
        }
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
