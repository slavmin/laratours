<template>
  <v-container>
    <v-row>
      <v-col
        cols="12"
        lg="6"
      >
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
              prepend-icon="event"
              clearable
              readonly
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
      <v-col
        cols="12"
        lg="6"
      >
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
              prepend-icon="event"
              clearable
              readonly
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
    <div v-if="objectModel == 'museum'">
      <v-row justify="center">
        <v-col
          v-for="(customer, i) in resultArray"
          :key="customer.id"
          cols="12"
          lg="6"
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
      <v-row
        v-if="hotelInfantType.hasOwnProperty('value')"
        justify="center"
      >
        <v-col
          cols="12"
          md="4"
        >
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
        <v-col
          cols="12"
          md="6"
        >
          <v-text-field
            v-model="resultArray[0].price"
            label="Цена"
            color="#aa282a"
            outlined
          />
        </v-col>
      </v-row>
    </div>
    <form
      id="price-form"
      action="/operator/attribute-price"
      method="POST"
    >
      <input
        name="_token"
        type="hidden"
        :value="token"
      >
      <input
        name="parent_id"
        type="hidden"
        :value="parentId"
      >
      <input
        name="parent_model"
        type="hidden"
        :value="parentModel"
      >
      <input
        name="period_start"
        type="hidden"
        :value="dateStart"
      >
      <input
        name="period_end"
        type="hidden"
        :value="dateEnd"
      >
      <input
        v-if="objectModel != 'transport'"
        type="hidden"
        :value="JSON.stringify(resultArray)"
        name="prices_array"
      >
      <input
        v-if="objectModel == 'transport'"
        type="hidden"
        :value="JSON.stringify(transportResultArray)"
        name="prices_array"
      >
    </form>
  </v-container>
</template>
<script>
export default {
  name: 'ObjectAttributePrice',
  props: {
    customers: {
      type: Object,
      default: null,
    },
    priceTypeOptions: {
      type: Array,
      default: null,
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
  },
  data() {
    return {
      showDateStart: false,
      dateStart: '',
      showDateEnd: false,
      dateEnd: '',
      customerTypeId: null,
      price: null,
      resultArray: [],
      transportResultArray: [],
      hotelCustomerTypes: [],
      hotelInfantType: {},
      hotelAccoms: ['Основное', 'Single', 'Дополнительное'],
      hotelInfantIsFree: false,
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
  },
  mounted() {
    this.constructResultArray()
  },
  methods: {
    submitForm() {
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
  },
}
</script>