<template>
  <v-card 
    class="guide-card"
    :class="{'is-select' : guide.selected}"
    pa-3
  >
    <v-card-title primary-title>
      <div>
        <div class="headline mb-2">
          {{ guide.name }}
          <i 
            class="material-icons ml-2"
            style="color: grey; font-size: 20px;"
            :title="JSON.parse(guide.description).about"
          >
            info
          </i>
        </div>
        <v-divider />
        <v-select
          v-model="guide.daysArray"
          :items="days"
          multiple
          color="green"
          :dark="guide.selected"
          :disabled="guide.selected"
          label="День тура"
          outline
          @change="daysSelected(guide)"
        />
        <v-text-field
          v-model="guide.totalPrice"
          :dark="guide.selected"
          :disabled="guide.selected"
          label="Стоимость"
          mask="######"
          class="mt-3"
          color="green"
        />
        <v-text-field
          v-model="about"
          :dark="guide.selected"
          :disabled="guide.selected"
          label="Описание"
          append-outer-icon="description"
          class="mt-3"
          color="green"
        />
        <!-- <br>
        <span class="grey--text text--darken-1">
          Цена за час: {{ guide.price }}
        </span>
        <br>
        <span class="grey--text text--darken-1">
          Итого: {{ guide.price * guide.duration }}
        </span> -->
      </div>
      <div
        v-show="!guide.selected"
      >
        <v-btn 
          color="green"
          dark
          flat
          @click="showGuideDetails = !showGuideDetails"
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
            expand_{{ showGuideDetails ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div
          v-show="showGuideDetails"  
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
        v-show="!guide.selected"
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
            :key="`${guide.name}-${i}`"
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
        :dark="guide.selected"
        @click="choose(guide)"
      >
        {{ guide.selected ? 'Убрать' : 'Выбрать' }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Guide',
  props: {
    guide: {
      type: Object,
      default() {
        return {}
      }
    },
  },
  data() {
    return {
      about: '',
      showGuideDetails: false,
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
    if (this.guide.options) this.options = this.guide.options
    if (this.guide.events) {
      this.guide.events.forEach((event) => {
        let selectedEvent = this.museums.find(museum => museum.eventId == event.eventId)
        selectedEvent.selected = true
      })
    }
  },
  methods: {
    ...mapActions([
      'updateNewGuideOptions',
    ]),
    choose(guide) {
      // if (guide.duration) {
      //   guide.totalPrice = guide.price * guide.duration
      // } else {
      //   guide.totalPrice = guide.price
      // }
      let selectedEvents = []
      this.museums.forEach((museum) => {
        if (museum.selected) selectedEvents.push(museum)
      })
      let updGuide = {
        ...guide,
        selected: !guide.selected,
        about: this.about,
        events: selectedEvents,
        options: this.options,
      }
      this.updateNewGuideOptions(updGuide)
    },
    daysSelected(guide) {
      guide.day = guide.daysArray.length
    },
  }
}
</script>