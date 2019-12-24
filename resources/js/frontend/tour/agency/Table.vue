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
            от
            {{ 
              JSON.parse(item.extra).constructorType != "Тур от партнёра"
                ? parseFloat(JSON.parse(item.extra).calc.priceList[0].commissionStandardPrice).toFixed(2)
                : getPartnerMinPrice(JSON.parse(item.extra))  
            }}
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-icon 
                  color="grey"
                  v-on="on"
                >
                  info
                </v-icon>
              </template>
              <span>
                Цена за одного взрослого при стандартном размещении.
              </span>
            </v-tooltip>
          </td>
          <td>
            <!-- <OrderTour 
              :tour="item"
              :token="token"
            /> -->
            <v-btn
              :href="'/agency/order/create/' + item.id"
              color="#aa282a"
              small
              dark
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
  methods: {
    getCitiesNames(cities) {
      let cityName = ''
      cities.forEach((cityId) => {
        _.toArray(this.cities).forEach((city, i) => {
          if (i == cityId) {
            cityName += this.cities[i] + '. '
          }
        })
      })
      return cityName
    },
    getPartnerMinPrice(tourExtra) {
      let price = 'Уточняйте'
      if (tourExtra.partnerTour.prices) {
        price = tourExtra.partnerTour.prices.find((item) => {
          return item.name.toLowerCase().includes('взр') || item.name.toLowerCase().includes('двухместн')
        })
        price = price.value + tourExtra.partnerTour.commission
      }
      console.log(price)
      return price
    }
  },
}
</script>

<style lang="scss" scoped>
table {
  td,
  th {
    font-size: 16px;
    padding: 12px;
  }
  th {
    border-bottom: 2px solid #cac8c9;
    color: #868080;
    padding-top: 24px;
    padding-bottom: 36px;
    font-size: 16px;
    font-weight: normal;
  }
}
</style>
