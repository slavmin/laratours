<template>
  <div>
    <v-layout
      row
      wrap
    >
      <v-flex>
        <h2 class="text-xs-center grey--text">
          Выберите размещение:
        </h2>
        <v-layout 
          v-for="hotel in getActualHotel"
          :key="hotel.id"
          row 
          wrap
          align-center
          mb-5
        >
          <v-flex xs12>
            <div class="text-xs-center display-2">
              {{ hotel.name }}
            </div>
            <div class="text-xs-center subheading">
              {{ getCityName(hotel.city_id) }},
              <i 
                class="material-icons"
                style="font-size: 12px;"
              >
                phone
              </i>
              {{ JSON.parse(hotel.extra).contacts.phone }}
            </div>
          </v-flex>
          <v-layout
            row
            wrap
            justify-center
          >
            <v-flex
              v-for="item in hotel.objectables"
              :key="item.id"
              xs3
              lg2
              ma-2
            >
              <v-card 
                class="hotel-card"
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
                      v-model="item.day"
                      :items="days"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="Количество ночей"
                      outline
                    />
                    <!-- <v-text-field
                      v-model="item.roomsCount"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="Количество номеров"
                      mask="###"
                      class="mt-3"
                      color="green"
                    /> -->
                    <v-text-field
                      :id="'about' + item.id"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="Описание"
                      append-outer-icon="description"
                      class="mt-3"
                      color="green"
                    />
                    <v-layout 
                      row 
                      wrap
                      justify-space-between
                    >
                      <span class="grey--text text--darken-1">
                        Обычное размещение:
                      </span>
                      <p 
                        style="display: inline-block;"
                      >
                        {{ JSON.parse(item.extra).priceList.standard }}
                      </p>            
                    </v-layout>
                    <v-layout 
                      row 
                      wrap
                      justify-space-between
                    >
                      <span class="grey--text text--darken-1">
                        Single размещение:
                      </span>
                      <p 
                        style="display: inline-block;"
                      >
                        {{ JSON.parse(item.extra).priceList.single }}
                      </p>            
                    </v-layout>
                    <div v-if="JSON.parse(item.extra).priceList.additionalPrices.length > 0">
                      <p>
                        Доп. места:
                      </p>
                      <v-layout
                        v-for="(price, i) in JSON.parse(item.extra).priceList.additionalPrices"
                        :key="i"
                        row
                        justify-content-between
                        wrap
                      >
                        <span class="grey--text text--darken-1">
                          {{ price[0].name }}: 
                        </span>
                        <p 
                          style="display: inline-block;"
                        >
                          {{ price[0].price }}
                        </p>
                        <br>
                        <span class="grey--text text--darken-1">
                          {{ price[1].name }}: 
                        </span>
                        <p 
                          style="display: inline-block;"
                        >
                          {{ price[1].price }}
                        </p>
                      </v-layout>
                    </div>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn 
                    flat
                    :dark="item.selected"
                    @click="choose(hotel, item)"
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
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { POINT_CONVERSION_COMPRESSED } from 'constants';
export default {

  name: 'ChooseHotel',

  data() {
    return {
      about: '',
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'getActualHotel',
      'getTour'
    ]),
    days: function() {
      let result = []
      for (let i = 1; i <= this.getTour.options.days; i++) {
        result.push(i)
      } 
      return result
    },
  },
  created() {
    // this.updateActualHotel()
  },
  methods: {
    ...mapActions([
      'updateActualHotel',
      'updateNewHotelOptions',
      'updateTourHotel',
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
    choose(hotel, item) {
      if (item.day != 0) {
        item.totalPrice = JSON.parse(item.extra).priceList.standard * item.day
      } else {
        item.totalPrice = JSON.parse(item.extra).priceList.standard
      }
      let updData = {
        'hotel': hotel,
        'item': {
          ...item,
          selected: !item.selected,
          'about': document.getElementById('about' + item.id).value,
        }, 
      }
      this.updateNewHotelOptions(updData)
    },
    done() {
      this.updateTourHotel()
      this.end()
    },
    end() {
      this.updateConstructorCurrentStage('Hotel is set')
    },
  }
};
</script>

<style lang="css" scoped>
.hotel-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
</style>
