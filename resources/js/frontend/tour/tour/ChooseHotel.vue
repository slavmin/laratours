<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
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
                      v-model="item.daysArray"
                      :items="days"
                      multiple
                      color="green"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="Количество ночей"
                      outline
                      @change="daysSelected(item)"
                    />
                    <v-text-field
                      :id="'about' + item.id"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="Описание"
                      append-outer-icon="description"
                      class="mt-3"
                      color="green"
                    />
                    Взрослый
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
                        {{ JSON.parse(item.extra).priceList.adl.std }}
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
                        {{ JSON.parse(item.extra).priceList.adl.sngl }}
                      </p>            
                    </v-layout>
                    <v-layout 
                      row 
                      wrap
                      justify-space-between
                    >
                      <span class="grey--text text--darken-1">
                        Дополнительное:
                      </span>
                      <p 
                        style="display: inline-block;"
                      >
                        {{ JSON.parse(item.extra).priceList.adl.extra }}
                      </p>            
                    </v-layout>
                    Ребёнок до {{ JSON.parse(item.extra).priceList.chd.age }}
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
                        {{ JSON.parse(item.extra).priceList.chd.std }}
                      </p>            
                    </v-layout>
                    <v-layout 
                      row 
                      wrap
                      justify-space-between
                    >
                      <span class="grey--text text--darken-1">
                        Дополнительное:
                      </span>
                      <p 
                        style="display: inline-block;"
                      >
                        {{ JSON.parse(item.extra).priceList.chd.extra }}
                      </p>            
                    </v-layout>
                    Инфант до {{ JSON.parse(item.extra).priceList.inf.age }}
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
                        {{ JSON.parse(item.extra).priceList.inf.isFree
                          ? 'Бесплатно'
                          : JSON.parse(item.extra).priceList.inf.std 
                        }}
                      </p>            
                    </v-layout>
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
      </v-flex>
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
        item.totalPrice = JSON.parse(item.extra).priceList.adl.std * item.day
      } else {
        item.totalPrice = JSON.parse(item.extra).priceList.adl.std
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
      this.$emit('scrollme')
      this.updateTourHotel()
      this.end()
    },
    end() {
      this.updateConstructorCurrentStage('Hotel is set')
    },
    daysSelected(item) {
      item.day = item.daysArray.length
      console.log(item.daysArray)
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
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
