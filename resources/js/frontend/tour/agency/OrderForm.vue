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
        :name="'customer[' + profileId + '][first_name]'"
        color="green lighten-3"
        required
      />
      <v-text-field
        v-model="order.surname"
        label="Фамилия"
        :rules="[v => !!v || 'Укажите фамилию']"
        :name="'customer[' + profileId + '][last_name]'"
        color="green lighten-3"
        required
      />
      <v-text-field
        v-model="order.passport"
        label="Серия и номер паспорта"
        placeholder="44 00-123 123"
        :rules="[v => !!v || 'Укажите данные']"
        :name="'customer[' + profileId + '][passport]'"
        mask="## ##-### ###"
        color="green lighten-3"
        required
      />
      <v-text-field
        v-model="order.phone"
        label="Телефон. Знаки +, ( ), - добавляются автоматически"
        placeholder="+7"
        :name="'customer[' + profileId + '][phone]'"
        color="green lighten-3"
        :rules="[v => !!v || 'Это обязательное поле']"
        mask="+7 (###) ###-##-##"
        required
      />
      <v-text-field
        label="Email"
        :rules="[v => !!v || 'Укажите email']"
        :name="'customer[' + profileId + '][email]'"
        color="green lighten-3"
        required
      />
    </v-flex>
    <v-flex 
      xs5
      offset-xs2
    >
      <v-text-field
        v-model="order.country"
        label="Страна"
        :rules="[v => !!v || 'Укажите страну']"
        :name="'customer[' + profileId + '][country]'"
        color="green lighten-3"
        required
      />
      <v-text-field
        v-model="order.city"
        label="Город"
        :rules="[v => !!v || 'Укажите город']"
        :name="'customer[' + profileId + '][city]'"
        color="green lighten-3"
        required
      />
      <v-text-field
        v-model="order.address"
        label="Адрес"
        :rules="[v => !!v || 'Укажите адрес']"
        :name="'customer[' + profileId + '][address]'"
        color="green lighten-3"
        required
      />
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
        :name="'customer[' + profileId + '][busSeatId]'"
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
    profileId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      order: {},
      choosenSeat: [],
    }
  },
  computed: {
    transport: function() {
      return JSON.parse(this.tour.extra).transport[0].item
    }
  },
  methods: {
    chooseSeat() {
      console.log(this.transport)
    },
    onChoosen(seat) {
      this.choosenSeat = seat
    }
  }
}
</script>

<style>

</style>
