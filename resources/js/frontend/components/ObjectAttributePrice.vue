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
    <div v-if="objectModel != 'transport'">
      <v-row
        v-for="(customer, i) in resultArray"
        :key="customer.id"
      >
        <v-col
          cols="12"
          lg="4"
        >
          <p>
            {{ customer.name }}
          </p>
        </v-col>
        <v-col
          cols="12"
          lg="4"
        >
          <v-text-field
            v-model="resultArray[i].price"
            color="#aa282a"
            label="Цена"
            :disabled="resultArray[i].is_free == 1"
          />
        </v-col>
        <v-col
          cols="12"
          lg="4"
        >
          <v-checkbox
            v-model="resultArray[i].is_free"
            label="Бесплатно"
            value="1"
            @change="clearPriceValue(i)"
          />
        </v-col>
      </v-row>
    </div>
    <div v-if="objectModel == 'transport'">
      <v-row
        v-for="(type, i) in priceTypeOptions"
        :key="type.id"
      >
        <v-col
          cols="12"
          lg="6"
        >
          <p>
            {{ type.name }}
          </p>
        </v-col>
        <v-col
          cols="12"
          lg="6"
        >
          <v-text-field
            v-model="transportResultArray[i].price"
            color="#aa282a"
            label="Цена"
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
      form.submit()
    },
    constructResultArray() {
      if (this.objectModel != 'transport') {
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
    },
    clearPriceValue(index) {
      if (this.resultArray[index].is_free == 1) {
        this.resultArray[index].price = 0
      }
    },
  },
}
</script>