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
                          <div>{{ c == 1 || c == 2 ? 'Основное место ' + c : 'Дополнительное место' }}</div>
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
                  </v-card-text>
                </v-card>
              </v-tab-item>
              <v-textarea
                box
                name="'customer[0][comment]'"
                label="Комментарии"
                :value="comment"
                hint="Оставьте комментарий оператору"
              />
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
          Заказать
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>
<script>
import OrderForm from './OrderForm'
import OrderHint from './OrderHint'
export default {
  name: 'OrderTour',
  components: {
    OrderForm,
    OrderHint,
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
    headerText: {
      type: String,
      default: 'Создать'
    }
  },
  data () {
    return {
      items: [1, 2, 3, 4],
      choosenSeat: [],
      count: 1,
      panel: [true, true, true],
      roomsCount: 1,
      tab: null,
      comment: 'Текст комментария',
    }
  },
  mounted() {
    console.log(this.tour)
  },
  methods: {
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
    }
  }
}
</script>