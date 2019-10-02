<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
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
              <Guide 
                :guide="guide"
              />
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
import Guide from './Guide'
export default {

  name: 'ChooseGuide',
  components: {
    Guide,
  },
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
      // if (guide.duration) {
      //   guide.totalPrice = guide.price * guide.duration
      // } else {
      //   guide.totalPrice = guide.price
      // }
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
      this.updateConstructorCurrentStage('Show attendant')
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
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
