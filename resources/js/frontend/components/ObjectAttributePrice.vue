<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="3">
        <v-select
          v-model="filterValue"
          :items="filterOptions"
          color="#aa282a"
          label="Фильтр периодов"
          clearable
        />
      </v-col>
    </v-row>
    <v-simple-table v-if="item.priceable.length > 0">
      <template v-slot:default>
        <thead>
          <th>
            Начало периода
          </th>
          <th>
            Конец периода
          </th>
          <th>
            Тип
          </th>
          <th v-if="objectModel == 'hotel'">
            Вариант
          </th>
          <th>
            Стоимость
          </th>
          <th>
            Действия
          </th>
        </thead>
        <PriceTable
          v-for="(period, key) in filteredPrices"
          :key="key"
          :prices="period"
          :customers="customers"
          :price-types-for-view="priceTypesForView"
          :object-model="objectModel"
          :token="token"
        />
      </template>
    </v-simple-table>
    <v-row v-if="item.priceable.length == 0" class="center mt-5">
      <div class="display-1">
        Цены и периоды не заполнены.
      </div>
    </v-row>
    <v-divider />
    <v-form ref="period" v-model="valid">
      <v-row>
        <v-col cols="12" lg="6">
          <v-menu
            v-model="showDateStart"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="290px"
          >
            <template v-slot:activator="{ on }">
              <v-text-field
                v-model="dateStart"
                color="#aa282a"
                label="Начало периода"
                :rules="[v => !!v || 'Выберите']"
                prepend-icon="event"
                clearable
                readonly
                required
                v-on="on"
              />
            </template>
            <v-date-picker
              v-model="dateStart"
              color="#aa282a"
              :first-day-of-week="1"
              locale="ru-ru"
              @input="showDateStart = false"
            />
          </v-menu>
        </v-col>
        <v-col cols="12" lg="6">
          <v-menu
            v-model="showDateEnd"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
            min-width="290px"
          >
            <template v-slot:activator="{ on }">
              <v-text-field
                v-model="dateEnd"
                color="#aa282a"
                label="Конец периода"
                :rules="[v => !!v || 'Выберите']"
                prepend-icon="event"
                clearable
                readonly
                required
                v-on="on"
              />
            </template>
            <v-date-picker
              v-model="dateEnd"
              color="#aa282a"
              :min="dateStart"
              :first-day-of-week="1"
              locale="ru-ru"
              @input="showDateEnd = false"
            />
          </v-menu>
        </v-col>
      </v-row>
    </v-form>
    <div v-if="objectModel == 'museum'">
      <v-row justify="center">
        <v-col cols="12" md="6" lg="4">
          <v-text-field
            v-model="priceForAllValue"
            label="Одна цена на все типы"
            color="#aa282a"
            @input="priceForAll"
          />
        </v-col>
      </v-row>
      <v-row justify="center">
        <v-col
          v-for="(customer, i) in resultArray"
          :key="customer.id"
          cols="12"
          md="6"
          lg="4"
        >
          <v-row>
            <v-col>
              <v-text-field
                v-model="resultArray[i].price"
                color="#aa282a"
                :label="customer.name"
                :disabled="resultArray[i].is_free == 1"
                outlined
              />
              <v-checkbox
                v-model="resultArray[i].is_free"
                label="Бесплатно"
                value="1"
                @change="clearPriceValue(i)"
              />
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </div>
    <div v-if="objectModel == 'hotel'">
      <v-row justify="center">
        <v-col
          v-for="(customer, i) in resultArray"
          :key="`${customer.id}-${i}`"
          cols="12"
          md="4"
        >
          <v-text-field
            v-model="resultArray[i].price"
            :label="`${customer.name} ${customer.accom_type}`"
            color="#aa282a"
            outlined
          />
        </v-col>
      </v-row>
      <v-row v-if="hotelInfantType.hasOwnProperty('value')" justify="center">
        <v-col cols="12" md="4">
          <p class="body-1 grey--text">
            {{ hotelInfantType.text }}
          </p>
          <v-checkbox
            v-model="hotelInfantIsFree"
            label="Бесплатно"
            value="1"
            color="#aa282a"
          />
        </v-col>
      </v-row>
    </div>
    <div v-if="objectModel == 'transport'">
      <v-row>
        <v-col
          v-for="(type, i) in priceTypeOptions"
          :key="type.id"
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="transportResultArray[i].price"
            :label="type.name"
            color="#aa282a"
            outlined
          />
        </v-col>
      </v-row>
    </div>
    <div v-if="objectModel == 'meal'">
      <v-row justify="center">
        <v-col cols="12" md="6">
          <v-text-field
            v-model="resultArray[0].price"
            label="Цена"
            color="#aa282a"
            outlined
          />
        </v-col>
      </v-row>
    </div>
    <form id="price-form" action="/operator/attribute-price" method="POST">
      <input name="_token" type="hidden" :value="token" />
      <input name="parent_id" type="hidden" :value="parentId" />
      <input name="period_start" type="hidden" :value="dateStart" />
      <input name="period_end" type="hidden" :value="dateEnd" />
      <input
        v-if="objectModel != 'transport'"
        type="hidden"
        :value="JSON.stringify(resultArray)"
        name="prices_array"
      />
      <input
        v-if="objectModel == 'transport'"
        type="hidden"
        :value="JSON.stringify(transportResultArray)"
        name="prices_array"
      />
    </form>
    <v-row style="margin: 16px;">
      <v-btn :href="cancelRoute" class="tc-link-no-underline-on-hover" text>
        закрыть
      </v-btn>
      <v-spacer />
      <v-btn form="price-form" dark color="#aa282a" @click="submitForm">
        Сохранить
      </v-btn>
    </v-row>
  </v-container>
