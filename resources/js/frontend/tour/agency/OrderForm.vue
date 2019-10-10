<template>
  <div>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs5>
        <v-text-field
          v-model="order.name"
          label="Имя"
          :rules="[v => !!v || 'Укажите имя']"
          :name="isRequired ? 'customer[' + id + '][first_name]' : ''"
          color="green lighten-3"
          :required="isRequired"
        />
        <v-text-field
          v-model="order.surname"
          label="Фамилия"
          :rules="[v => !!v || 'Укажите фамилию']"
          :name="isRequired ? 'customer[' + id + '][last_name]' : ''"
          color="green lighten-3"
          :required="isRequired"
        />
        <v-text-field
          v-model="order.email"
          label="Email"
          :rules="[v => !!v || 'Укажите email']"
          :name="isRequired ? 'customer[' + id + '][email]' : ''"
          color="green lighten-3"
        />
        <v-checkbox
          label="Квота"
          disabled
        />
      </v-flex>
      <v-flex 
        xs5
        offset-xs2
      >
        <v-select
          v-model="order.gender"
          :items="genders"
          item-text="text"
          item-name="value"
          label="Пол"
        />
        <input 
          v-model="order.gender"
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][gender]' : ''"
        >
        <v-layout 
          row 
          wrap
        >
          <v-text-field
            v-model="order.passport"
            :label="passportMask.label"
            :mask="passportMask.mask"
            :placeholder="passportMask.placeholder"
            :rules="[v => !!v || 'Укажите данные']"
            :name="isRequired ? 'customer[' + id + '][passport]' : ''"
            color="green lighten-3"
            :required="isRequired"
          />
          <v-checkbox 
            v-if="!isForeigner"
            v-model="isRfIntPass" 
            :required="isRequired"
            color="green"
            label="Загран" 
          />
          <input
            v-model="isRfIntPass"
            type="hidden"
            :name="isRequired ? 'customer[' + id + '][isRfIntPass]' : ''"
          >
        </v-layout>
        <v-layout 
          row 
          wrap
        >
          <v-menu
            ref="menu"
            v-model="menu"
            :close-on-content-click="false"
            :nudge-right="40"
            lazy
            transition="scale-transition"
            offset-y
            full-width
            min-width="290px"
          >
            <template v-slot:activator="{ on }">
              <v-text-field
                v-model="date"
                clearable
                label="Дата рождения"
                :name="isRequired ? 'customer[' + id + '][dob]' : ''"
                prepend-icon="event"
                readonly
                v-on="on"
              />
            </template>
            <v-date-picker
              ref="picker"
              v-model="date"
              color="green"
              locale="ru-ru"
              :max="new Date().toISOString().substr(0, 10)"
              min="1920-01-01"
              @change="save"
            />
          </v-menu>
        </v-layout>
        <v-layout 
          row 
          wrap
        >
          <v-checkbox 
            v-model="manualPens"
            label="Пенсионер"
            color="green"
          />
          <v-checkbox 
            v-model="isForeigner"
            label="Иностранец"
            color="green"
          />  
          <v-checkbox 
            v-model="isSinglePlace"
            label="Single-размещение"
            color="green"
          />  
        </v-layout>
        <div>
          Возраст: {{ age }}
          <br>
          Тип туриста: {{ profileCustomerType }}
          <br>
          Тип размещения: {{ profilePlace }}
        </div>
        <v-text-field
          v-model="order.address"
          label="Адрес"
          :rules="[v => !!v || 'Укажите адрес']"
          :name="isRequired ? 'customer[' + id + '][address]' : ''"
          color="green lighten-3"
        />
        <input 
          v-model="meal"
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][meal]' : ''"
        >
        <input 
          v-model="roomId"
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][room]' : ''"
        >
      </v-flex>
    </v-layout>
    <v-divider />
    <v-btn
      color="green"
      dark
      flat
      @click="showChangeMeal = !showChangeMeal"
    >
      {{ showChangeMeal ? 'Скрыть' : 'Выбор питания' }}
      <v-icon right>
        expand_{{ showChangeMeal ? 'less' : 'more' }}
      </v-icon>
    </v-btn>
    <ChangeMeal 
      v-show="showChangeMeal"
      :profile-id="id"
      :tour="tour"
    />  
    <v-layout 
      row 
      wrap
    >
      <v-flex xs6>
        <div>
          <BusScheme 
            :transport="transport"
            :profile-id="id"
          />
          <div v-if="profileBusSeatId != ''">
            <span class="subheading">
              Выбрано место: {{ profileBusSeatId }}
            </span>
            <v-btn 
              color="red"
              fab
              flat
              @click="clearBusSeatId"
            >
              <v-icon>delete_forever</v-icon>
            </v-btn>
          </div>
        </div>
        <input 
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][busSeatId]' : ''"
          :value="profileBusSeatId"
        >
      </v-flex>
      <v-spacer />
      <v-flex>
        <div
          class="subheading"
        >
          <span class="grey--text">
            Цена:
          </span> 
          {{ parseInt(profilePrice) }}
          <br>
          <span class="grey--text">
            Комиссия:
          </span> 
          {{ parseInt(profileCommission) }}
        </div>
        <input 
          class="price"
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][price]' : ''"
          :value="profilePrice"
        >
        <input 
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][mealByDay]' : ''"
          :value="JSON.stringify({content: profileMealData.mealByDay})"
        >
        <input 
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][mealPriceArray]' : ''"
          :value="JSON.stringify({content: profileMealData.mealPriceArray})"
        >
        <input 
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][isPens]' : ''"
          :value="manualPens"
        >
        <input 
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][isForeigner]' : ''"
          :value="isForeigner"
        >
        <input 
          type="hidden"
          :name="isRequired ? 'customer[' + id + '][isSinglePlace]' : ''"
          :value="isSinglePlace"
        >
      </v-flex>
    </v-layout>
    <v-layout 
      row 
      wrap
    >
      <v-spacer />
      <v-btn 
        flat 
        color="red"
        @click="resetForm"
      >
        Очистить
      </v-btn>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import moment from 'moment'
