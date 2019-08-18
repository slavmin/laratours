<template>
  <div>
    <v-layout
      row
      wrap
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
            </v-flex>
          </v-layout>
        </v-layout>
        <v-layout 
          row 
          wrap
          justify-end
        >
          <v-flex xs2> 
            <v-btn 
              dark
              color="green"
              @click="done"
            >
              OK
            </v-btn>
          </v-flex>
        </v-layout>
      </v-flex>
      <!-- /Choose transport -->
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'ChooseTransport',
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
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'allTransports',
      'getActualTransport',
      'getTour',
    ]),
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
    choose(transport, item) {
      let updData = {
        'company': transport,
        'item': {
          ...item,
          selected: !item.selected,
        },
      }
      this.updateNewTransportOptions(updData)
    },
    end() {
      this.updateConstructorCurrentStage('Transport is set')
    },
    done() {
      this.$emit('scrollme')
      this.updateTourTransport()
      this.end()
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
        item.duration.hourd = 0
        item.price = item.manualPrice
      }
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
</style>
