<template>
  <div>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <div class="title grey--text">
          Тур: {{ getTour.options.name }}, количество туристов: {{ getTour.qnt }}
        </div>
      </v-flex>  
    </v-layout>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <table class="summary">
          <thead>
            <th>
              Услуга
            </th>
            <th>
              Стоимость
              <br>
              <v-select
                v-model="currentCustomerType"
                :items="getCurrentTourCustomers"
                item-value="id"
                item-text="name"
                label="Тип туриста"
              />
            </th>
            <th>
              <v-layout 
                row 
                wrap
                align-center
              >
                <v-flex xs9>
                  Наценка, %
                </v-flex>
                <v-flex xs3>
                  <v-text-field
                    v-model="correctionToAll"
                    label="На все"
                    mask="###"
                    outline
                    @input="inputCorrection"
                  /> 
                </v-flex>
              </v-layout>
            </th>
            <th>
              Итого
              <br>
            </th>
          </thead>
          <tbody>
            <tr v-if="getTour.transport.length != 0">
              <td
                class="text-xs-center" 
                colspan="4"
              >
                Транспорт
              </td>
            </tr>
            <tr 
              v-for="(transport, i) in getTour.transport"
              :key="`T-${i}`"
            >
              <td>
                {{ transport.transport.name }}:
                {{ transport.obj.name }}.
                <br>
                <div class="body-1 grey--text">
                  Цена: {{ transport.obj.price }}, за {{ transport.obj.duration.hours }} часов.
                  <br>
                  Мест: {{ JSON.parse(transport.obj.extra).scheme.totalPassengersCount }}
                </div>
              </td>
              <td class="price">
                {{ transport.pricePerSeat }}
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
                    Стоимость за одного человека:
                    {{ transport.obj.price }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="transport.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="transport.correctedPricePerSeat"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.museum.length != 0">
              <td
                class="text-xs-center" 
                colspan="4"
              >
                Экскурсии
              </td>
            </tr>
            <tr 
              v-for="(event, i) in getTour.museum"
              :key="`M-${i}`"
            >
              <td>
                {{ event.museum.name }}:
                <br>
                {{ event.obj.name }}
                <br>
                {{ customerName(event) }}
              </td>
              <td class="price">
                {{ eventPrice(event) }}
              </td>
              <td>
                <v-text-field
                  v-model="event.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="event.correctedPrice"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.hotel.length != 0">
              <td
                class="text-xs-center" 
                colspan="4"
              >
                Размещение
              </td>
            </tr>
            <tr 
              v-for="(hotel, i) in getTour.hotel"
              :key="`H-${i}`"
            >
              <td>
                {{ hotel.hotel.name }}:
                <br>
                {{ hotel.obj.name }}
                <br>
                <div class="body-1 grey--text">
                  Ночей: {{ hotel.obj.day }}
                  <br>
                  Цена: {{ JSON.parse(hotel.obj.extra).priceList.standard }}
                </div>
              </td>
              <td class="price">
                {{ hotel.obj.totalPrice }}
              </td>
              <td>
                <v-text-field
                  v-model="hotel.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="hotel.correctedPrice"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.meal.length != 0">
              <td
                class="text-xs-center" 
                colspan="4"
              >
                Питание
              </td>
            </tr>
            <tr 
              v-for="(meal, i) in getTour.meal"
              :key="`Meal-${i}`"
            >
              <td>
                {{ meal.meal.name }}:
                <br>
                {{ meal.obj.name }}
                <br>
                <div class="body-1 grey--text">
                  Описание: {{ meal.obj.description }}
                </div>
              </td>
              <td class="price">
                {{ meal.obj.price }}
              </td>
              <td>
                <v-text-field
                  v-model="meal.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="meal.correctedPrice"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.guide.length != 0">
              <td
                class="text-xs-center" 
                colspan="4"
              >
                Гиды
              </td>
            </tr>
            <tr 
              v-for="(guide, i) in getTour.guide"
              :key="`G-${i}`"
            >
              <td>
                {{ guide.guide.name }}:
                <!-- <div class="body-1 grey--text">
                  Часов: {{ guide.guide.duration }}
                  <br>
                  Цена: {{ guide.guide.price }}
                </div> -->
              </td>
              <td class="price">
                {{ guide.guide.totalPrice }}
              </td>
              <td>
                <v-text-field
                  v-model="guide.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="guide.correctedPrice"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.attendant.length != 0">
              <td
                class="text-xs-center" 
                colspan="4"
              >
                Сопровождающие
              </td>
            </tr>
            <tr 
              v-for="(attendant, i) in getTour.attendant"
              :key="`A-${i}`"
            >
              <td>
                {{ attendant.attendant.name }}:
                <!-- <br>
                <div class="body-1 grey--text">
                  Часов: {{ attendant.attendant.duration }}
                  <br>
                  Цена: {{ attendant.attendant.price }}
                </div> -->
              </td>
              <td class="price">
                {{ attendant.attendant.totalPrice }}
              </td>
              <td>
                <v-text-field
                  v-model="attendant.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="attendant.correctedPrice"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.customPrice.length != 0">
              <td
                class="text-xs-center" 
                colspan="4"
              >
                Доп.услуги
              </td>
            </tr>
            <tr 
              v-for="(price, i) in getTour.customPrice"
              :key="`CP-${i}`"
            >
              <td>
                {{ price.name }}
              </td>
              <td class="price">
                {{ price.value }}
              </td>
              <td>
                <v-text-field
                  v-model="price.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ price.correctedPrice }}
              </td>
            </tr>
            <tr>
              <td>
                Итого: 
                <div class="body-1 grey--text">
                  Тип туриста: {{ (getCurrentTourCustomers.find(c => c.id == currentCustomerType)).name }}
                </div>
              </td>
              <td>
                {{ getTour.totalPrice }}
              </td>
              <td />
              <td>
                {{ getTour.correctedPrice }}
              </td>
            </tr>
          </tbody>
        </table>
      </v-flex>
    </v-layout>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <v-btn 
          v-if="showPriceForEveryCustomer"
          dark
          color="green"
          @click="calculatePriceForEveryCustomer"
        >
          Рассчитать цены для всех типов туристов
        </v-btn>
        <table class="total">
          <thead>
            <th>
              Тип туриста
            </th>
            <th>
              Обычное
            </th>
            <th>
              Single
            </th>
            <th>
              Дополнительное
            </th>
          </thead>
          <tbody>
            <tr
              v-for="price in getTourCalc.priceList"
              :key="price.customerId"
              class="text-xs-left subheading"
            >
              <td>
                {{ price.name }}
              </td>
              <td>
                {{ price.standardPrice }}
              </td>
              <td>
                {{ price.singlePrice }}
              </td>
              <td>
                {{ price.addPrice }}
              </td>
            </tr>
          </tbody>
        </table>
      </v-flex>  
    </v-layout>
    <v-layout 
      row 
      wrap
      justify-end
    >
      <v-flex xs2> 
        <form
          method="POST" 
          action="/operator/tour"
        >
          <input 
            type="hidden" 
            name="_token" 
            :value="token"
          >   
          <input 
            type="hidden" 
            name="name" 
            :value="getTour.options.name"
          > 
          <input 
            type="hidden" 
            name="tour_type_id" 
            :value="getTour.options.tourType"
          > 
          <input 
            type="hidden" 
            name="cities_list[]" 
            :value="getTour.options.cities"
          > 
          <input 
            type="hidden" 
            name="duration" 
            :value="getTour.options.days"
          > 
          <input 
            type="hidden"
            :value="JSON.stringify(tourExtra)"
            name="extra"
          > 
          <!-- <input 
            type="hidden"
            :value="JSON.stringify(tourExtra)"
            name="description"
          >  -->
          <v-btn 
            dark
            color="green"
            type="submit"
          >
            Сохранить тур
          </v-btn>
        </form>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { setTimeout } from 'timers';
export default {

  name: 'Summary',
  props: {
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      totalPrice: 0,
      correctedPrice: 0,
      correctionToAll: 0,
      currentCustomerType: 1,
      showPriceForEveryCustomer: true,
    };
  },
  computed: {
    ...mapGetters([
      'getTour',
      'getCorrectedPrice',
      'getCurrentTourCustomers',
      'getTourCalc',
    ]),
    tourExtra: function() {
      return {
        ...this.getTour, 
        correctedPrice: this.getCorrectedPrice
      }
    },
  },
  watch: {
    getTour: {
      handler(value) {
        this.updateTourTotalPrice()
        this.updateCorrectedPriceValues()
        this.updateTourCorrectedPrice()
      },
      deep: true,
    },
    currentCustomerType: {
      handler(value) {
        this.updateCurrentCustomerType(value)
      },
    },
  },
  mounted() {
    this.generateTourCalcCustomerTypes(this.getCurrentTourCustomers)
    this.updateTourTotalPrice()
    this.updateCorrectedPriceValues()
    this.updateTourCorrectedPrice()
  },
  methods: {
    ...mapActions([
      'updateTransportPrice',
      'updateTourTotalPrice',  
      'updateTourCorrectedPrice',
      'updateCorrectionToAll',
      'updateCorrectedPriceValues',
      'updateCurrentCustomerType',
      'generateTourCalcCustomerTypes',
    ]),
    saveTour() {
      console.log(this.getTour)
    },
    inputCorrection() {
      this.updateCorrectionToAll(this.correctionToAll)
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
    },
    correctPrice() {
      console.log('correctPrice')
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
    },
    customerName(event) {
      const data = JSON.parse(event.obj.extra)
      const currentPrice = data.priceList.find(price => price.customerId == this.currentCustomerType)
      if (currentPrice) {
        return currentPrice.customerName
      }
      else {
        const defaultPrice = data.priceList.find(price => price.customerId == 1) // Взрослый
        return defaultPrice.customerName
      }
    },
    eventPrice(event) {
      const data = JSON.parse(event.obj.extra)
      const currentPrice = data.priceList.find(price => price.customerId == this.currentCustomerType)
      if (currentPrice) {
        return currentPrice.price
      }
      else {
        return data.priceList.find(price => price.customerId == 1).price // Цена за взрослого
      }
    },
    calculatePriceForEveryCustomer() {
      let prevCustomer = this.currentCustomerType
      this.getCurrentTourCustomers.forEach((customer) => {
        setTimeout(() => { this.currentCustomerType = customer.id }, 10)
      })
      setTimeout(() => {this.currentCustomerType = prevCustomer}, 500)
    }
  },
};
</script>

<style lang="scss" scoped>
.summary,
.total {
  margin: 0 auto;
  td,
  th {
    border: 1px solid gray;
    padding: 16px;
    font-size: 24px;
  }
  td {
    text-align: left
  }
}
</style>
