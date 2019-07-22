<template>
  <v-flex>
    <transition>
      <div v-if="showTransportSelect">
        <ChooseTransport />
      </div>
      <!-- Transport Selected -->
      <!-- /Transport Selected -->
      <!-- Museum Select -->
      
      <!-- /Museum Select -->
      <!-- Museum Selected -->
      <div v-if="dayIsOver">
        <div>
          <h2 class="text-xs-center display-2">
            Музеи:
          </h2>
          <div
            v-for="event in daySummary.events"
            :key="event.museum.id" 
            class="text-xs-center display-1"
          >
            {{ event.museum.name }}.
            {{ event.item.name }}
            <!-- <v-btn 
              outline 
              fab
              small 
              color="red"
              @click="removeEvent(event)"
            >
              <v-icon>remove</v-icon>
            </v-btn> -->
            <p class="text-xs-center display-1">
              Длительность: {{ JSON.parse(event.item.extra).duration }}ч.
            </p>
          </div>
          <v-layout 
            row 
            wrap
            justify-content-center
          >
            <v-btn 
              v-if="transportDuration"
              dark 
              color="green"
              @click="submitMuseum"
            >
              OK
            </v-btn>
          </v-layout>
        </div>  
      </div>
      <!-- /Museum Selected -->
      <div v-if="showDaySummary">
        <table class="summary">
          <thead>
            <th>
              Услуга
            </th>
            <th>
              Стоимость
            </th>
            <th>
              Наценка, %
            </th>
            <th>
              Итого
            </th>
          </thead>
          <tbody>
            <tr>
              <td colspan="4">
                Транспорт
              </td>
            </tr>
            <tr>
              <td>
                {{ daySummary.transport.company.name }}:
                {{ daySummary.transport.item.name }}
              </td>
              <td>
                {{ daySummary.price.transport }}
              </td>
              <td>
                <v-text-field
                  v-model="transportCorrection"
                  name="correction"
                />
              </td>
              <td>
                <v-text-field
                  v-model="transportCorrected"
                  name="corrected"
                />
              </td>
            </tr>
            <tr>
              <td colspan="4">
                Экскурсии
              </td>
            </tr>
            <tr 
              v-for="event in daySummary.events"
              :key="event.item.id"
            >
              <td>
                {{ event.museum.name }}:
                <br>
                {{ event.item.name }}
              </td>
              <td>
                {{ event.item.price }}
              </td>
              <td>
                <v-text-field
                  name="correction"
                />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </transition>
  </v-flex>
</template>

<script>
import ChooseTransport from './ChooseTransport'
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'DayConstructor',
  components: {
    ChooseTransport,
  },
  props: {
    showDayConstructor: {
      type: Boolean,
      default: false
    },
    actualTransports: {
      type: Array,
      default: function() {
        return []
      }
    },
    actualMuseum: {
      type: Array,
      default: function() {
        return []
      }
    },
    allCities: {
      type: Array,
      default: function() {
        return []
      }
    },
    tour: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  data() {
    return {
      daysFilled: 0,
      transport: {},
      showTransportSelect: true,
      transportSelected: false,
      transportDuration: 0,
      showMuseumSelect: false,
      selectedMuseums: [],
      museumDuration: 0,
      showDaySummary: false,
      transportCorrection: 0,
    };
  },
  computed: {
    ...mapActions(['allTransports']),
    currentDay: function() {
      return this.daysFilled + 1
    },
    daySummary: function() {
      return { 
        transport: this.transport,
        price: {
          transport: this.transportPrice
        },
        events: this.selectedMuseums,
        museumDuration: this.museumDuration
      }
    },
    transportPrice: function() {
      let price = JSON.parse(this.transport.item.extra).prices[0]
      return price.value * this.transportDuration
    },
    dayIsOver: function() {
      return this.museumDuration >= 8 ? true : false
    },
    transportCorrected: function() {
      return this.daySummary.price.transport + this.daySummary.price.transport * this.transportCorrection / 100
    }
  },
  methods: {
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
    chooseMuseum(museum, item) {
      this.selectedMuseums.push({
        'museum': museum,
        'item': item
      })
      this.museumDuration += parseInt(JSON.parse(item.extra).duration)
      if (this.museumDuration >= 8) {
        this.showMuseumSelect = false
      }
    },
    removeEvent(event) {
      console.log(this.daySummary)
    },
    submitMuseum() {
      console.log(this.daySummary)
      this.showMuseumSelect = false
      this.museumDuration = 0
      this.showDaySummary = true
    },
    transportAdded() {
      console.log('transport added')
    }
  }
};
</script>

<style lang="scss" scoped>
.infobox {
  position: fixed;
  top: 300px;
  right: 10px;
  width: 200px;
  color: grey;
  font-size: 16px;
}
.summary {
  margin: 0 auto;
  td,
  th {
    border: 1px solid gray;
    padding: 16px;
    font-size: 24px;
  }
}
</style>
