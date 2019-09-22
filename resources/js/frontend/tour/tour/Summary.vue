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
                @change="customerChanged"
              />
            </th>
            <th>
              Наценка, %
              <v-text-field
                v-model="correctionToAll"
                label="На все"
                mask="###"
                outline
                @input="inputCorrection"
              /> 
            </th>
            <th>
              Комиссия, %
              <v-text-field
                v-model="commissionToAll"
                label="На все"
                mask="###"
                outline
                @input="inputCommission"
              /> 
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
                colspan="5"
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
                  v-model="transport.commission"
                  name="commission"
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
                colspan="5"
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
                <div class="body-1 grey--text">
                  {{ customerName(event) }}
                  <br>
                  День: {{ event.obj.day }}
                </div>
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
                  v-model="event.commission"
                  name="commision"
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
                colspan="5"
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
                  Дни: {{ hotel.obj.daysArray }}
                  <br>
                  Стандартное размещение
                  <!-- <br>
                  Цена: {{ JSON.parse(hotel.obj.extra).priceList.standard }} -->
                </div>
              </td>
              <td class="price">
                {{ getHotelPrice(hotel) }}
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
                  v-model="hotel.commission"
                  name="commision"
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
                colspan="5"
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
                  Описание: {{ meal.obj.description }}, {{ meal.obj.price }} руб.
                  <br>
                  Дни: {{ meal.obj.daysArray }}
                </div>
              </td>
              <td class="price">
                {{ meal.obj.totalPrice }}
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
                    {{ meal.obj.price }} руб. * {{ meal.obj.day }} дн.
                  </span>
                </v-tooltip>
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
                  v-model="meal.commission"
                  name="commision"
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
                colspan="5"
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
                <div class="body-1 grey--text">
                  Цена: {{ guide.guide.totalPrice }}
                </div>
              </td>
              <td class="price">
                {{ guide.pricePerSeat }}
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
                    {{ guide.guide.totalPrice }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
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
                  v-model="guide.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="guide.correctedPricePerSeat"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.attendant.length != 0">
              <td
                class="text-xs-center" 
                colspan="5"
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
              </td>
              <td class="price">
                {{ attendant.pricePerSeat }}
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
                    {{ attendant.attendant.totalPrice }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
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
                  v-model="attendant.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="attendant.correctedPricePerSeat"
                  class="corrected-price"
                  name="corrected"
                  disabled
                />
              </td>
            </tr>
            <tr v-if="getTour.customPrice.length != 0">
              <td
                class="text-xs-center" 
                colspan="5"
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
                {{ price.pricePerSeat }}
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
                    {{ price.value }} руб. / {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="price.correction"
                  name="correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                <v-text-field
                  v-model="price.commission"
                  name="commission"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ price.correctedPricePerSeat }}
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
              <td>
                <span class="subheading">
                  Наценка средняя: {{ getAverageCorrection }}%
                </span>
              </td>
              <td>
                <span class="subheading">
                  Комиссия средняя: {{ getAverageCommission }}%
                </span>
              </td>
              <td>
                {{ getTour.correctedPrice }}
              </td>
            </tr>
          </tbody>
        </table>
      </v-flex>
    </v-layout>
    <v-divider />
    <v-layout 
      row 
      wrap
    >
      <v-layout 
        row 
        wrap
      >
        <v-flex xs12>
          <h4 class="title grey--text">
            Итог по каждому типу туриста:
          </h4>
        </v-flex>  
      </v-layout>
      <v-flex xs12>
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
            <th>
              Ребёнок
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
                  Учитывать размещение в отелях по детскому тарифу.
                </span>
              </v-tooltip>
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
                <div
                  v-if="price.age"
                  class="grey--text body-1"
                >
                  <div
                    v-if="JSON.parse(price.age).isPens"
                  >
                    Мужчины от {{ JSON.parse(price.age).agePensMale }}
                    <br>
                    Женщины от {{ JSON.parse(price.age).agePensFemale }}
                  </div>
                  <div
                    v-if="!JSON.parse(price.age).isPens"
                  >
                    От {{ JSON.parse(price.age).ageFrom }}
                    до {{ JSON.parse(price.age).ageTo }}
                  </div>
                </div>
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Комиссия {{ getAverageCommission }}%: 
                </span>
                {{ (price.standardPrice * getAverageCommission / 100).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ price.standardPrice }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ (price.standardPrice
                  - (price.standardPrice * getAverageCommission / 100).toFixed(2)).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ ((price.standardPrice
                  - (price.standardPrice * getAverageCommission / 100).toFixed(2)).toFixed(2) - price.nettoStandardPrice).toFixed(2) }}
                <br>
                Затраты: {{ price.nettoStandardPrice }}
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Комиссия {{ getAverageCommission }}%: 
                </span>
                {{ (price.singlePrice * getAverageCommission / 100).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ price.singlePrice }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ (price.singlePrice
                  - (price.singlePrice * getAverageCommission / 100).toFixed(2)).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ ((price.singlePrice
                  - (price.singlePrice * getAverageCommission / 100).toFixed(2)).toFixed(2) - price.nettoSinglePrice).toFixed(2) }}
                <br>
                Затраты: {{ price.nettoSinglePrice }}
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Комиссия {{ getAverageCommission }}%: 
                </span>
                {{ (price.addPrice * getAverageCommission / 100).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ price.addPrice }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ (price.addPrice
                  - (price.addPrice * getAverageCommission / 100).toFixed(2)).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ ((price.addPrice
                  - (price.addPrice * getAverageCommission / 100).toFixed(2)).toFixed(2) - price.nettoAddPrice).toFixed(2) }}
                <br>
                Затраты: {{ price.nettoAddPrice }}
              </td>
              <td>
                <v-checkbox 
                  v-model="price.isChd" 
                  color="green"
                  name="is-chd"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <v-btn 
          v-if="showPriceForEveryCustomer"
          dark
          color="green"
          @click="calculatePriceForEveryCustomer"
        >
          Рассчитать цены для всех типов туристов
        </v-btn>
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
          :action="getEditMode ? `/operator/tour/${getTour.id}` :'/operator/tour'"
        >
          <input
            type="hidden"
            name="_method"
            :value="getEditMode ? 'PATCH' : 'POST'"
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
      commissionToAll: 0,
      currentCustomerType: 0,
      showPriceForEveryCustomer: true,
    };
  },
  computed: {
    ...mapGetters([
      'getTour',
      'getCorrectedPrice',
      'getCurrentTourCustomers',
      'getTourCalc',
      'getEditMode',
      'getAverageCommission',
      'getAverageCorrection',
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
        this.updateTourCorrectedPrice()
      },
      deep: true,
    },
    currentCustomerType: {
      handler(value) {
        this.updateCurrentCustomerType(value)
        this.updateTourCorrectedPrice()
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
      'updateCommissiontoAll',
      'updateCommissionPriceValues',
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
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
    },
    correctCommissionPrice() {
      this.updateCommissionPriceValues()
    },
    inputCommission() {
      this.updateCommissiontoAll(this.commissionToAll)
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
        setTimeout(() => { 
          this.currentCustomerType = customer.id
          this.updateCorrectedPriceValues()
        }, 50)
      })
      setTimeout(() => {
        this.currentCustomerType = prevCustomer
        this.updateCurrentCustomerType(this.currentCustomerType)
        this.updateCorrectedPriceValues()
      }, 500)
    },
    customerChanged() {
      this.updateCurrentCustomerType(this.currentCustomerType)
      this.updateCorrectedPriceValues()
    },
    getHotelPrice(hotel) {
      let customer = this.getTour.calc.priceList.find((item) => {
        return item.id == this.currentCustomerType
      })
      if (customer.isChd) {
        return JSON.parse(hotel.obj.extra).priceList.chd.std * hotel.obj.day
      }
      else {
        return JSON.parse(hotel.obj.extra).priceList.adl.std * hotel.obj.day
      }
    },
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
