<template>
  <v-card 
    :id="'transport-' + transport.id + '-card-' + item.id"
    class="transport-card"
    :class="{'is-select' : item.selected}"
    pa-3
  >
    <v-card-title primary-title>
      <div>
        <div class="headline mb-2">
          {{ item.name }}
          <i 
            class="material-icons ml-2"
            style="color: grey; font-size: 20px;"
            :title="item.description"
          >
            info
          </i>
        </div>
        <v-divider />
        <v-select
          v-model="item.daysArray"
          :items="days"
          multiple
          color="#aa282a"
          :dark="item.selected"
          :disabled="item.selected"
          label="День тура"
          outline
          @change="daysSelected(item)"
        />
        <div>
          <v-layout
            row
            justify-content-between
            align-center
            wrap
            mb-3
          >
            <v-flex xs6>
              <span class="grey--text text--darken-1 body-2">
                {{ JSON.parse(item.extra).prices[0].name }}: 
              </span>
              <p 
                style="display: inline-block;"
              >
                {{ JSON.parse(item.extra).prices[0].value }}
              </p>
            </v-flex>
            <v-flex xs6>
              <v-text-field
                v-model="item.duration.hours"
                label="Часов"
                :disabled="item.selected"
                @input="calculateTotal(item, 'hours')"
              />
            </v-flex>
          </v-layout>
          <v-layout
            row
            justify-content-between
            align-center
            wrap
            mb-3
          >
            <v-flex xs6>
              <span class="grey--text text--darken-1 body-2">
                {{ JSON.parse(item.extra).prices[1].name }}: 
              </span>
              <p 
                style="display: inline-block;"
              >
                {{ JSON.parse(item.extra).prices[1].value }}
              </p>
            </v-flex>
            <v-flex xs6>
              <v-text-field
                v-model="item.duration.kilometers"
                :disabled="item.selected"
                label="Км"
                @input="calculateTotal(item, 'kilometers')"
              />
            </v-flex>
          </v-layout>
        </div>
        <div>
          <v-layout
            row
            justify-content-between
            align-center
            wrap
            mb-3
          >
            <v-flex xs6>
              <span class="grey--text text--darken-1 body-2">
                Вручную: 
              </span>
            </v-flex>
            <v-flex xs6>
              <v-text-field
                v-model="item.manualPrice"
                :disabled="item.selected"
                @input="calculateTotal(item, 'manual')"
              />
            </v-flex>
          </v-layout>
        </div>
        <v-layout
          row
          justify-content-between
          align-center
          wrap
          mb-3
        >
          <v-flex class="body-2">
            Итого: {{ item.price }}
          </v-flex>
        </v-layout>
        <br>
        <div
          v-for="(grade, i) in JSON.parse(item.extra).grade"
          :key="i"
          row
          justify-center
          wrap
          my-1
        >
          <span class="grey--text text--darken-1">
            {{ grade }}
          </span>
        </div>
        <div class="mt-2">
          Мест: {{ JSON.parse(item.extra).scheme.totalPassengersCount }}
        </div>
      </div>
      <div
        v-show="!item.selected"
      >
        <v-btn 
          color="#aa282a"
          dark
          flat
          @click="showDriverDetails = !showDriverDetails"
        >
          Водители: {{ driversCount }}
          <v-icon right>
            expand_{{ showDriverDetails ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <div
          v-show="showDriverDetails"  
        >
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
    </v-card-title>
    <v-divider />
    <v-card-actions>
      <v-btn 
        flat
        @click="choose(transport, item)"
      >
        {{ item.selected ? 'Убрать' : 'Выбрать' }}
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Transport',
  components: {
  },
  props: {
    transport: {
      type: Object,
      default: () => {
        return {}
      }
    },
    item: {
      type: Object,
      default: () => {
        return {}
      }
    },
    days: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  data() {
    return {
      showDriverDetails: false,
      driversCount: 1,
      drivers: [{hotel: false, isHotelSngl: true, meal: false,}],
    }
  },
  computed: {
    ...mapGetters([
      'getActualTransport',
      'getTour',
    ]),
  },
  mounted() {
    if (this.item.drivers) {
      this.drivers = this.item.drivers
      this.driversCount = this.item.drivers.length
    }
  },
  methods: {
    ...mapActions([
      'updateNewTransportOptions',
    ]),
    choose(transport, item) {
      let updData = {
        'company': transport,
        'item': {
          ...item,
          selected: !item.selected,
        },
        'drivers': this.drivers,
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
  }
}
</script>