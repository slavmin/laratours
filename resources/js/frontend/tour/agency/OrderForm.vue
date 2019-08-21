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
        :name="'customer[' + id + '][first_name]'"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.surname"
        label="Фамилия"
        :rules="[v => !!v || 'Укажите фамилию']"
        :name="'customer[' + id + '][last_name]'"
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
        :name="'customer[' + id + '][gender]'"
      >
      <v-text-field
        v-model="order.passport"
        label="Номер документа"
        placeholder="44 00-123 123"
        :rules="[v => !!v || 'Укажите данные']"
        :name="'customer[' + id + '][passport]'"
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
            v-model="date"
            label="Дата рождения"
            :name="'customer[' + id + '][dob]'"
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
        :name="'customer[' + id + '][phone]'"
        color="green lighten-3"
        :rules="[v => !!v || 'Это обязательное поле']"
        maxlength="16"
        mask="+N (NNN) NNN-NN-NN"
        :required="isRequired"
      />
      <v-text-field
        label="Email"
        :rules="[v => !!v || 'Укажите email']"
        :name="'customer[' + id + '][email]'"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.country"
        label="Страна"
        :rules="[v => !!v || 'Укажите страну']"
        :name="'customer[' + id + '][country]'"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-text-field
        v-model="order.city"
        label="Город"
        :rules="[v => !!v || 'Укажите город']"
        :name="'customer[' + id + '][city]'"
        color="green lighten-3"
        :required="isRequired"
      />
      <v-select
        v-model="meal"
        :items="meals"
        label="Тип питания"
      />
      <input 
        v-model="meal"
        type="hidden"
        :name="'customer[' + id + '][meal]'"
      >
      <div>
        <BusScheme 
          :object="transport"
          @choosen="onChoosen"
        />
        <div v-if="choosenSeat != ''">
          Выбрано место: {{ choosenSeat }}
        </div>
      </div>
      <input 
        type="hidden"
        :name="'customer[' + id + '][busSeatId]'"
        :value="choosenSeat"
      >
    </v-flex>
  </v-layout>
</template>

<script>
import BusScheme from './BusScheme'
export default {
  name: 'OrderFrom',
  components: {
    BusScheme,
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
      order: {},
      choosenSeat: [],
      date: null,
      menu: false,
      genders: [
        { id: 1, value: 'Мужской'},
        { id: 2, value: 'Женский'},
        { id: 3, value: 'Ребёнок'},
      ],
      isRequired: true,
      meal: '',
      meals: ['Завтраки', 'Полупансион', 'Полный пансион']
    }
  },
  computed: {
    transport: function() {
      return JSON.parse(this.tour.extra).transport[0].item
    },
    id: function() {
      return this.profileId + (this.roomId * 3)
    },
  },
  watch: {
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    }
  },
  mounted() {
    // console.log(this.profiles)
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
  }
}
</script>

<style>

</style>
