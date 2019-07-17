<template>
  <v-flex xs12>
    <transition>
      <div v-if="showDayConstructor">
        <h1 class="text-xs-center display-3">
          День {{ currentDay }}
        </h1>
        <v-divider />
        <div v-if="showTransportSelect">
          <ChooseTransport 
            :actual-transports="actualTransports"
            @choose="chooseTransport"
          />
        </div>
        <!-- Transport Selected -->
        <div v-if="transportSelected">
          <h2 class="text-xs-center display-2">
            Транспорт:
          </h2>
          <div class="text-xs-center display-1">
            Компания: {{ transport.company.name }}.
            {{ transport.item.name }}.
            <v-btn 
              outline 
              fab
              small 
              color="red"
              @click="removeTransport"
            >
              <v-icon>remove</v-icon>
            </v-btn>
          </div>
          <p class="text-xs-center display-1">
            Мест: {{ transport.item.qnt }}
          </p>
          <p class="text-xs-center display-1">
            Цена за час: {{ JSON.parse(transport.item.extra).prices[0].value }}
          </p>
          <v-layout 
            row 
            wrap
            justify-content-center
          >
            <v-flex xs3>
              <v-text-field
                v-model="transportDuration"
                label="Количество часов"
                name="transportDuration"
                append-outer-icon="watch"
                color="green lighten-3"
                mask="##"
                outline
                required
              />
              <v-text-field
                v-if="transportDuration"
                v-model="transportPrice"
                label="Стоимость:"
                name="transportPrice"
                append-outer-icon="attach_money"
                color="green lighten-3"
                outline
                disabled
                required
              />
              <v-layout 
                row 
                wrap
                justify-content-center
              >
                <v-btn 
                  v-if="transportDuration"
                  dark 
                  color="green"
                  @click="submitTransport"
                >
                  OK
                </v-btn>
              </v-layout>
            </v-flex>
          </v-layout>
        </div>
        <!-- /Transport Selected -->
        <!-- Museum Select -->
        <div v-if="showMuseumSelect">
          <h2 class="text-xs-center grey--text">
            Музеи:
          </h2>
          <v-layout
            row
            wrap
          >
            <v-layout 
              v-for="museum in actualMuseum"
              :key="museum.id"
              row 
              wrap
              align-center
              mb-5
              style="postition: relative;"
            >
              <v-flex xs12>
                <div class="text-xs-center display-2">
                  {{ museum.name }}
                </div>
                <div class="text-xs-center subheading">
                  {{ getCityName(museum.city_id) }},
                  <i 
                    class="material-icons"
                    style="font-size: 12px;"
                  >
                    phone
                  </i>
                  {{ JSON.parse(museum.description).contacts.phone }}
                </div>
              </v-flex>
              <div class="infobox">
                Общая продолжительность экскурсий: 
                {{ museumDuration }}ч.
              </div>
              <v-layout
                row
                wrap
                justify-center
              >
                <v-flex
                  v-for="item in museum.objectables"
                  :key="item.id"
                  xs3
                  lg2
                  ma-2
                >
                  <v-card 
                    color="green lighten-5"
                    pa-3
                  >
                    <v-card-title primary-title>
                      <div>
                        <div class="headline mb-2">
                          {{ item.description }}
                          <i 
                            class="material-icons ml-2"
                            style="color: grey; font-size: 20px;"
                            :title="item.description"
                          >
                            info
                          </i>
                        </div>
                        <v-divider />
                        <div
                          v-for="(price, i) in JSON.parse(item.extra).prices"
                          :key="i"
                          row
                          justify-content-between
                          wrap
                        >
                          <span class="grey--text text--darken-1">
                            {{ price.name }}: 
                          </span>
                          <p 
                            style="display: inline-block;"
                          >
                            {{ price.value }}
                          </p>
                        </div>
                        <br>
                        <span class="grey--text text--darken-1">
                          Цена: {{ item.price }}
                        </span>
                        <div class="mt-2">
                          Длительность: {{ JSON.parse(item.extra).duration }}ч.
                        </div>
                      </div>
                    </v-card-title>
                    <v-card-actions>
                      <v-btn 
                        flat
                        :disabled="dayIsOver"
                        @click="chooseMuseum(museum, item)"
                      >
                        Выбрать
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-flex>
              </v-layout>
            </v-layout>
          </v-layout>
        </div>
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
              <!-- <p class="text-xs-center display-1">
                Цена за час: {{ JSON.parse(transport.item.extra).prices[0].value }}
              </p> -->
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
    chooseTransport(transport, item) {
      this.transport = {
        company: transport,
        item: item
      }
      this.showTransportSelect = false
      this.transportSelected = true
    },
    removeTransport() {
      this.transport = {}
      this.transportDuration = 0
      this.showTransportSelect = true
      this.transportSelected = false
    },
    submitTransport() {
      console.log(this.daySummary)
      this.showTransportSelect = false
      this.transportSelected = false
      this.showMuseumSelect = true
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
