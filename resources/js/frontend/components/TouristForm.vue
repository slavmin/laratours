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
      <v-row align-items="center">
        <v-col
          class="py-0"
          cols="8"
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
        </v-col>
        <v-col
          v-if="age"
          cols="4"
          class="py-0"
        >
          {{ age }}
        </v-col>
      </v-row>
      <v-row>
        <v-col
          class="py-0"
          cols="8"
        >
          <v-text-field
            v-mask="passportMask.mask"
            :name="`customer[${index}][passport]`"
            color="#aa282a"
            :label="passportMask.label"
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
        :disabled="tourPriceIsChanged"
        @change="newPrice(customer.price)"
      />
      <input
        v-model="customer.price"
        :name="`customer[${index}][price]`"
        type="hidden"
      >
      <div v-if="!privateForm">
        <h4
          v-if="customer.price"
          class="text-right"
        >
          Цена:
          <span v-if="!manualPriceFlag">{{ customer.price }}</span>
        </h4>
      </div>
      <div v-if="privateForm">
        <h4
          v-if="customer.price"
          class="text-right"
        >
          Цена:
          <span v-if="!manualPriceFlag">{{ customer.price }}</span>
          <v-text-field
            v-if="manualPriceFlag"
            v-model="customer.price"
            color="#aa282a"
            @input="newPrice(customer.price)"
          />
          <v-btn
            v-if="!manualPriceFlag"
            icon
            @click="enterManualPrice"
          >
            <v-icon color="yellow">
              edit
            </v-icon>
          </v-btn>
        </h4>
        <div
          v-if="tourPriceIsChanged"
          class="text-right"
        >
          Изменилась цена в туре!
          <v-btn
            icon
            @click="enableEditPrice"
          >
            <v-icon color="yellow">
              edit
            </v-icon>
          </v-btn>
        </div>
        <div
          v-if="editPriceFlag"
          class="text-right"
        >
          Старая цена: {{ oldPrice }}
          <v-btn
            icon
            @click="returnPrice"
          >
            <v-icon color="green">
              restore
            </v-icon>
          </v-btn>
        </div>
      </div>
    </v-col>
    <!--
          <v-col
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
import { mask } from 'vue-the-mask'
export default {
  name: 'TouristForm',
  directives: {
    mask,
  },
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
          price: null,
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
    privateForm: {
      type: Boolean,
      default: false,
    },
    tourDate: {
      type: String,
      default: null,
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
      tourPriceIsChanged: false,
      editPriceFlag: false,
      oldPrice: null,
      manualPriceFlag: false,
      age: null,
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
        mask: 'XXXXXXXXXXXXXXX',
        label: 'Свидетельство о рождении',
        placeholder: 'VII-МЮ 123456',
      }
      if (this.isForeigner) {
        return foreignerPass
      } else if (this.age < 14 && !this.customer.is_rf_int_passport) {
        return birthCert
      } else if (this.customer.is_rf_int_passport) {
        return rfInternationalPass
      } else {
        return rfLocalPass
      }
      if (this.customer.is_rf_int_passport) {
        return rfInternationalPass
      }
      return rfLocalPass
    },
  },
  watch: {
    customer: {
      handler: function() {
        this.newPrice(this.customer.price)
      },
    },
    customer: {
      handler: function() {
        this.age = moment().diff(this.customer.dob, 'years')
      },
      deep: true,
    },
  },
  mounted() {
    if (this.customer.name !== null) {
      this.newPrice(this.customer.price)
    }
    if (this.privateForm) {
      this.isTourPriceChanged()
    }
  },
  methods: {
    ...mapActions(['updateProfilePrice']),
    newPrice(price) {
      if (price === null) price = 0
      this.updateProfilePrice({
        id: this.index,
        price: price,
      })
    },
    isTourPriceChanged() {
      if (
        this.customer.price != 0 &&
        !this.prices.find(price => price.value == this.customer.price)
      ) {
        this.tourPriceIsChanged = true
      }
    },
    enableEditPrice() {
      this.editPriceFlag = true
      this.tourPriceIsChanged = false
      this.oldPrice = this.customer.price
    },
    returnPrice() {
      this.editPriceFlag = false
      this.tourPriceIsChanged = true
      this.customer.price = this.oldPrice
    },
    enterManualPrice() {
      this.manualPriceFlag = true
    },
  },
}
</script>