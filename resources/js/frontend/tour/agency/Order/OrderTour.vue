<template>
  <v-container grid-list-xs>
    <v-card>
      <v-card-title
        class="headline green white--text"
        primary-title
      >
        {{ headerText }}.
        Тур: "{{ tour.name }}"
        <v-spacer />
        <v-layout 
          column
          wrap
        >
          <v-select
            v-model="agencyStatus"
            :items="agencyStatuses"
            label="Статус агентства"
            color="green"
            dark
          />
          <v-spacer />
          Статус оператора: {{ statuses[status] }}
        </v-layout>
      </v-card-title>
      <v-card-text>
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
              :action="'/agency/order/' + order.id"
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
                      name="_method"  
                      value="PATCH"
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
                :name="chat != '' ? 'customer[0][chat]' : ''"
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
        Комиссия: {{ getOrderCommission }}
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
// import Total from './Total'
export default {
  name: 'OrderTour',
  components: {
    OrderForm,
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
    profilesRaw: {
      type: String,
      default: () => {
        return ''
      }
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
    }
  },
  computed: {
    ...mapGetters([
      'getOrderPrice',
      'getOrderCommission',
    ]),
    prevChat: function() {
      
      // if (this.profiles[0].chat) {
      //   const result = JSON.parse(this.profiles[0].chat)
      //   return result
      // }
      return ''
    },
    chat: function() {
      let result = {}
      let date = new Date().toISOString().substr(0, 10)
      let message = {
        date,
        sender: 'Агентство',
        text: this.comment,
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
      // return JSON.stringify(this.prevChat)
      return ''
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
  mounted() {
    console.log(this.order)
    this.updateEditMode()
    // this.orderedSeats()
    this.profiles = Object.assign({}, JSON.parse(this.profilesRaw))
    this.agencyStatus = this.profiles[0].orderStatus
    this.status = this.order.status
    this.initialRoomsCount()
    this.updateProfilesData(this.profiles)
    // this.updateMealByDay(this.tour)
  },
  methods: {
    ...mapActions([
      'updateOrderedSeats',
      'updateMealByDay',
      'updateProfiles',
      'updateEditMode',
      'updateProfilesData',
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