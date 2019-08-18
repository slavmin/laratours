<template>
  <div>
    <v-layout
      row
      wrap
    >
      <v-flex>
        <h2 class="text-xs-center grey--text">
          Выберите гида:
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
              v-for="guide in getActualGuide"
              :key="guide.id"
              xs3
              lg2
              ma-2
            >
              <v-card 
                class="guide-card"
                :class="{'is-select' : guide.selected}"
                pa-3
              >
                <v-card-title primary-title>
                  <div>
                    <div class="headline mb-2">
                      {{ guide.name }}
                      <i 
                        class="material-icons ml-2"
                        style="color: grey; font-size: 20px;"
                        :title="JSON.parse(guide.description).about"
                      >
                        info
                      </i>
                    </div>
                    <v-divider />
                    <!-- <v-select
                      v-model="guide.day"
                      :items="days"
                      :dark="guide.selected"
                      :disabled="guide.selected"
                      label="Количество дней"
                      outline
                    /> -->
                    <v-text-field
                      v-model="guide.duration"
                      :dark="guide.selected"
                      :disabled="guide.selected"
                      label="Количество часов"
                      mask="####"
                      class="mt-3"
                      color="green"
                    />
                    <v-text-field
                      v-model="about"
                      :dark="guide.selected"
                      :disabled="guide.selected"
                      label="Описание"
                      append-outer-icon="description"
                      class="mt-3"
                      color="green"
                    />
                    <br>
                    <span class="grey--text text--darken-1">
                      Цена за час: {{ guide.price }}
                    </span>
                    <br>
                    <span class="grey--text text--darken-1">
                      Итого: {{ guide.price * guide.duration }}
                    </span>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn 
                    flat
                    :dark="guide.selected"
                    @click="choose(guide)"
                  >
                    {{ guide.selected ? 'Убрать' : 'Выбрать' }}
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

  name: 'ChooseGuide',

  data() {
    return {
      about: '',
      duration: NaN,
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'getActualGuide',
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
    // this.updateActualGuide()
  },
  methods: {
    ...mapActions([
      'updateActualGuide',
      'updateNewGuideOptions',
      'updateTourGuide',
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
    choose(guide) {
      if (guide.duration) {
        guide.totalPrice = guide.price * guide.duration
      } else {
        guide.totalPrice = guide.price
      }
      let updGuide = {
        ...guide,
        selected: !guide.selected,
        'about': this.about,
      }
      this.updateNewGuideOptions(updGuide)
    },
    done() {
      this.$emit('scrollme')
      this.updateTourGuide()
      this.end()
    },
    end() {
      this.updateConstructorCurrentStage('Show services')
    },
  }
};
</script>

<style lang="css" scoped>
.guide-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
</style>
