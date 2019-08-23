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
        {{ headerText }} №{{ order.id }}.
        <v-spacer />
        <v-select
          v-model="status"
          :items="statusesFormatted"
          item-value="id"
          item-text="text"
          label="Статус"
          solo
        />
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
                          <div>{{ c == 1 || c == 2 ? 'Основное место ' + c : 'Дополнительное место' }}</div>
                        </template>
                        <v-card>
                          <v-card-text>
                            <EditForm
                              :order="order"
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
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <div v-if="prevChat != {}">
                <h3 class="title grey--text text-xs-center">
                  Комментарии к заявке
                </h3>
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
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import EditForm from './EditForm'
export default {
  name: 'EditOrder',
  components: {
    EditForm,
  },
  props: {
    order: {
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
      default: 'Создать'
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
      tab: null,
      comment: '',
      profiles: {},
      status: 2,
    }
  },
  computed: {
    roomsCount: function() {
      let result = 1
      for (let key in this.profiles) {
        if ((result - 1) !== parseInt(this.profiles[key].room)) {
          result += 1
        }
      }
      return result
    },
    prevChat: function() {
      if (this.profiles[0].chat) {
        const result = JSON.parse(this.profiles[0].chat)
        return result
      }
      return ''
    },
    chat: function() {
      let result = {}
      let date = new Date().toISOString().substr(0, 10)
      let message = {
        date,
        sender: 'Оператор',
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
  mounted() {
    // this.orderedSeats()
    this.profiles = Object.assign({}, JSON.parse(this.profilesRaw))
    this.updateProfiles(this.profiles)
    this.status = this.order.status
  },
  updated() {
  },
  methods: {
    ...mapActions([
      'updateOrderedSeats',
      'updateProfiles',
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