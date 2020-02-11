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
              <Attendant 
                :attendant="attendant"
              />
            </v-flex>
          </v-layout>
        </v-layout>
      </v-flex>
      <v-btn 
        dark
        fab
        class="done-btn"
        color="#aa282a"
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
import Attendant from './Attendant'
export default {

  name: 'ChooseAttendant',
  components: {
    Attendant,
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
