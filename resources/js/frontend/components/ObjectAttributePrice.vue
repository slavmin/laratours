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
    <v-row>
      <v-col
        cols="12"
        lg="6"
      >
        <v-select
          v-model="customerTypeId"
          :items="customersArray"
          color="#aa282a"
          label="Тип туриста"
        />
      </v-col>
      <v-col
        cols="12"
        lg="6"
      >
        <v-text-field
          v-model="price"
          color="#aa282a"
          label="Цена"
          @keyup.enter="submitForm"
        />
      </v-col>
    </v-row>
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
        name="tour_customer_type_id"
        type="hidden"
        :value="customerTypeId"
      >
      <input
        name="price"
        type="hidden"
        :value="price"
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
    parentId: {
      type: String,
      default: '',
    },
    parentModel: {
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
  methods: {
    submitForm() {
      const form = document.getElementById('price-form')
      form.submit()
    },
  },
}
</script>