<template>
  <v-flex xs12>
    <v-layout 
      row 
      wrap
      justify-center
      mt-5
    >
      <h3 class="grey--text">
        Доп. мероприятия: ({{ getTourExtraEvents.length }})
        <v-btn 
          color="#aa282a"
          fab
          small
          dark
          @click="showCustomEvents = !showCustomEvents"
        >
          <v-icon>
            expand_{{ showCustomEvents ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
      </h3>
    </v-layout>
    <v-layout 
      v-show="showCustomEvents"
      row 
      wrap
      justify-center
    >
      <v-flex 
        v-if="showTable"
        xs12
      >
        <table class="custom-events-table">
          <thead>
            <th>
              День тура
            </th>
            <th>
              Услуга
            </th>
            <th>
              Стоимость
            </th>  
            <th>
              Действия
            </th>
          </thead>
          <tbody>
            <tr
              v-for="(event, i) in getTourExtraEvents"
              :key="`${i}-${event.obj.name}`"
            >
              <td>
                {{ event.day }}
              </td>
              <td>
                {{ event.obj.name }}
              </td>
              <td>
                <!-- {{ event.value }} -->
              </td>
              <td>
                <v-btn 
                  color="red"
                  fab
                  small
                  dark
                  @click="removeTourExtraEvent(event.id)"
                >
                  <i class="material-icons">
                    delete
                  </i>
                </v-btn>
              </td>
            </tr>
          </tbody>
        </table>
      </v-flex>
    </v-layout>
    <v-layout 
      v-show="showCustomEvents"
      row 
      wrap
      mt-5
      justify-center
    >
      <v-flex 
        xs3
        mr-5
      >
        <v-select
          v-model="customEvent.day"
          :items="days"
          color="#aa282a"
          label="День тура"
          outline
        />
        <v-autocomplete
          v-model="customEvent.id"
          item-text="name"
          item-value="id"
          color="#aa282a"
          :items="eventsArray"
          label="Мероприятие"
          @input="eventChoosen"
        />
      </v-flex>
      <v-btn 
        fab
        small
        title="Добавить"
        color="#aa282a"
        dark 
        @click="addCustomEvent"
      >
        <i class="material-icons">
          add
        </i>
      </v-btn>
    </v-layout>
  </v-flex>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'ExtraEvents',
  data() {
    return {
      showCustomEvents: false,
      name: '',
      value: 0,
      customEvent: {
        id: NaN,
        day: 1,
        name: '',
        value: 0,
      },
      correction: 0,
      commission: 0,
    }
  },
  computed: {
    ...mapGetters([
      'getTour',
      'getActualExtraEvents',
      'getTourExtraEvents',
    ]),
    showTable: function() {
      // return this.getTourExtraEvents.length == 0 ? false : true
      return true
    },
    days: function() {
      let result = []
      for (let i = 1; i <= this.getTour.options.days; i++) {
        result.push(i)
      } 
      return result
    },
    eventsArray: function() {
      let result = []
      this.getActualExtraEvents.forEach((extraEvent, id) => {
        result.push({
          id,
          museum: extraEvent.museum,
          obj: extraEvent.obj,
          name: `${extraEvent.museum.name}. ${extraEvent.obj.name}`,
        })
      })
      return result
    }
  },
  mounted() {
    console.log(this.getTourExtraEvents)
  },
  methods: {
    ...mapActions([
      'updateTourExtraEvents',
      'removeTourExtraEvent',
    ]),
    addCustomEvent() {
      const result = {
        id: Math.random(100, 5000),
        day: this.customEvent.day,
        commission: 0,
        commissionPrice: 0,
        correction: 0,
        correctedPrice: 0,
        museum: this.customEvent.musem,
        obj: this.customEvent.obj,
      }
      if (this.customEvent.id || this.customEvent.id == 0) {
        this.updateTourExtraEvents(result)
      }
    },
    eventChoosen() {
      const eventData = this.eventsArray.find((event) => {
        return event.id == this.customEvent.id
      })
      this.customEvent.musem = eventData.museum
      this.customEvent.obj = eventData.obj
      console.log(this.customEvent)
    }
  }
}
</script>

<style lang="scss" scoped>
.custom-events-table {
  margin: 0 auto;
  td,
  th {
    border: 1px solid gray;
    padding: 16px;
    font-size: 24px;
  }
  td {
    background-color: #FFAB16;
    color: white;
  }
}
</style>