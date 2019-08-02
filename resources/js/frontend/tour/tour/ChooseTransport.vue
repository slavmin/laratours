<template>
  <div>
    <v-layout
      row
      wrap
    >
      <!-- Choose transport -->
      <v-flex v-if="chooseTransport">
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
              color=""
            >
              <v-card 
                color="green lighten-5"
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
                      Мест: {{ item.qnt }}
                    </div>
                  </div>
                </v-card-title>
                <v-divider />
                <v-card-actions>
                  <v-btn 
                    flat
                    @click="choose(transport, item)"
                  >
                    Выбрать
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-layout>
      </v-flex>
      <!-- /Choose transport -->
      <!-- Set transport options -->
      <v-flex v-if="transportSelected">
        <v-layout 
          row 
          wrap
          justify-center
        >
          <v-flex xs6>
            <h2 class="text-xs-center display-2">
              Транспорт:
            </h2>
            <div class="text-xs-center display-1">
              Компания: {{ choosenTransport.company.name }}.
              {{ choosenTransport.item.name }}.
              <v-btn 
                outline 
                fab
                small 
                color="red"
                @click="remove"
              >
                <v-icon>remove</v-icon>
              </v-btn>
            </div>
            <p class="text-xs-center display-1">
              Мест: {{ choosenTransport.item.qnt }}
            </p>
            <v-divider />
            <v-layout 
              row 
              wrap
              justify-center
            >
              <v-flex xs6>
                <v-tabs
                  v-model="active"
                  slider-color="yellow"
                >
                  <v-tab
                    v-for="type in priceTypes"
                    :key="type"
                    ripple
                  >
                    {{ type }}
                  </v-tab>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        <v-input
                          class="text-xs-center display-1"
                        >
                          {{ JSON.parse(choosenTransport.item.extra).prices[0].value }} руб./час
                        </v-input>
                        <v-text-field
                          v-model="duration"
                          label="Количество часов"
                          name="time"
                          append-outer-icon="watch"
                          color="green lighten-3"
                          mask="##"
                          autofocus
                          outline
                          required
                        />
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        <v-input
                          v-model="currentPrice"
                          class="text-xs-center display-1"
                        >
                          {{ JSON.parse(choosenTransport.item.extra).prices[1].value }} руб./км
                        </v-input>
                        <v-text-field
                          v-model="distance"
                          label="Количество км"
                          name="distance"
                          append-outer-icon="shutter_speed"
                          color="green lighten-3"
                          mask="####"
                          autofocus
                          outline
                          required
                        />
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        <v-text-field
                          v-model="customPrice"
                          label="Общая стоимость"
                          name="customPrice"
                          append-outer-icon="attach_money"
                          color="green lighten-3"
                          mask="########"
                          autofocus
                          outline
                          required
                        />
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                </v-tabs>
              </v-flex>
            </v-layout>
          </v-flex>
        </v-layout>
        <v-layout 
          row 
          wrap
          justify-content-center
        >
          <v-flex xs3>
            <v-text-field
              v-if="(duration || distance) && active != 2"
              v-model="transportPrice"
              label="Стоимость:"
              name="transportPrice"
              append-outer-icon="attach_money"
              color="green lighten-3"
              outline
              disabled
              required
            />
            <v-text-field
              v-model="description"
              label="Описание"
              append-outer-icon="description"
              class="mt-3"
              color="green"
            />
            <v-layout 
              row 
              wrap
              justify-center
            >
              <!-- <v-flex xs12>
                <v-btn 
                  flat 
                  small 
                  color="green"
                >
                  Забронировать место второму водителю
                </v-btn>
              </v-flex> -->
            </v-layout>
            <v-layout 
              row 
              wrap
              justify-content-center
            >
              <v-btn 
                v-if="duration || distance || customPrice"
                dark 
                color="green"
                @click="submit"
              >
                OK
              </v-btn>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-flex>
      <!-- /Set transport options -->
      <!-- Add more transport? -->
      <v-flex v-if="anotherOne">
        <h2 class="text-xs-center display-2">
          Добавить ещё транспорт?
        </h2>
        <v-layout 
          row 
          wrap
          justify-content-center
        >
          <v-btn 
            dark 
            color="green"
            @click="addMore"
          >
            Да
          </v-btn>
          <v-btn 
            dark 
            color="green"
            @click="end"
          >
            Нет
          </v-btn>
        </v-layout>
      </v-flex>
      <!-- /Add more transport? -->
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'ChooseTransport',
  data() {
    return {
      chooseTransport: true,
      transportSelected: false,
      anotherOne: false,
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
    transportPrice: function() {
      if (this.active === 0) {
        return JSON.parse(this.choosenTransport.item.extra).prices[0].value * this.duration
      }
      if (this.active === 1) {
        return JSON.parse(this.choosenTransport.item.extra).prices[1].value * this.distance
      }
      return this.customPrice
    },
  },
  updated() {
    this.customPrice
  },
  created() {
    this.updateActualTransport()
    console.log(this.getActualTransport)
  },
  methods: {
    ...mapActions([
      'fetchCities',
      'fetchTransport',
      'updateActualTransport',
      'updateTourTransport',
      'updateConstructorCurrentStage',
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
      this.choosenTransport.company = transport
      this.choosenTransport.item = item
      this.chooseTransport = false
      this.transportSelected = true
    },
    remove() {
      this.transport = {}
      this.transportDuration = NaN
      this.description = ''
      this.transportPrice = NaN
      this.transportSelected = false
      this.chooseTransport = true
    },
    submit() {
      this.updateTourTransport({
        ...this.choosenTransport,
        totalDuration: this.transportDuration,
        totalPrice: this.transportPrice,
        description: this.description,
      })
      this.transportSelected = false
      this.anotherOne = true
    },
    addMore() {
      this.anotherOne = false
      this.transportSelected = false
      this.chooseTransport = true
      this.transportDuration = NaN
      this.duration = NaN
      this.distance = NaN
      this.description = ''
    },
    end() {
      this.updateConstructorCurrentStage('Transport is set')
    },
    next() {
      const active = parseInt(this.active)
        this.active = (active < 2 ? active + 1 : 0)
    }
  },
};
</script>

<style lang="css" scoped>
</style>
