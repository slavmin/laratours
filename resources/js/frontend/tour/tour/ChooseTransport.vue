<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
    >
      <!-- Choose transport -->
      <v-flex>
        <h2 class="text-xs-center grey--text">
          Выберите транспорт:
        </h2>
        <v-layout 
          v-for="transport in getActualTransport"
          :key="transport.id"
          row 
          wrap
          align-center
          mb-5
        >
          <v-flex xs12>
            <div class="text-xs-center display-2">
              {{ transport.name }}
            </div>
            <div class="text-xs-center subheading">
              {{ getCityName(transport.city_id) }},
            </div>
            <v-layout 
              row 
              wrap
              mb-2
              justify-center
            >
              <div class="mr-3">
                <i 
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  web
                </i>
                <a 
                  :href="JSON.parse(transport.description).contacts.site"
                  target="_blank"
                >
                  {{ JSON.parse(transport.description).contacts.site }}
                </a>
              </div>
              <div class="mr-3">
                <i 
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  email
                </i>
                <a 
                  :href="'mailto:' + JSON.parse(transport.description).contacts.email"
                >
                  {{ JSON.parse(transport.description).contacts.email }}
                </a>
              </div>
              <div class="mr-5">
                <i 
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  phone
                </i>
                {{ JSON.parse(transport.description).contacts.phone }}
              </div>
              <div class="mr-3">
                <i 
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  person
                </i>
                {{ JSON.parse(transport.description).staff.name }}
              </div>
              <div>
                <i 
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  phone
                </i>
                {{ JSON.parse(transport.description).staff.phone }}
              </div>
            </v-layout>
          </v-flex>
          <v-layout
            row
            wrap
            justify-center
          >
            <v-flex
              v-for="item in transport.objectables"
              :key="item.id"
              xs3
              lg2
              ma-2
            >
              <Transport 
                :transport="transport"
                :item="item"
                :days="days"
              />
            </v-flex>
          </v-layout>
        </v-layout>
      </v-flex>
      <!-- /Choose transport -->
      <v-btn 
        dark
        fab
        class="done-btn"
        color="green"
        @click="done"
      >
        <i class="material-icons">
          arrow_forward
        </i>
      </v-btn>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Transport from './Transport'
export default {
  name: 'ChooseTransport',
  components: {
    Transport,
  },
  props: {
    tourToEdit: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      choosenTransport: {},
      duration: NaN,
      distance: NaN,
      description: '',
      active: null,
      currentPrice: 0,
      customPrice: NaN,
      priceTypes: [
        'Цена за 1 час',
        'за 1 км',
        'Ввести вручную'
      ],
      currentPriceType: '',
      daysArray: [],
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'allTransports',
      'getActualTransport',
      'getTour',
    ]),
    days: function() {
      let result = []
      for (let i = 1; i <= this.getTour.options.days; i++) {
        result.push(i)
      } 
      return result
    },
  },
  methods: {
    ...mapActions([
      'fetchCities',
      'fetchTransport',
      'updateActualTransport',
      'updateTourTransport',
      'updateConstructorCurrentStage',
      'updateNewTransportOptions',
    ]),
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
    end() {
      this.updateConstructorCurrentStage('Transport is set')
    },
    done() {
      this.$emit('scrollme')
      this.updateTourTransport()
      this.end()
    },
  },
};
</script>

<style lang="css" scoped>
.transport-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
