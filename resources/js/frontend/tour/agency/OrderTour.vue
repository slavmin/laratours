<template>
  <v-container grid-list-xs>
    <!-- <v-layout 
      row 
      wrap
      justify-center
    > 
      <v-flex xs2>
        <v-select
          v-model="count"
          :items="items"
          label="Туристов"
        />
      </v-flex>
    </v-layout> -->
    <v-card>
      <v-card-title
        class="headline green white--text"
        primary-title
      >
        {{ headerText }}.
        Тур: "{{ tour.name }}"
        <v-spacer />
        <OrderHint />
      </v-card-title>
      <v-card-text>
        <OrderContacts />
        <h2 class="grey--text text-xs-center mt-3">
          Данные туристов:
        </h2>
        <v-tabs
          color="white"
          show-arrows
          grow
        >
          <v-tabs-slider color="grey" />
          <v-tab
            v-for="room in roomsCount"
            :key="room"
            :href="'#tab-' + room"
          >
            <h4 class="grey--text">
              Номер {{ room }}
            </h4>
          </v-tab>
          <v-layout 
            row 
            wrap
            justify-center
          >
            <v-btn 
              fab
              small
              outline
              disabled
              color="grey"
              title="Добавить номер"
              @click="incrementRoomsCount"
            >
              <i class="material-icons">
                add
              </i>
            </v-btn>
            <v-btn 
              v-if="roomsCount > 1"
              fab
              small
              outline
              color="grey"
              title="Убрать номер"
              @click="decrementRoomsCount"
            >
              <i class="material-icons">
                remove
              </i>
            </v-btn>
          </v-layout>
          <v-tabs-items>
            <form 
              id="form"
              method="POST"
              action="/agency/order/store"
            >
              <v-tab-item
                v-for="room in roomsCount"
                :key="room"
                :value="'tab-' + room"
              >
                <v-card flat>
                  <v-card-text>
                    <v-expansion-panel
                      v-model="panel" 
                      expand  
                    >
                      <v-expansion-panel-content
                        v-for="c in 3"
                        :key="c"
                      >
                        <template v-slot:header>
                          <div class="title">
                            {{ c == 1 || c == 2 ? 'Основное место ' + c : 'Дополнительное место' }}
                          </div>
                        </template>
                        <v-card>
                          <v-card-text>
                            <OrderForm
                              :tour="tour"
                              :profile-id="c - 1"
                              :room-id="room - 1"
                            />
                          </v-card-text>
                        </v-card>
                      </v-expansion-panel-content>
                    </v-expansion-panel>
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
                    <input 
                      type="hidden"
                      name="total_price"
                      :value="getOrderPrice"
                    >
                    <input 
                      type="hidden"
                      name="commission"
                      :value="getOrderCommission"
                    >
                    <input 
                      v-model="paid"
                      type="hidden"
                      name="total_paid"
                    >
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <v-textarea
                v-model="comment"
                box
                label="Комментарии"
                hint="Оставьте комментарий оператору"
              />
              <input 
                v-model="chat"
                type="hidden"
                name="customer[0][chat]"
              >
              <input
                value="Принят"
                type="hidden"
                name="customer[0][orderStatus]"
              >
            </form>
          </v-tabs-items>
        </v-tabs>
      </v-card-text>
      <v-divider />
      <div class="subheading text-xs-right mr-3">
        Цена заказа: {{ getOrderPrice }}
        <br>
        Комиссия: {{ parseInt(getOrderCommission) }}
      </div>
      <v-layout 
        row 
        wrap
      >
        <v-spacer />
        <v-flex xs3>
          <v-text-field
            v-model="paid"
            mask="#######"
            label="Оплачено"
            width="200"
          />
        </v-flex>
      </v-layout>
      <div class="subheading text-xs-right mr-3">
        Остаток: {{ getOrderPrice - paid }}
      </div>
      <v-divider />
      <v-card-actions>
        <v-spacer />
        <v-btn 
          color="green"
          type="submit"
          dark
          form="form"
        >
          Заказать
        </v-btn>
      </v-card-actions>
    </v-card>
    <!-- <Total /> -->
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import OrderForm from './OrderForm'
import OrderHint from './OrderHint'
import OrderContacts from '../includes/OrderContacts'
// import Total from './Total'
export default {
  name: 'OrderTour',
  components: {
    OrderForm,
    OrderHint,
    OrderContacts,
    // Total,
  },
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
    profiles: {
      type: String,
      default: () => {
        return {}
      }
    },
    token: {
      type: String,
      default: ''
    },
    headerText: {
      type: String,
      default: 'Создать'
    },
  },
  data () {
    return {
      items: [1, 2, 3, 4],
      choosenSeat: [],
      count: 1,
      panel: [true, false, false],
      roomsCount: 1,
      tab: null,
      comment: '',
      paid: 0,
    }
  },
  computed: {
    ...mapGetters([
      'getOrderPrice',
      'getOrderCommission',
    ]),
    chat: function() {
      if (this.comment != '') {
        let date = new Date().toISOString().substr(0, 10)
        return JSON.stringify({
          0: {
              date,
              sender: 'Агентство',
              text: this.comment,
              isReaded: false,
          },
        })
      }
      return ''
    },
  },
  mounted() {
    this.orderedSeats()
    this.updateMealByDay(this.tour)
  },
  methods: {
    ...mapActions([
      'updateOrderedSeats',
      'updateMealByDay',
    ]),
    close() {
      this.dialog = false
      this.order = {}
    },
    incrementRoomsCount() {
      this.roomsCount += 1
    },
    decrementRoomsCount() {
      if (this.roomsCount > 1) {
        this.roomsCount -= 1
      }
    },
    orderedSeats() {
      let result = []
      JSON.parse(this.profiles).map((profile) => {
        let content = Object.assign({}, profile.content)
        for (let key in content) {
          result.push(content[key].busSeatId)
        }
      })
      this.updateOrderedSeats(result)
    }
  }
}
</script>