<template>
  <div>
    <v-layout
      row
      wrap
    >
      <v-flex>
        <h2 class="text-xs-center grey--text">
          Выберите сопровождающего:
        </h2>
        <v-layout 
          row 
          wrap
          align-center
          mb-5
        >
          <v-flex xs12>
            <div class="text-xs-center display-2">
              <!-- {{ getCityName(guide.city_id) }} -->
            </div>
          </v-flex>
          <v-layout
            row
            wrap
            justify-center
          >
            <v-flex
              v-for="attendant in getActualAttendant"
              :key="attendant.id"
              xs3
              lg2
              ma-2
            >
              <v-card 
                class="attendant-card"
                :class="{'is-select' : attendant.selected}"
                pa-3
              >
                <v-card-title primary-title>
                  <div>
                    <div class="headline mb-2">
                      {{ attendant.name }}
                      <i 
                        class="material-icons ml-2"
                        style="color: grey; font-size: 20px;"
                        :title="JSON.parse(attendant.description).about"
                      >
                        info
                      </i>
                    </div>
                    <v-divider />
                    <!-- <v-select
                      v-model="attendant.day"
                      :items="days"
                      :dark="attendant.selected"
                      :disabled="attendant.selected"
                      label="Количество дней"
                      outline
                    /> -->
                    <v-text-field
                      v-model="attendant.duration"
                      :dark="attendant.selected"
                      :disabled="attendant.selected"
                      label="Количество часов"
                      mask="####"
                      class="mt-3"
                      color="green"
                    />
                    <v-text-field
                      v-model="attendant.about"
                      :dark="attendant.selected"
                      :disabled="attendant.selected"
                      label="Описание"
                      append-outer-icon="description"
                      class="mt-3"
                      color="green"
                    />
                    <br>
                    <span class="grey--text text--darken-1">
                      Цена: {{ attendant.price }}
                    </span>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn 
                    flat
                    :dark="attendant.selected"
                    @click="choose(attendant)"
                  >
                    {{ attendant.selected ? 'Убрать' : 'Выбрать' }}
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
export default {

  name: 'ChooseAttendant',

  data() {
    return {
      about: '',
      duration: NaN,
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'getActualAttendant',
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
    this.updateActualAttendant()
  },
  methods: {
    ...mapActions([
      'updateActualAttendant',
      'updateNewAttendantOptions',
      'updateTourAttendant',
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
    choose(attendant) {
      if (attendant.duration) {
        attendant.totalPrice = attendant.price * attendant.duration
      } else {
        attendant.totalPrice = attendant.price
      }
      let updAttendant = {
        ...attendant,
        selected: !attendant.selected,
      }
      this.updateNewAttendantOptions(updAttendant)
    },
    done() {
      this.updateTourAttendant()
      this.end()
    },
    end() {
      this.updateConstructorCurrentStage('Show services')
      console.log(this.getTour)
    },
  }
};
</script>

<style lang="css" scoped>
.attendant-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
</style>
