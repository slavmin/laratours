<template>
  <div>
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
                    outline
                  /> 
                </v-flex>
              </v-layout>
            </th>
            <th>
              Итого
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
                {{ transport.company.name }}:
                {{ transport.item.name }}.
              </td>
              <td class="price">
                {{ transport.totalPrice }}
              </td>
              <td>
                <v-text-field
                  v-model="transport.correction"
                  name="correction"
                />
              </td>
              <td>
                <v-text-field
                  v-model="transport.correctedPrice"
                  class="corrected-price"
                  name="corrected"
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
              </td>
              <td class="price">
                {{ event.obj.price }}
              </td>
              <td>
                <v-text-field
                  v-model="event.correction"
                  name="correction"
                />
              </td>
              <td>
                <v-text-field
                  v-model="event.correctedPrice"
                  class="corrected-price"
                  name="corrected"
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
                {{ JSON.parse(hotel.obj.extra).roomType }}
                <br>
                <div class="body-1 grey--text">
                  Ночей: {{ hotel.obj.day }}
                  <br>
                  Цена: {{ hotel.obj.price }}
                </div>
              </td>
              <td class="price">
                {{ hotel.obj.totalPrice }}
              </td>
              <td>
                <v-text-field
                  v-model="hotel.correction"
                  name="correction"
                />
              </td>
              <td>
                <v-text-field
                  v-model="hotel.correctedPrice"
                  class="corrected-price"
                  name="corrected"
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
                {{ guide.name }}:
                <div class="body-1 grey--text">
                  Часов: {{ guide.duration }}
                  <br>
                  Цена: {{ guide.price }}
                </div>
              </td>
              <td class="price">
                {{ guide.totalPrice }}
              </td>
              <td>
                <v-text-field
                  v-model="guide.correction"
                  name="correction"
                />
              </td>
              <td>
                <v-text-field
                  v-model="guide.correctedPrice"
                  class="corrected-price"
                  name="corrected"
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
                {{ attendant.name }}:
                <br>
                <div class="body-1 grey--text">
                  Часов: {{ attendant.duration }}
                  <br>
                  Цена: {{ attendant.price }}
                </div>
              </td>
              <td class="price">
                {{ attendant.totalPrice }}
              </td>
              <td>
                <v-text-field
                  v-model="attendant.correction"
                  name="correction"
                />
              </td>
              <td>
                <v-text-field
                  v-model="attendant.correctedPrice"
                  class="corrected-price"
                  name="corrected"
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
              <td />
              <td>
                {{ price.value }}
              </td>
            </tr>
            <tr>
              <td>
                Итого: 
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
          <input 
            type="hidden"
            :value="JSON.stringify(tourExtra)"
            name="description"
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
    };
  },
  computed: {
    ...mapGetters([
      'getTour',
      'getCorrectedPrice',
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
        console.log(this.getTour)
        this.updateTourCorrectedPrice()
      },
      deep: true,
    },
    correctionToAll: {
      handler(value) {
        console.log('client correction: ', value)
        this.updateCorrectionToAll(value)
      },
      deep: true,
    }
  },
  mounted() {
    this.updateTourTotalPrice()
  },
  methods: {
    ...mapActions([
      'updateTransportPrice',
      'updateTourTotalPrice',  
      'updateTourCorrectedPrice',
      'updateCorrectionToAll',
    ]),
    // total() {
    //   // Calculate total price (first column)
    //   let summ = 0
    //   Array.from(document.getElementsByClassName('price')).forEach((item) => {
    //     summ += parseInt(item.innerText)
    //   })
    //   this.totalPrice = summ
    // },
    saveTour() {
      console.log(this.getTour)
    },
    inputCorrection() {
      console.log('changed')
    }
  },
};
</script>

<style lang="scss" scoped>
.summary {
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
