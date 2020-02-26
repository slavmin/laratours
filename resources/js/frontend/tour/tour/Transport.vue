<template>
  <v-card
    :id="'transport-' + transport.id + '-card-' + item.id"
    class="transport-card"
    :class="{'is-select' : item.selected}"
    pa-3
    max-width="250px"
    outlined
  >
    <v-card-title>
      {{ item.name }}
      <i
        class="material-icons ml-2"
        style="color: grey; font-size: 20px;"
        :title="item.description"
      >
        info
      </i>
    </v-card-title>
    <v-card-text>
      <v-select
        v-model="item.daysArray"
        :items="daysArray"
        multiple
        color="#aa282a"
        :dark="item.selected"
        :disabled="item.selected"
        label="День тура"
        outline
        @change="daysSelected(item)"
      />
      <!-- <div>
        <v-row mb-3>
          <v-col cols="6">
            <span class="grey--text text--darken-1 body-2">
              {{ item.prices }}:
            </span>
            <p style="display: inline-block;">
              {{ JSON.parse(item.extra).prices[0].value }}
            </p>
          </v-col>
          <v-col cols="6">
            <v-text-field
                v-model="item.duration.hours"
                label="Часов"
                :disabled="item.selected"
                @input="calculateTotal(item, 'hours')"
              />
          </v-col>
        </v-row>
        <v-row
          row
          justify-content-between
          align-center
          wrap
          mb-3
        >
          <v-col cols="6">
            <span class="grey--text text--darken-1 body-2">
              {{ JSON.parse(item.extra).prices[1].name }}:
            </span>
            <p style="display: inline-block;">
              {{ JSON.parse(item.extra).prices[1].value }}
            </p>
          </v-col>
          <v-col cols="6">
            <v-text-field
                v-model="item.duration.kilometers"
                :disabled="item.selected"
                label="Км"
                @input="calculateTotal(item, 'kilometers')"
              />
          </v-col>
        </v-row>
      </div> -->
      <!-- <div>
        <v-row
          row
          justify-content-between
          align-center
          wrap
          mb-3
        >
          <v-col xs6>
            <span class="grey--text text--darken-1 body-2">
              Вручную:
            </span>
          </v-col>
          <v-col xs6>
            <v-text-field
              v-model="item.manualPrice"
              :disabled="item.selected"
              @input="calculateTotal(item, 'manual')"
            />
          </v-col>
        </v-row>
      </div> -->
      <!-- <v-row mb-3>
        <v-col class="body-2">
          Итого: {{ item.price }}
        </v-col>
      </v-row> -->
      <div class="mt-2">
        Мест: {{ JSON.parse(item.extra).scheme.totalPassengersCount }}
      </div>
      <div v-show="!item.selected">
        <v-btn
          color="#aa282a"
          dark
          text
          @click="showDriverDetails = !showDriverDetails"
        >
          Водители: {{ driversCount }}
          <v-icon right>
            expand_{{ showDriverDetails ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div v-show="showDriverDetails">
          <v-btn
            v-show="driversCount != 1"
            color="red"
            small
            fab
            dark
            :disabled="driversCount === 1"
            @click="decrement"
          >
            <v-icon>remove</v-icon>
          </v-btn>
          <v-btn
            color="#aa282a"
            small
            fab
            dark
            @click="increment"
          >
            <v-icon>add</v-icon>
          </v-btn>
          <v-divider />
          <div
            v-for="i in driversCount"
            :key="i"
          >
            <p class="body-2">
              Водитель {{ i }}
            </p>
            <v-switch
              v-model="drivers[i - 1].hotel"
              label="Проживание"
              color="#aa282a"
            />
            <v-checkbox
              v-if="drivers[i - 1].hotel"
              v-model="drivers[i - 1].isHotelSngl"
              label="Сингл"
              color="#aa282a"
            />
            <v-divider />
            <v-switch
              v-model="drivers[i - 1].meal"
              label="Питание"
              color="#aa282a"
            />
            <v-divider />
          </div>
        </div>
      </div>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn
        dark
        color="#aa282a"
        @click="choose(transport, item)"
      >
        {{ item.selected ? 'Убрать' : 'Выбрать' }}
      </v-btn>
    </v-card-actions>
    <v-alert
      :value="showAttention"
      color="blue"
    >
      <strong>Внимание!</strong>
      Выбран один водитель без питания и проживания.
    </v-alert>
  </v-card>
</template>
<script>
export default {
  name: 'Transport',
  components: {},
  props: {
    transport: {
      type: Object,
      default: () => {
        return {}
      },
    },
    item: {
      type: Object,
      default: () => {
        return {}
      },
    },
    days: {
      type: Number,
      default: () => {
        return []
      },
    },
    tourId: {
      type: Number,
      default: () => {
        return []
      },
    },
    tourDate: {
      type: String,
      default: () => {
        return []
      },
    },
  },
  data() {
    return {
      showDriverDetails: false,
      driversCount: 1,
      drivers: [{ hotel: false, isHotelSngl: true, meal: false }],
    }
  },
  computed: {
    daysArray: function() {
      let result = []
      for (let n = 1; n <= this.days; n++) result.push(n)
      return result
    },
    showAttention: function() {
      // If default driver options choosen
      // drivers = [{hotel: false, isHotelSngl: true, meal: false,}]
      if (
        this.item.selected &&
        this.driversCount == 1 &&
        !this.drivers[0].hotel &&
        !this.drivers[0].meal
      ) {
        return true
      }
      return false
    },
  },
  mounted() {
    if (this.item.drivers) {
      this.drivers = this.item.drivers
      this.driversCount = this.item.drivers.length
    }
  },
  methods: {
    choose(transport, item) {
      // On unselect transport set drivers to default
      if (item.selected) {
        this.driversCount = 1
        this.drivers = [{ hotel: false, isHotelSngl: true, meal: false }]
      }
      let updData = {
        company: transport,
        item: {
          ...item,
          selected: !item.selected,
        },
        drivers: this.drivers,
      }
      this.updateNewTransportOptions(updData)
    },
    daysSelected(item) {
      item.day = item.daysArray.length
    },
    calculateTotal(item, flag) {
      item.price = 0
      if (flag === 'hours') {
        item.duration.kilometers = 0
        item.manualPrice = 0
        const cost = JSON.parse(item.extra).prices[0].value
        item.price = item.duration.hours * cost
      }
      if (flag === 'kilometers') {
        item.duration.hours = 0
        item.manualPrice = 0
        const cost = JSON.parse(item.extra).prices[1].value
        item.price = item.duration.kilometers * cost
      }
      if (flag === 'manual') {
        item.duration.kilometers = 0
        item.duration.hours = 0
        item.price = item.manualPrice
      }
    },
    increment() {
      this.driversCount += 1
      this.drivers.push({
        hotel: false,
        isHotelSngl: true,
        meal: false,
      })
    },
    decrement() {
      this.driversCount -= 1
      this.drivers.pop()
    },
    log() {
      console.log('actual: ', this.getActualTransport)
      console.log('tour: ', this.getTour)
    },
  },
}
</script>