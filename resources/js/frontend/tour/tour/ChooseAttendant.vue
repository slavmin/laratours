<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
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
                    <v-text-field
                      v-model="attendant.totalPrice"
                      :dark="attendant.selected"
                      :disabled="attendant.selected"
                      label="Стоимость"
                      mask="######"
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
                    <!-- <br>
                    <span class="grey--text text--darken-1">
                      Цена за час: {{ attendant.price }}
                    </span>
                    <br>
                    <span class="grey--text text--darken-1">
                      Итого: {{ attendant.price * attendant.duration }}
                    </span> -->
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
    // this.updateActualAttendant()
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
      // if (attendant.duration) {
      //   attendant.totalPrice = attendant.price * attendant.duration
      // } else {
      //   attendant.totalPrice = attendant.price
      // }
      let updAttendant = {
        ...attendant,
        selected: !attendant.selected,
      }
      this.updateNewAttendantOptions(updAttendant)
    },
    done() {
      this.$emit('scrollme')
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
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
