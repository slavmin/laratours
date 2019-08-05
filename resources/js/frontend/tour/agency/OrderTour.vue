<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
      lazy
    >
      <template v-slot:activator="{ on }">
        <v-btn
          color="green"
          dark
          small
          flat
          outline
          v-on="on"
        >
          Заказать
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="headline green white--text"
          primary-title
        >
          Заказ тура: {{ tour.name }}
        </v-card-title>

        <v-card-text>
          <form 
            method="POST"
            action="/order/store"
          >
            <v-layout 
              row 
              wrap
            >
              <v-flex xs12>
                <v-text-field
                  v-model="order.name"
                  label="Имя"
                  :rules="[v => !!v || 'Укажите имя']"
                  name="customer[0][first_name]"
                  color="green lighten-3"
                  required
                />
                <v-text-field
                  v-model="order.surname"
                  label="Фамилия"
                  :rules="[v => !!v || 'Укажите фамилию']"
                  name="customer[0][last_name]"
                  color="green lighten-3"
                  required
                />
                <v-text-field
                  v-model="order.phone"
                  label="Телефон. Знаки +, ( ), - добавляются автоматически"
                  placeholder="+7"
                  name="customer[0][phone]"
                  color="green lighten-3"
                  :rules="[v => !!v || 'Это обязательное поле']"
                  outline
                  mask="+7 (###) ###-##-##"
                  required
                />
                <v-text-field
                  label="Email"
                  :rules="[v => !!v || 'Укажите email']"
                  name="customer[0][email]"
                  color="green lighten-3"
                  required
                />
                <div>
                  <BusScheme 
                    :object="transport"
                    @choosen="onChoosen"
                  />
                </div>
                <div v-if="choosenSeat != ''">
                  Выбрано место: {{ choosenSeat }}
                </div>
              </v-flex>

              <!-- Passport -->

              <!-- Phone number -->

              <!-- email -->
            </v-layout>
            <input 
              type="hidden"
              name="_token"  
              :value="token"
            >
            <input 
              type="hidden"
              name="tour_id"
              :value="tour.id"
            >
            <input 
              type="hidden"
              name="operator_id"
              :value="tour.team_id"
            >
            <v-btn 
              color="green"
              type="submit"
              dark
            >
              Заказать
            </v-btn>
          </form>
        </v-card-text>

        <v-divider />

        <v-card-actions>
          <v-spacer />
          <v-btn
            color="green"
            flat
            @click="close"
          >
            Закрыть
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import BusScheme from './BusScheme'
import { mapActions } from 'vuex';
export default {
  name: 'OrderTour',
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
    token: {
      type: String,
      default: ''
    },
  },
  data () {
    return {
      dialog: false,
      order: {
        name: '',
      },
      choosenSeat: '',
    }
  },
  computed: {
    transport: function() {
      return JSON.parse(this.tour.description).transport[0].item
    }
  },
  mounted() {
  },
  methods: {
    close() {
      this.dialog = false
      this.order = {}
    },
    chooseSeat() {
      console.log(this.transport)
    },
    onChoosen(seat) {
      this.choosenSeat = seat
    }
  }
}
</script>