import BusScheme from '../includes/BusScheme'
import ChangeMeal from './ChangeMeal'
export default {
  name: 'OrderForm',
  components: {
    BusScheme,
    ChangeMeal,
  },
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
    profiles: {
      type: Object,
      default: () => {
        return {}
      }
    },
    profileId: {
      type: Number,
      default: 0
    },
    roomId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      order: {
        name: '',
        gender: '',
        email: '',
        passport: '',
        address: '',
      },
      choosenSeat: [],
      date: null,
      menu: false,
      genders: [
        { id: 1, value: 'male', text: 'Мужской' },
        { id: 2, value: 'female', text: 'Женский' },
      ],
      meal: '',
      meals: ['Завтраки', 'Полупансион', 'Полный пансион'],
      age: NaN,
      priceList: [],
      pensRange: {
        male: 55,
        female: 50,
      },
      manualPens: false,
      isForeigner: false,
      isSinglePlace: false,
      showChangeMeal: false,
      isRfIntPass: false,
    }
  },
  computed: {
    ...mapGetters([
      'getChdRange',
      'getPensRange',  
      'getMealByDay',
      'getProfilePrice',
      'getProfileCommission',
    ]),
    profile: function() {
      return this.$store.getters.getProfile(this.id)
    },
    transport: function() {
      return JSON.parse(this.tour.extra).transport[0]
    },
    id: function() {
      return this.profileId + (this.roomId * 3)
    },
    isRequired: function() {
      // If this is first form on tab. Id = 0, 3, 6, etc.
      if (this.id == (this.roomId * 3)) {
        return true
      }
      else if (this.order.name != undefined && this.order.name != '') {
        return true
      }
      else {
        return false
      }
    },
    isChd: function() {
      if (this.age < this.getChdRange.to && !this.manualPens) {
        return true
      }
      return false
    },
    isPens: function() {
      if (this.order.gender == 'male' && this.age >= this.getPensRange.maleFrom) {
        return true
      }
      if (this.order.gender == 'female' && this.age >= this.getPensRange.femaleFrom) {
        return true
      }
      if (this.manualPens) {
        return true
      }
      return false
    },
    profileCustomerType: function() {
      let type = ''
      if (!this.age) return 'age = nan'
      if (this.isForeigner) {
        type = 'FRGN'
      } else if (this.isChd)  {
        type = 'CHD'
      } else if (this.isPens) {
        type = 'PENS'
      } else {
        type = 'ADL'
      }
      return type
    },
    profilePlace: function() {
      let place = 'STD'
      if (this.id == (2 + this.roomId * 3)) place = 'EXTRA'
      if (this.isSinglePlace) place = 'SNGL'
      return place
    },
    profilePrice: function() {
      return this.$store.getters.getProfilePrice(this.id)
    },
    profileCommission: function() {
      return this.$store.getters.getProfileCommission(this.id)
    },
    profileMealData: function() {
      return this.$store.getters.getProfileMealData(this.id)
    },
    profileBusSeatId: function() {
      return this.$store.getters.getProfileBusSeatId(this.id)
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
      if (this.isForeigner) {
        return foreignerPass
      }
      else if (this.age < 14 && !this.isRfIntPass) {
        return birthCert
      }
      else if (this.isRfIntPass) {
        return rfInternationalPass
      }
      else {
        return rfLocalPass
      }
    }
  },
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
    age() {
      this.updateProfilePrice({
        profileId: this.id,
        profileCustomerType: this.profileCustomerType,
        age: this.age,
        profilePlace: this.profilePlace,
        name: this.order.name,
      })
      this.updateOrderPrice()
      this.updateOrderCommission()
    },
    profileCustomerType() {
      this.updateProfilePrice({
        profileId: this.id,
        profileCustomerType: this.profileCustomerType,
        age: this.age,
        profilePlace: this.profilePlace,
        name: this.order.name,
      })
      this.updateOrderPrice()
      this.updateOrderCommission()
    },
    date(val) {
      if (!val) this.age = NaN
    },
    profilePlace() {
      this.updateProfilePrice({
        profileId: this.id,
        profileCustomerType: this.profileCustomerType,
        age: this.age,
        profilePlace: this.profilePlace,
        name: this.order.name,
      })
      this.updateOrderPrice()
      this.updateOrderCommission()
    }
  },
  mounted() {
    this.priceList = JSON.parse(this.tour.extra).calc.priceList
    console.log(this.priceList)
    this.updateOrderProfiles(this.id)
    this.updatePriceList(this.priceList)
    this.updateChdRange(this.priceList)
    this.updatePensRange(this.priceList)
  },
  methods: {
    ...mapActions([
      'updateChdRange',
      'updatePensRange',
      'updatePriceList',
      'updateOrderTotalPrice',
      'updateOrderProfiles',
      'updateProfilePrice',
      'updateOrderPrice',
      'updateOrderCommission',
      'resetProfile',
      'updateResetProfileFlag',
      'removeBusSeatIdFromCurrent',
    ]),
    ...mapGetters([
      'getChdPrice',
      'getPensPrice',
    ]),
    save(date) {
      this.$refs.menu.save(date)
      this.age = moment().diff(date, 'years')
    },
    resetForm() {
      this.order = {
        name: '',
        gender: '',
        email: '',
        passport: '',
        address: '',
      }
      this.manualPens = false
      this.isForeigner = false
      this.date = undefined
      this.resetProfile(this.id)
    },
    log() {
      console.log(this.profileMealData)
    },
    clearBusSeatId() {
      this.removeBusSeatIdFromCurrent({
        profileId: this.id,
        busSeatId: this.profileBusSeatId,
      })
    }
  }
}
</script>

<style>

</style>
