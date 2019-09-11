<template>
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
        label="Email"
        :rules="[v => !!v || 'Укажите email']"
        :name="isRequired ? 'customer[' + id + '][email]' : ''"
        color="green lighten-3"
        :required="isRequired"
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
      <v-text-field
        v-model="order.passport"
        label="Номер документа"
        placeholder="44 00-123 123"
        :rules="[v => !!v || 'Укажите данные']"
        :name="isRequired ? 'customer[' + id + '][passport]' : ''"
        color="green lighten-3"
        :required="isRequired"
      />
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
        <v-checkbox 
          v-model="manualPens"
          label="Пенсионер"
          color="green"
        />
      </v-layout>
      <div>
        Возраст: {{ age }}
        <br>
        Пенсионер: {{ isPens }}
        <br>
        Ребёнок: {{ isChd }}
      </div>
      <v-text-field
        v-model="order.address"
        label="Адрес"
        :rules="[v => !!v || 'Укажите адрес']"
        :name="isRequired ? 'customer[' + id + '][address]' : ''"
        color="green lighten-3"
      />
      <ChangeMeal />
      <!-- <v-select
        v-model="meal"
        :items="meals"
        label="Тип питания"
      /> -->
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
      <div>
        <BusScheme 
          :object="transport"
          :scheme-id="id"
          @choosen="onChoosen"
        />
        <div v-if="choosenSeat != ''">
          Выбрано место: {{ choosenSeat }}
        </div>
      </div>
      <input 
        type="hidden"
        :name="isRequired ? 'customer[' + id + '][busSeatId]' : ''"
        :value="choosenSeat"
      >
      <div
        v-if="age > 0" 
        class="subheading"
      >
        <span class="grey--text">
          Цена:
        </span> 
        {{ getPrice() }}
      </div>
    </v-flex>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import moment from 'moment'
import BusScheme from './BusScheme'
import ChangeMeal from './ChangeMeal'
export default {
  name: 'OrderFrom',
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
        gender: '',
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
      age: 0,
      priceList: [],
      pensRange: {
        male: 55,
        female: 50,
      },
      manualPens: false,
    }
  },
  computed: {
    ...mapGetters([
      'getChdRange',
      'getPensRange',  
    ]),
    transport: function() {
      return JSON.parse(this.tour.extra).transport[0].obj
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

  },
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },
  mounted() {
    this.priceList = JSON.parse(this.tour.extra).calc.priceList
    this.updatePriceList(this.priceList)
    this.updateChdRange(this.priceList)
    this.updatePensRange(this.priceList)
    console.log(this.priceList)
  },
  updated() {
  },
  methods: {
    ...mapActions([
      'updateChdRange',
      'updatePensRange',
      'updatePriceList',
    ]),
    ...mapGetters([
      'getChdPrice',
      'getPensPrice',
    ]),
    chooseSeat() {
      console.log(this.transport)
    },
    onChoosen(seat) {
      this.choosenSeat = seat
    },
    save(date) {
      this.$refs.menu.save(date)
      this.age = moment().diff(date, 'years')
    },
    getPrice() {
      let defaultPrice = true
      // CHD price
      if (this.isChd) {
        const price = this.$store.getters.getChdPrice(this.age)
        if (this.id == (2 + this.roomId * 3)) return price.addPrice + ' дополнительное размещение ' + price.name
        defaultPrice = false
        return price.standardPrice + ' стандартное размещение ' + price.name
      }
      // Pens price
      if (this.isPens) {
        const price = this.getPensPrice()
        // If additional form (extra in hotel)
        if (this.id == (2 + this.roomId * 3)) return price.addPrice + ' дополнительное размещение ' + price.name
        defaultPrice = false
        return price.standardPrice + ' стандартное размещение ' + price.name
      }
      // Default. ADL price
      if (defaultPrice) {
        const price = this.priceList.find(item => !item.isPens && !item.isChd)
        // If additional form (extra in hotel)
        if (this.id == (2 + this.roomId * 3)) return price.addPrice + ' дополнительное размещение ' + price.name
        return price.standardPrice + ' стандартное размещение ' + price.name
      }
    },
  }
}
</script>

<style>

</style>
