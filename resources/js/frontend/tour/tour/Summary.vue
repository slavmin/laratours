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
              Нетто
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
                colspan="6"
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
                {{ parseInt(transport.correctedPricePerSeat).toFixed(2) }}  
              </td>
              <td>
                <v-text-field
                  v-model="transport.commission"
                  name="commission"
                  @input="commissPrice"
                />
              </td>
              <td>
                {{ parseInt(transport.commissionPricePerSeat).toFixed(2) }}
              </td>
            </tr>
            <tr v-if="getTour.museum.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
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
                {{ parseInt(event.correctedPrice).toFixed(2) }}
              </td>
              <td>
                <v-text-field
                  v-model="event.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(event.commissionPrice).toFixed(2) }}
              </td>
            </tr>
            <tr v-if="getTour.hotel.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
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
                {{ parseInt(hotel.correctedPrice).toFixed(2) }}
              </td>
              <td>
                <v-text-field
                  v-model="hotel.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(hotel.commissionPrice).toFixed(2) }}
              </td>
            </tr>
            <tr v-if="getTour.meal.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
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
                {{ parseInt(meal.correctedPrice).toFixed(2) }}
              </td>
              <td>
                <v-text-field
                  v-model="meal.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(meal.commissionPrice).toFixed(2) }}
              </td>
            </tr>
            <tr v-if="getTour.guide.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
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
                {{ parseInt(guide.correctedPricePerSeat).toFixed(2) }}
              </td>
              <td>
                <v-text-field
                  v-model="guide.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(guide.commissionPricePerSeat).toFixed(2) }}
              </td>
            </tr>
            <tr v-if="getTour.attendant.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
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
                {{ parseInt(attendant.correctedPricePerSeat).toFixed(2) }}
              </td>
              <td>
                <v-text-field
                  v-model="attendant.commission"
                  name="commision"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(attendant.commissionPricePerSeat).toFixed(2) }}
              </td>
            </tr>
            <tr v-if="getTour.customPrice.length != 0">
              <td
                class="text-xs-center" 
                colspan="6"
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
                {{ parseInt(price.correctedPricePerSeat).toFixed(2) }}
              </td>
              <td>
                <v-text-field
                  v-model="price.commission"
                  name="commission"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ parseInt(price.commissionPricePerSeat).toFixed(2) }}
              </td>
            </tr>
            <tr v-if="getTour.options.drivers != 0">
              <td
                class="text-xs-center" 
                colspan="6"
                style="background-color: #f8f8f8;"
              >
                Персонал
                <v-btn 
                  color="green"
                  fab
                  flat
                  @click="showStaff = !showStaff"
                >
                  <v-icon>
                    expand_{{ showStaff ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
              </td>
            </tr>
            <tr v-show="showStaff">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Водители
                <v-btn 
                  color="green"
                  fab
                  flat
                  @click="showDrivers = !showDrivers"
                >
                  <v-icon>
                    expand_{{ showDrivers ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
              </td>
            </tr>
            <tr
              v-for="(driver, i) in getTour.options.drivers"
              v-show="showDrivers"
              :key="`Driver-${i}`"
            >
              <td>
                {{ driver.busName }}. 
                <br>
                Водитель {{ driver.driver }}
                <div 
                  v-if="driver.hotelPrice"
                >
                  Проживание: 
                  <div 
                    v-for="(room, r) in driver.hotelPrice"
                    :key="`Room-${r}`"
                  >
                    День: {{ room.day }}
                    <br>
                    <span class="body-1 grey--text">
                      {{ room.hotelName }}, {{ room.roomName }}
                    </span>
                    <br>
                    <span class="body-1 grey--text">
                      Цена (стандарт): {{ room.hotelStdPrice }}
                      <br>
                      Цена (сингл): {{ room.hotelSnglPrice }}
                    </span>
                  </div>
                </div>
                <div
                  v-if="driver.mealPrice"
                >
                  Питание:
                  <div
                    v-for="(meal, m) in driver.mealPrice"
                    :key="`Meal-${m}`"
                  >
                    День: {{ meal.day }}
                    <br>
                    <span class="body-1 grey--text">
                      {{ meal.mealName }}
                    </span>
                    <br>
                    <span class="body-1 grey--text">
                      Цена: {{ meal.mealPrice }}
                    </span>
                  </div>
                </div>
              </td>
              <td>
                {{ driver.totalPricePerSeat }}
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
                    {{ driver.totalPrice }} / 
                    {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="driver.correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ driver.correctedPricePerSeat }}
              </td>
              <td>
                <v-text-field
                  v-model="driver.commission"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ driver.commissionPricePerSeat }}
              </td>
            </tr>
            <tr v-show="showStaff">
              <td
                class="text-xs-center" 
                colspan="6"
              >
                Гиды
                <v-btn 
                  color="green"
                  fab
                  flat
                  @click="showGuides = !showGuides"
                >
                  <v-icon>
                    expand_{{ showGuides ? 'less' : 'more' }}
                  </v-icon>
                </v-btn>
              </td>
            </tr>
            <tr
              v-for="(guide, i) in getTour.guide"
              v-show="showGuides"
              :key="`Guide-${i}`"
            >
              <td>
                {{ guide.guide.name }}
                {{ guide }}
                <div
                  v-if="guide.guide.options.hotel"
                >
                  Проживание: 
                  <!-- <div 
                    v-for="(room, r) in driver.hotelPrice"
                    :key="`Room-${r}`"
                  >
                    День: {{ room.day }}
                    <br>
                    <span class="body-1 grey--text">
                      {{ room.hotelName }}, {{ room.roomName }}
                    </span>
                    <br>
                    <span class="body-1 grey--text">
                      Цена (стандарт): {{ room.hotelStdPrice }}
                      <br>
                      Цена (сингл): {{ room.hotelSnglPrice }}
                    </span>
                  </div> -->
                </div>
                <!-- <div
                  v-if="driver.mealPrice"
                >
                  Питание:
                  <div
                    v-for="(meal, m) in driver.mealPrice"
                    :key="`Meal-${m}`"
                  >
                    День: {{ meal.day }}
                    <br>
                    <span class="body-1 grey--text">
                      {{ meal.mealName }}
                    </span>
                    <br>
                    <span class="body-1 grey--text">
                      Цена: {{ meal.mealPrice }}
                    </span>
                  </div>
                </div> -->
              </td>
              <!-- <td>
                {{ driver.totalPricePerSeat }}
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
                    {{ driver.totalPrice }} / 
                    {{ getTour.qnt }} чел.
                  </span>
                </v-tooltip>
              </td>
              <td>
                <v-text-field
                  v-model="driver.correction"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ driver.correctedPricePerSeat }}
              </td>
              <td>
                <v-text-field
                  v-model="driver.commission"
                  @input="correctPrice"
                />
              </td>
              <td>
                {{ driver.commissionPricePerSeat }}
              </td> -->
            </tr>
            <tr>
              <td>
                Итого: 
                <div class="body-1 grey--text">
                  Тип туриста: {{ (getCurrentTourCustomers.find(c => c.id == currentCustomerType)).name }}
                </div>
              </td>
              <td>
                {{ getTour.totalPrice.toFixed(2) }}
              </td>
              <td>
                <span class="body-1 grey--text">
                  Наценка средняя: {{ getAverageCorrection }}%
                </span>
              </td>
              <td>
                {{ (getTour.correctedPrice).toFixed(2) }}
              </td>
              <td>
                <span class="body-1 grey--text">
                  Комиссия средняя: {{ getAverageCommission }}%
                </span>
              </td>
              <td>
                {{ parseInt(getTour.commissionPrice).toFixed(2) }}
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
                  Общая стоимость: 
                </span>
                {{ parseInt(price.commissionStandardPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Комиссия: 
                </span>
                {{ parseInt(price.commissionStandardPrice - price.standardPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ parseInt(price.standardPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Затраты:
                </span> 
                {{ parseInt(price.nettoStandardPrice).toFixed(2) }}
                <v-divider />
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ parseInt(price.standardPrice - price.nettoStandardPrice).toFixed(2) }}
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ parseInt(price.commissionSinglePrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Комиссия: 
                </span>
                {{ parseInt(price.commissionSinglePrice - price.singlePrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ parseInt(price.singlePrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Затраты:
                </span> 
                {{ parseInt(price.nettoSinglePrice).toFixed(2) }}
                <v-divider />
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ parseInt(price.singlePrice - price.nettoSinglePrice).toFixed(2) }}
              </td>
              <td class="body-2">
                <span class="body-1 grey--text">
                  Общая стоимость: 
                </span>
                {{ parseInt(price.commissionExtraPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Комиссия: 
                </span>
                {{ parseInt(price.commissionExtraPrice - price.addPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Оплата оператору: 
                </span>
                {{ parseInt(price.addPrice).toFixed(2) }}
                <br>
                <span class="body-1 grey--text">
                  Затраты:
                </span> 
                {{ parseInt(price.nettoAddPrice).toFixed(2) }}
                <v-divider />
                <span class="body-1 grey--text">
                  Прибыль оператора: 
                </span>
                {{ parseInt(price.addPrice - price.nettoAddPrice).toFixed(2) }}
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
      showStaff: false,
      showDrivers: false,
      showGuides: false,
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
    // getTour: {
    //   handler(value) {
    //     this.updateTourTotalPrice()
    //     this.updateTourCorrectedPrice()
    //     // this.updateCommissionPriceValues()
    //     this.updateTourCommissionPrice()
    //   },
    //   deep: true,
    // },
    currentCustomerType: {
      handler(value) {
        this.updateCurrentCustomerType(value)
        this.updateTourCorrectedPrice()
        this.updateCommissionPriceValues()
        this.updateTourCommissionPrice()
      },
    },
  },
  mounted() {
    this.generateTourCalcCustomerTypes(this.getCurrentTourCustomers)
    this.updateTourStaff()
    this.updateTourTotalPrice()
    this.updateCorrectedPriceValues()
    this.updateTourCorrectedPrice()
    this.updateCommissionPriceValues()
    // this.updateTourCommissionPrice()
    // this.calculatePriceForEveryCustomer()
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
      'updateTourCommissionPrice',
      'updateTourStaff',
    ]),
    saveTour() {
      console.log(this.getTour)
    },
    inputCorrection() {
      this.updateCorrectionToAll(this.correctionToAll)
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      this.updateCommissionPriceValues()
      this.updateTourCommissionPrice()
    },
    inputCommission() {
      this.updateCommissiontoAll(this.commissionToAll)
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      this.updateCommissionPriceValues()
      this.updateTourCommissionPrice()
    },
    correctPrice() {
      this.updateCorrectedPriceValues()
      this.updateTourCorrectedPrice()
      this.updateCommissionPriceValues()
      this.updateTourCommissionPrice()
    },
    commissPrice() {
      this.updateTourCorrectedPrice()
      this.updateCommissionPriceValues()
      this.updateTourCommissionPrice()
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
        console.log(customer.name)
        setTimeout(() => { 
          this.currentCustomerType = customer.id
          this.updateCorrectedPriceValues()
          this.updateTourCommissionPrice()
        }, 300)
      })
      setTimeout(() => {
        this.currentCustomerType = prevCustomer
        this.updateCurrentCustomerType(this.currentCustomerType)
        this.updateCorrectedPriceValues()
        this.updateTourCommissionPrice()
      }, 2000)
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
    border: 1px solid #e8e8e8;
    padding: 16px;
    font-size: 24px;
    font-weight: 250;
  }
  td {
    text-align: left
  }
}
</style>
