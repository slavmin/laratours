<template>
  <v-layout 
    row 
    wrap
  >
    <!-- <v-btn
      color="green"
      @click="log" 
    >
      text
    </v-btn> -->
    <v-flex xs5>
      <v-text-field
        v-model="order.first_name"
        label="Имя"
        :rules="[v => !!v || 'Укажите имя']"
        :name="isRequired ? 'customer[' + id + '][first_name]' : ''"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.last_name"
        label="Фамилия"
        :rules="[v => !!v || 'Укажите фамилию']"
        :name="isRequired ? 'customer[' + id + '][last_name]' : ''"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-select
        v-model="order.gender"
        :items="genders"
        item-text="value"
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
            v-model="order.dob"
            label="Дата рождения"
            :name="isRequired ? 'customer[' + id + '][dob]' : ''"
            prepend-icon="event"
            readonly
            v-on="on"
          />
        </template>
        <v-date-picker
          ref="picker"
          v-model="order.dob"
          color="green"
          locale="ru-ru"
          :max="new Date().toISOString().substr(0, 10)"
          min="1920-01-01"
          @change="save"
        />
      </v-menu>
      <v-checkbox
        label="Квота"
        disabled
      />
    </v-flex>
    <v-flex 
      xs5
      offset-xs2
    >
      <v-text-field
        v-model="order.phone"
        label="Телефон"
        placeholder="+7 (900) 123-11-22"
        :name="isRequired ? 'customer[' + id + '][phone]' : ''"
        color="green lighten-3"
        :rules="[v => !!v || 'Это обязательное поле']"
        maxlength="16"
        mask="+N (NNN) NNN-NN-NN"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.email"
        label="Email"
        :rules="[v => !!v || 'Укажите email']"
        :name="isRequired ? 'customer[' + id + '][email]' : ''"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.country"
        label="Страна"
        :rules="[v => !!v || 'Укажите страну']"
        :name="isRequired ? 'customer[' + id + '][country]' : ''"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.city"
        label="Город"
        :rules="[v => !!v || 'Укажите город']"
        :name="isRequired ? 'customer[' + id + '][city]' : ''"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.address"
        label="Адрес"
        :rules="[v => !!v || 'Укажите адрес']"
        :name="isRequired ? 'customer[' + id + '][address]' : ''"
        color="green lighten-3"
      />
      <v-select
        v-model="order.meal"
        :items="meals"
        label="Тип питания"
      />
      <input 
        v-model="order.meal"
        type="hidden"
        :name="isRequired ? 'customer[' + id + '][meal]' : ''"
      >
      <input 
        v-model="roomId"
        type="hidden"
        :name="isRequired ? 'customer[' + id + '][room]' : ''"
      >
      <div>
        <!-- <BusScheme 
          :object="transport"
          :scheme-id="id"
          @choosen="onChoosen"
        /> -->
        <div v-if="order.busSeatId != ''">
          Место: {{ order.busSeatId }}
        </div>
      </div>
      <input 
        v-model="order.busSeatId"
        type="hidden"
        :name="isRequired ? 'customer[' + id + '][busSeatId]' : ''"
      >
    </v-flex>
  </v-layout>
</template>

<script>
import { mapGetters } from 'vuex'
// import BusScheme from './BusScheme'
export default {
  name: 'OrderFrom',
  components: {
    // BusScheme,
  },
  props: {
    tour: {
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
    },
    // profile: {
    //   type: Object,
    //   default: () => {
    //     return {}
    //   }
    // },
  },
  data() {
    return {
      choosenSeat: [],
      date: null,
      menu: false,
      genders: [
        { id: 1, value: 'Мужской'},
        { id: 2, value: 'Женский'},
        { id: 3, value: 'Ребёнок'},
      ],
      meal: '',
      meals: ['Завтраки', 'Полупансион', 'Полный пансион']
    }
  },
  computed: {
    ...mapGetters(['getProfiles']),
    transport: function() {
      // return JSON.parse(this.tour.extra).transport[0].item
      return ''
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
    order: function() {
      if (this.getProfiles[this.id]) {
        const data = this.getProfiles[this.id]
        return {...this.getProfiles[this.id]}
      }
      return {}
    }
  },
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },
  mounted() {
  },
  methods: {
    chooseSeat() {
      console.log(this.transport)
    },
    onChoosen(seat) {
      this.choosenSeat = seat
    },
    save(date) {
      this.$refs.menu.save(date)
    },
    log() {
      console.log(this.getProfiles[this.profileId])
    }
  }
}
</script>

<style>

</style>
