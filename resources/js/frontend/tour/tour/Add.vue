<template>
  <v-layout 
    row 
    justify-center
  >
    <v-dialog 
      v-model="dialog" 
      fullscreen 
      hide-overlay 
      transition="dialog-bottom-transition"
    >
      <template v-slot:activator="{ on }">
        <v-btn 
          color="green" 
          dark 
          v-on="on"
        >
          Создать тур          
        </v-btn>
      </template>
      <v-card>
        <v-toolbar 
          dark 
          color="green"
        >
          <v-btn 
            icon 
            dark 
            @click="close"
          >
            <v-icon>
              close
            </v-icon>
          </v-btn>
          <v-toolbar-title>
            Новый тур
          </v-toolbar-title>
        </v-toolbar>
        <v-divider />
        <v-container fluid>
          <v-layout 
            row 
            wrap
            justify-center
          >
            <v-flex xs6>
              <v-select
                v-model="choosenCities"
                :items="allCities"
                label="Тур по городам:"
                item-text="name"
                item-value="id"
                :rules="[v => !!v || 'Это обязательное поле']"
                append-outer-icon="map"
                color="green lighten-3"
                multiple
                required
              />
              <v-divider />
            </v-flex>
            <v-flex xs12>
              <transition name="fade">
                <div v-if="showTransports">
                  <v-layout 
                    v-for="transport in actualTransports"
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
                        <i 
                          class="material-icons"
                          style="font-size: 12px;"
                        >
                          phone
                        </i>
                        {{ transport.description }}
                      </div>
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
                          <v-card-actions>
                            <v-btn 
                              flat
                              :disabled="transportFull"
                              @click="chooseTransport(transport.id, item.id)"
                            >
                              Выбрать
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-flex>
                    </v-layout>
                  </v-layout>
                </div>
              </transition>
              <v-btn 
                dark 
                color="green"
                @click="log"
              >
                заложить
              </v-btn>
            </v-flex>
          </v-layout>
        </v-container>    
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'TourAdd',

  data() {
    return {
      dialog: false,
      choosenCities: [],
      choosenTransport: [],
      transportCount: 2,
    };
  },
  computed: {
    ...mapGetters(['allCities', 'allTransports']),
    showTransports: function() {
      if (this.choosenCities.length === 0) {
        return false
      } 
      return true
    },
    actualTransports: function() {
      let result = []
      this.allTransports.map((item) => {
          if (this.choosenCities.indexOf(item.city_id) !== -1) {
            result.push(item)
          }
        }
      )
      return result
    },
    tour: function() {
      return {
        transport: this.choosenTransport
      }
    },
    transportFull: function() {
      return this.choosenTransport.length == this.transportCount
    }
  },
  created() {
    this.fetchCities()
    this.fetchTransport()
  },
  methods: {
    ...mapActions([
      'fetchCities',
      'fetchTransport'
    ]),
    log() {
      console.log(this.tour)
    },
    close() {
      this.dialog = false
      this.choosenCities = []
    },
    getRandomId() {
      return Math.floor(Math.random() * (10 - 200)) + 200;
    },
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
    chooseTransport(transportId, itemId) {
      let company = {}
      this.allTransports.map((transport) => {
        if (transport.id == transportId) {
          company = {
            id: transport.id,
            name: transport.name
          }
        }
      })
      this.choosenTransport.push(company) 
    }
  }
};
</script>

<style lang="css" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
  transform: scale(1);
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: scale(0.1)
}
</style>
