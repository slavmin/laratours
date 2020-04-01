<template>
  <v-row>
    <v-col
      cols="12"
      md="6"
      lg="4"
    >
      <v-text-field
        :name="`customer[${index}][first_name]`"
        color="#aa282a"
        label="Имя"
        :value="customer.first_name"
        maxlength="191"
        outlined
        required
      />
      <v-text-field
        :name="`customer[${index}][last_name]`"
        color="#aa282a"
        label="Фамилия"
        :value="customer.last_name"
        maxlength="191"
        outlined
        required
      />
      <v-select
        v-model="customer.gender"
        :name="`customer[${index}][gender]`"
        :items="genders"
        color="#aa282a"
        item-color="#aa282a"
        label="Пол"
        outlined
        required
      />
    </v-col>
    <v-col
      cols="12"
      md="6"
      lg="4"
    >
      <v-menu
        v-model="showDatePicker"
        :close-on-content-click="false"
        :nudge-right="40"
        transition="scale-transition"
        offset-y
        min-width="290px"
      >
        <template v-slot:activator="{ on }">
          <v-text-field
            v-model="customer.dob"
            :name="`customer[${index}][dob]`"
            label="Дата рождения"
            color="#aa282a"
            readonly
            clearable
            outlined
            v-on="on"
          />
        </template>
        <v-date-picker
          v-model="customer.dob"
          :max="dateToday"
          color="#aa282a"
          locale="ru-ru"
          first-day-of-week="1"
          @input="showDatePicker = false"
        />
      </v-menu>
      <v-row>
        <v-col
          class="py-0"
          cols="8"
        >
          <v-text-field
            :name="`customer[${index}][passport]`"
            color="#aa282a"
            :label="passportMask.label"
            :mask="passportMask.mask"
            :placeholder="passportMask.placeholder"
            :value="customer.passport"
            maxlength="191"
            outlined
            required
          />
        </v-col>
        <v-col
          cols="4"
          class="py-0"
        >
          <v-checkbox
            v-model="customer.is_rf_int_passport"
            :name="`customer[${index}][is_rf_int_passport]`"
            value="1"
            color="#aa282a"
            label="Загран"
          />
        </v-col>
      </v-row>
      <v-text-field
        :name="`customer[${index}][address]`"
        color="#aa282a"
        label="Адрес"
        :value="customer.address"
        maxlength="191"
        outlined
        required
      />
    </v-col>
    <v-col
      cols="12"
      md="6"
      lg="4"
      align-self="end"
      class="pb-5"
    >
      <v-select
        v-model="customer.price"
        :items="prices"
        color="#aa282a"
        clearable
        label="Тип туриста"
        @change="newPrice(customer.price)"
      />
      <input
        v-model="customer.price"
        type="hidden"
        :name="`customer[${index}][price]`"
      >
      <h4
        v-if="customer.price"
        class="text-right"
      >
        Цена: {{ customer.price }}
      </h4>
    </v-col>
    <!-- <v-col
      cols="12"
      md="6"
      lg="4"
    >
      <v-checkbox
        v-model="isPens"
        label="Пенсионер"
        color="#aa282a"
      />
      <v-checkbox
        v-model="isForeigner"
        label="Иностранец"
        color="#aa282a"
      />
      <v-checkbox
        v-model="isSinglePlace"
        label="Single-размещение"
        color="#aa282a"
      />
    </v-col> -->
  </v-row>
</template>
<script>
import moment from 'moment'
import { mapActions } from 'vuex'
export default {
  name: 'TouristForm',
  props: {
    customer: {
      type: Object,
      default: () => {
        return {
          first_name: null,
          last_name: null,
          gender: null,
          dob: null,
          passport: null,
          address: null,
          is_rf_int_passport: null,
          price: 0,
        }
      },
    },
    index: {
      type: Number,
      default: 0,
    },
    prices: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      genders: ['Мужской', 'Женский'],
      showDatePicker: false,
      isPens: false,
      isForeigner: false,
      isSinglePlace: false,
      price: null,
    }
  },
  computed: {
    dateToday: function() {
      return moment().format('YYYY-MM-DD')
    },
    passportMask: function() {
      const foreignerPass = {
        label: 'Паспорт иностранца',
      }
      const rfLocalPass = {
        mask: '#### - ### ###',
        label: 'Паспорт РФ',
        placeholder: '4605 - 390 089',
      }
      const rfInternationalPass = {
        mask: '## #######',
        label: 'Загранпаспорт РФ',
        placeholder: '52 0022196',
      }
      const birthCert = {
        label: 'Свидетельство о рождении',
        placeholder: 'VII-МЮ 123456',
      }
      // if (this.isForeigner) {
      //   return foreignerPass
      // }
      // else if (this.age < 14 && !this.profile.isRfIntPass) {
      //   return birthCert
      // }
      // else if (this.profile.isRfIntPass) {
      //   return rfInternationalPass
      // }
      // else {
      //   return rfLocalPass
      // }
      if (this.customer.is_rf_int_passport) {
        return rfInternationalPass
      }
      return rfLocalPass
    },
  },
  watch: {
    customer: {
      handler: function() {
        console.log(this.customer.price)
        this.newPrice(this.customer.price)
      },
    },
  },
  mounted() {
    if (this.customer.name !== null) {
      this.newPrice(this.customer.price)
    }
  },
  methods: {
    ...mapActions(['updateProfilePrice']),
    newPrice(price) {
      if (price === undefined) price = 0
      this.updateProfilePrice({
        id: this.index,
        price: price,
      })
    },
  },
}
</script>