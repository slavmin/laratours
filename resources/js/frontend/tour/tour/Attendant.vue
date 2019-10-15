<template>
  <v-card 
    class="attendant-card"
    :class="{'is-select' : attendant.selected}"
    pa-3
  >
    <v-card-title primary-title>
      <div>
        <div class="headline mb-2">
          {{ attendant.name }}
          <i 
            class="material-icons ml-2"
            style="color: grey; font-size: 20px;"
            :title="JSON.parse(attendant.description).about"
          >
            info
          </i>
        </div>
        <v-divider />
        <v-select
          v-model="attendant.daysArray"
          :items="days"
          multiple
          color="green"
          :dark="attendant.selected"
          :disabled="attendant.selected"
          label="День тура"
          outline
          @change="daysSelected(attendant)"
        />
        <v-text-field
          v-model="attendant.totalPrice"
          :dark="attendant.selected"
          :disabled="attendant.selected"
          label="Стоимость"
          mask="######"
          class="mt-3"
          color="green"
        />
        <v-text-field
          v-model="about"
          :dark="attendant.selected"
          :disabled="attendant.selected"
          label="Описание"
          append-outer-icon="description"
          class="mt-3"
          color="green"
        />
        <!-- <br>
        <span class="grey--text text--darken-1">
          Цена за час: {{ attendant.price }}
        </span>
        <br>
        <span class="grey--text text--darken-1">
          Итого: {{ attendant.price * attendant.duration }}
        </span> -->
      </div>
      <div
        v-show="!attendant.selected"
      >
        <v-btn 
          color="green"
          dark
          flat
          @click="showAttendantDetails = !showAttendantDetails"
        >
          <v-icon
            class="mr-2"
          >
            hotel
          </v-icon>
          <v-icon>
            fastfood
          </v-icon>
          <v-icon right>
            expand_{{ showAttendantDetails ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div
          v-show="showAttendantDetails"  
        >
          <div>
            <v-switch 
              v-model="options.hotel"
              label="Проживание"
              color="green" 
            />
            <v-switch 
              v-model="options.meal"
              label="Питание"
              color="green" 
            />
          </div>
        </div>
      </div>
      <div
        v-show="!attendant.selected"
      >
        <v-btn 
          color="green"
          dark
          flat
          @click="showEvents = !showEvents"
        >
          Экскурсии
          <v-icon right>
            expand_{{ showEvents ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div
          v-show="showEvents"  
        >
          <v-switch 
            v-for="(museum, i) in museums"
            :key="`${attendant.name}-${i}`"
            v-model="museum.selected"
            :label="`День: ${museum.day}. ${museum.museum}: ${museum.event}. Цена: ${museum.price}`"
            color="green" 
          />
        </div>
      </div>
    </v-card-title>
    <v-card-actions>
      <v-btn 
        flat
        :dark="attendant.selected"
        @click="choose(attendant)"
      >
        {{ attendant.selected ? 'Убрать' : 'Выбрать' }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Attendant',
  props: {
    attendant: {
      type: Object,
      default() {
        return {}
      }
    },
  },
  data() {
    return {
      about: '',
      showAttendantDetails: false,
      options: {
        hotel: false,
        meal: false,
      },
      showEvents: false,
    }
  },
  computed: {
    ...mapGetters([
      'getTour',
    ]),
    days: function() {
      let result = []
      for (let i = 1; i <= this.getTour.options.days; i++) {
        result.push(i)
      } 
      return result
    },
    museums() {
      let result = []
      this.getTour.museum.forEach((museum) => {
        let adlPrice = JSON.parse(museum.obj.extra).priceList.find((price) => {
          return price.customerName.includes('Взр')
        })
        result.push({
          museum: museum.museum.name,
          eventId: museum.obj.id,
          event: museum.obj.name,
          museumId: museum.museum.id,
          day: museum.obj.day,
          price: adlPrice.price,
          selected: false,
        })
      })
      return result
    },
  },
  mounted() {
    if (this.attendant.options) this.options = this.attendant.options
    if (this.attendant.events) {
      this.attendant.events.forEach((event) => {
        let selectedEvent = this.museums.find(museum => museum.eventId == event.eventId)
        selectedEvent.selected = true
      })
    }
  },
  methods: {
    ...mapActions([
      'updateNewAttendantOptions',
    ]),
    choose(attendant) {
      // if (attendant.duration) {
      //   attendant.totalPrice = attendant.price * attendant.duration
      // } else {
      //   attendant.totalPrice = attendant.price
      // }
      let selectedEvents = []
      this.museums.forEach((museum) => {
        if (museum.selected) selectedEvents.push(museum)
      })
      let updAttendant = {
        ...attendant,
        selected: !attendant.selected,
        about: this.about,
        events: selectedEvents,
        options: this.options,
      }
      this.updateNewAttendantOptions(updAttendant)
    },
    daysSelected(attendant) {
      attendant.day = attendant.daysArray.length
    },
  }
}
</script>