<template>
  <v-container grid-list-xs>
    <v-card>
      <v-card-title
        style="background-color:#66a5ae;"
        class="headline white--text"
        primary-title
      >
        {{ headerText }}.
        Тур: "{{ tour.name }}"
        <v-spacer />
        <v-layout 
          column
          wrap
        >
          <!-- Статус агентства: {{ agencyStatus }} -->
          <v-spacer />
          <v-select
            v-model="status"
            :items="statusesFormatted"
            hint="Статус оператора"
            persistent-hint
            item-value="id"
            item-text="text"
            solo
          />
        </v-layout>
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
              :action="'/operator/order/' + order.id"
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
                          <div 
                            class="title"
                            style="color: #aa282a;" 
                          >
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
                      name="_method"  
                      value="PATCH"
                    >
                    <input 
                      type="hidden"
                      name="tour_id"
                      :value="order.tour_id"
                    >
                    <input 
                      type="hidden"
                      name="operator_id"
                      :value="order.team_id"
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
                      type="hidden"
                      name="total_paid"
                      :value="parseInt(order.total_paid) + parseInt(paid)"
                    >
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <div
                v-if="profiles[0]"
              >
                <div
                  v-for="(message, i) in prevChat"
                  :key="i"
                >
                  <span class="sender body-2">
                    {{ message.sender }}:
                  </span>
                  <span class="text body-1">
                    {{ message.text }}
                  </span>
                  <br>
                  <span class="date grey--text">
                    {{ message.date }}
                  </span>
                </div>
              </div>
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
              <!-- Agency status -->
              <input
                :value="agencyStatus"
                type="hidden"
                name="customer[0][orderStatus]"
              >
              <!-- Operator status -->
              <input
                v-model="status"
                type="hidden"
                name="status"
              >
            </form>
          </v-tabs-items>
        </v-tabs>
      </v-card-text>
      <v-divider />
      <div class="subheading text-xs-right mr-3">
        Цена заказа: {{ parseInt(getOrderPrice) }}
        <br>
        Оплачено ранее: {{ order.total_paid }}
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
            label="Оплата"
            width="200"
          />
        </v-flex>
      </v-layout>
      <div class="subheading text-xs-right mr-3">
        Остаток: {{ getOrderPrice - order.total_paid - paid }}
      </div>
      <v-divider />
      <v-card-actions>
        <v-spacer />
        <v-btn 
          color="#aa282a"
          type="submit"
          dark
          form="form"
        >
          Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
    <!-- <Total /> -->
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import OrderForm from './OrderForm'
import OrderContacts from '../includes/OrderContacts'
import moment from 'moment'
// import Total from './Total'
export default {
  name: 'OrderTour',
  components: {
    OrderForm,
    OrderContacts,
    // Total,
  },
  props: {
    order: {
      type: Object,
      default: () => {
        return {}
      }
    },
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
    // Order profiles
    profilesRaw: {
      type: String,
      default: () => {
        return ''
      }
    },
    // Tour profiles for bus-scheme and free seats
    tourProfilesRaw: {
      type: String,
      default() {
        return ''
      },
    },
    token: {
      type: String,
      default: ''
    },
    headerText: {
      type: String,
      default: 'Редактировать'
    },
    statuses: {
      type: Array,
      default: () => {
        return []
      }
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
      agencyStatuses: ['Принят', 'Отменён'],
      agencyStatus: '',
      status: 2,
      profiles: {},
      recipient: 'Оператор',
    }
  },
  computed: {
    ...mapGetters([
      'getOrderPrice',
      'getOrderCommission',
      'getOrderContacts',
    ]),
    prevChat: function() {
      console.log(this.profiles)
      if (this.profiles[0]) {
        const result = JSON.parse(this.profiles[0].chat)
        for (let key in result) {
          if (result[key].sender != this.recipient) {
            result[key].isReaded = true
          }
        }
        return result
      }
      return ''
    },
    chat: function() {
      let result = {}
      let date = moment().locale('ru').format('lll')
      let message = {
        date,
        sender: 'Оператор',
        text: this.comment,
        isReaded: false,
      }
      let length = 0
      for (let key in this.prevChat) {
        length += 1
      }
      result = {
        ...this.prevChat
      }
      result[length] = message
      if (this.comment != '') {
        return JSON.stringify(result)
      }
      return JSON.stringify(this.prevChat)
    },
    statusesFormatted: function() {
      let result = []
      this.statuses.forEach((status, index) => result.push({
        id: index,
        text: this.statuses[index]
      }))
      return result
    },
  },
  created() {
    // this.initialRoomsCount()
  },
  mounted() {
    this.updateEditMode()
    this.orderedSeats()
    this.profiles = Object.assign({}, JSON.parse(this.profilesRaw))
    console.log(this.profiles)
    this.agencyStatus = this.profiles[0].orderStatus
    this.status = this.order.status
    this.initialRoomsCount()
    this.updateMealByDay(this.tour)
    this.updateExtraEvents(this.tour)
    this.updateProfilesData(this.profiles)
    const contacts = {
      name: this.profiles[0].contactsName,
      email: this.profiles[0].email,
      phone: this.profiles[0].phone,
    }
    this.updateOrderContacts(contacts)
  },
  methods: {
    ...mapActions([
      'updateOrderedSeats',
      'updateMealByDay',
      'updateProfiles',
      'updateEditMode',
      'updateProfilesData',
      'updateSeatsInCurrentOrder',
      'updateOrderContacts',
      'updateExtraEvents',
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
      JSON.parse(this.tourProfilesRaw).map((profile) => {
        let content = Object.assign({}, profile.content)
        for (let key in content) {
          result.push(content[key].busSeatId)
        }
      })
      // Fill ordered seats in tour, exclude seats ordered in this order.
      let seatsOrderedInCurrentOrder = []
      JSON.parse(this.profilesRaw).map((profile) => {
        seatsOrderedInCurrentOrder.push(profile.busSeatId)
        this.updateSeatsInCurrentOrder(profile.busSeatId)
      })
      this.updateOrderedSeats(_.difference(result, seatsOrderedInCurrentOrder))
      // Fill ordered in this order seats with id's.
      // seatsOrderedInCurrentOrder = []
      // for (let key in JSON.parse(this.profilesRaw)) {
      //   seatsOrderedInCurrentOrder.push({
      //     profileId: key,
      //     orderedBusSeatId: JSON.parse(this.profilesRaw)[key],
      //   })
      // }
      // console.log(seatsOrderedInCurrentOrder)
    },
    initialRoomsCount() {
      let result = 1
      for (let key in this.profiles) {
        if ((result - 1) !== parseInt(this.profiles[key].room)) {
          result += 1
        }
      }
      this.roomsCount = result
    }
  }
}
</script>