</template>
<script>
import PriceTable from './ObjectAttributePriceTable'
export default {
  name: 'ObjectAttributePrice',
  components: { PriceTable },
  props: {
    customers: {
      type: Object,
      default: null,
    },
    priceTypeOptions: {
      type: Array,
      default: null,
    },
    priceTypesForView: {
      type: Object,
      default: () => {},
    },
    parentId: {
      type: String,
      default: '',
    },
    parentModel: {
      type: String,
      default: '',
    },
    objectModel: {
      type: String,
      default: '',
    },
    token: {
      type: String,
      required: true,
      default: null,
    },
    item: {
      type: Object,
      default: () => {},
    },
    cancelRoute: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      showDateStart: false,
      dateStart: '',
      showDateEnd: false,
      dateEnd: '',
      customerTypeId: null,
      resultArray: [],
      transportResultArray: [],
      hotelCustomerTypes: [],
      hotelInfantType: {},
      hotelAccoms: ['Основное', 'Single', 'Дополнительное'],
      hotelInfantIsFree: false,
      filterValue: null,
      valid: false,
      priceForAllValue: null,
    }
  },
  computed: {
    customersArray: function() {
      let result = []
      Object.keys(this.customers).map(key => {
        if (key != '') {
          result.push({
            value: key,
            text: this.customers[key],
          })
        }
      })
      return result
    },
    filterOptions: function() {
      let result = []
      this.item.priceable.forEach(price => {
        const period = `${price.period_start} - ${price.period_end}`
        if (!result.includes(period)) result.push(period)
      })
      return result
    },
    filteredPrices: function() {
      let result = []
      if (this.filterValue == null) {
        result = this.item.priceable
      } else {
        this.item.priceable.forEach(price => {
          const period = `${price.period_start} - ${price.period_end}`
          if (period == this.filterValue) {
            result.push(price)
          }
        })
      }
      result = this.compactPricesByPeriod(result)
      return result
    },
  },
  mounted() {
    this.constructResultArray()
  },
  methods: {
    validate() {
      if (this.$refs.period.validate()) {
        this.snackbar = true
      }
    },
    submitForm() {
      this.validate()
      if (this.valid) {
        const form = document.getElementById('price-form')
        if (this.hotelInfantIsFree == true) {
          const inf = {
            tour_customer_type_id: this.hotelInfantType.value,
            name: this.hotelInfantType.text,
            price: 0,
            is_free: true,
          }
          this.resultArray.push(inf)
        }
        form.submit()
      }
    },
    constructResultArray() {
      if (this.objectModel == 'museum') {
        this.resultArray = []
        this.customersArray.forEach(customer => {
          this.resultArray.push({
            tour_customer_type_id: customer.value,
            name: customer.text,
            price: null,
            is_free: false,
          })
        })
      }
      if (this.objectModel == 'transport') {
        this.transportResultArray = []
        this.priceTypeOptions.forEach(type => {
          this.transportResultArray.push({
            tour_price_type_id: type.id,
            price: null,
          })
        })
      }
      if (this.objectModel == 'meal') {
        this.resultArray = [{ price: null }]
      }
      if (this.objectModel == 'hotel') {
        this.resultArray = []
        const adult = this.customersArray.find(
          customer => customer.text == 'Взрослый'
        )
        const child = this.customersArray.find(
          customer => customer.text == 'Ребенок'
        )
        this.hotelInfantType = this.customersArray.find(
          customer => customer.text == 'Инфант'
        )
        this.hotelCustomerTypes = [adult, child]
        this.hotelCustomerTypes.forEach(type => {
          this.hotelAccoms.forEach(accom => {
            this.resultArray.push({
              tour_customer_type_id: parseInt(type.value),
              accom_type: accom,
              name: type.text,
              price: null,
              is_free: false,
            })
          })
        })
      }
    },
    clearPriceValue(index) {
      if (this.resultArray[index].is_free == 1) {
        this.resultArray[index].price = 0
      }
    },
    priceForAll() {
      this.resultArray.forEach(price => (price.price = this.priceForAllValue))
    },
    compactPricesByPeriod(prices) {
      let result = {}
      prices.forEach(price => {
        const period = `${price.period_start}-${price.period_end}`
        if (!Object.keys(result).includes(period)) {
          result[period] = []
        }
        result[period].push(price)
      })
      return result
    },
  },
}
</script>