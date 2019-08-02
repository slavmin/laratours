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
              Наценка, %
            </th>
            <th>
              Итого
            </th>
          </thead>
          <tbody>
            <tr>
              <td colspan="4">
                Транспорт
              </td>
            </tr>
            <tr 
              v-for="transport in getTour.transport"
              :key="transport.id"
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
            <tr>
              <td colspan="4">
                Экскурсии
              </td>
            </tr>
            <tr 
              v-for="event in getTour.museum"
              :key="event.id"
            >
              <td>
                {{ event.museum.name }}:
                <br>
                {{ event.obj.description }}
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
            <tr>
              <td colspan="4">
                Размещение
              </td>
            </tr>
            <tr 
              v-for="hotel in getTour.hotel"
              :key="hotel.id"
            >
              <td>
                {{ hotel.hotel.name }}:
                <br>
                {{ JSON.parse(hotel.obj.extra).roomType }}
              </td>
              <td class="price">
                {{ hotel.obj.price }}
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
            <tr>
              <td colspan="4">
                Гиды
              </td>
            </tr>
            <tr 
              v-for="guide in getTour.guide"
              :key="guide.id"
            >
              <td>
                {{ guide.name }}:
              </td>
              <td class="price">
                {{ JSON.parse(guide.description).price }}
              </td>
              <td>
                <v-text-field
                  v-model="guide.correction"
                  name="correction"
                />
              </td>
              <td>
                <v-text-field
                  :value="corPrice(JSON.parse(guide.description).price, guide.correction)"
                  class="corrected-price"
                  name="corrected"
                />
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Гиды
              </td>
            </tr>
            <tr 
              v-for="attendant in getTour.attendant"
              :key="attendant.id"
            >
              <td>
                {{ attendant.name }}:
              </td>
              <td class="price">
                {{ attendant.price }}
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
            <tr>
              <td colspan="4">
                Доп.услуги
              </td>
            </tr>
            <tr 
              v-for="price in getTour.customPrice"
              :key="price.id"
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
                {{ totalPrice }}
              </td>
              <td />
              <td>
                {{ getCorrectedPrice }}
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
            :value="getTour.options.type"
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
  created() {
    this.getTour
    this.total()
  },
  updated() {
    this.total()
    console.log(this.getTour)
  },
  methods: {
    ...mapActions(['updateTransportPrice']),
    total() {
      // Calculate total price (first column)
      let summ = 0
      Array.from(document.getElementsByClassName('price')).forEach((item) => {
        summ += parseInt(item.innerText)
      })
      this.totalPrice = summ
    },
    saveTour() {
      console.log(this.getTour)
    },
    corPrice(price, correction) {
      if (correction == NaN) {
        return price
      } else {
        let total = parseInt(price) + (parseInt(price) * parseInt(correction)) / 100
        return total
      }
      
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
}
</style>
