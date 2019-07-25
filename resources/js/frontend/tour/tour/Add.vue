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
            {{ tourName == '' ? 'Новый тур' : tourName }}
          </v-toolbar-title>
        </v-toolbar>
        <v-container fluid>
          <v-layout 
            row 
            wrap
            justify-center
          >
            <v-flex
              v-if="showOptions"
              xs6 
            >
              <Options />
            </v-flex>
            <v-flex 
              v-if="showChooseTransport"
              xs12
            >
              <ChooseTransport />
            </v-flex>
            <v-flex 
              v-if="showChooseMuseum"
              xs12
            >
              <ChooseMuseum />
            </v-flex>
            <v-flex 
              v-if="showChooseHotel"
              xs12
            >
              <ChooseHotel />
            </v-flex>
            <v-flex 
              v-if="showChooseGuide"
              xs12
            >
              <ChooseGuide />
            </v-flex>
            <v-flex 
              v-if="showServices"
              xs12
            >
              <Services />
            </v-flex>
            <v-flex 
              v-if="showChooseAttendant"
              xs12
            >
              <ChooseAttendant />
            </v-flex>
            <v-flex 
              v-if="showSummary"
              xs12
            >
              <Summary 
                :token="token"
              />
            </v-flex>
          </v-layout>
          <v-btn 
            dark 
            color="green"
            @click="log"
          >
            log
          </v-btn>
        </v-container>    
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import Options from './Options'
import ChooseTransport from './ChooseTransport'
import ChooseMuseum from './ChooseMuseum'
import ChooseHotel from './ChooseHotel'
import ChooseGuide from './ChooseGuide'
import ChooseAttendant from './ChooseAttendant'
import Services from './Services'
import Summary from './Summary'
// import DayConstructor from './DayConstructor'
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'TourAdd',
  components: {
    Options,
    ChooseTransport,
    ChooseMuseum,
    ChooseHotel,
    ChooseGuide,
    ChooseAttendant,
    Services,
    Summary,
    // DayConstructor,
  },
  props: {
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      tourTypeFormValid: false,
      tourName: '',
      nameRules: [
        v => !!v || 'Введите название тура',
      ],
      dialog: false,
      firstSlide: true,
      showDateStart: false,
      showDateEnd: false,
      secondSlide: false,
      tourType: '',
      tourGrades: [
        { id: 1, name: 'Стандарт'},
        { id: 2, name: 'VIP'}
      ],
      tourGrade: [],
      availableLanguages: [
        { id: 1, name: 'Русский'},
        { id: 2, name: 'Английский'},
        { id: 3, name: 'Немецкий'},
        { id: 4, name: 'Французский'},
        { id: 5, name: 'Китайский'},
        { id: 6, name: 'Испанский'},
        { id: 7, name: 'Итальянский'},
        { id: 8, name: 'Финский'}
      ],
      tourLanguages: [],
      dateStart: new Date().toISOString().substr(0, 10),
      dateEnd: new Date().toISOString().substr(0, 10),
      choosenCities: [],
      choosenTransport: [],
      transportCount: 2,
    };
  },
  computed: {
    ...mapGetters([
      'allCities', 
      'allTransports',
      'allTourOptions',
      'getConstructorCurrentStage'
    ]),
    tour: function() {
      return {
        type: this.tourType,
        name: this.tourName,
        dateStart: this.dateStart,
        dateEnd: this.dateEnd,
        days: this.days,
        nights: this.nights,
        grade: this.tourGrade,
        languages: this.tourLanguages,
        transport: this.choosenTransport,
      }
    },
    tourTypes: function() {
      let types = []
      for (let key in this.allTourOptions.tour_type_options) {
        types.push({
          id: key,
          name: this.allTourOptions.tour_type_options[key]
        })
      }
      return types
    },
    showOptions: function() {
      return this.getConstructorCurrentStage === 'Initial stage' ? true : false
    },
    showChooseTransport: function() {
      return this.getConstructorCurrentStage == 'Options are set' ? true : false
    },
    showChooseMuseum: function() {
      return this.getConstructorCurrentStage == 'Transport is set' ? true : false
    },
    showChooseHotel: function() {
      return this.getConstructorCurrentStage == 'Museum is set' ? true : false
    },
    showChooseGuide: function() {
      return this.getConstructorCurrentStage == 'Hotel is set' ? true : false
    },
    showChooseAttendant: function() {
      return this.getConstructorCurrentStage == 'Show attendant' ? true : false
    },
    showServices: function() {
      return this.getConstructorCurrentStage == 'Show services' ? true : false
    },
    showSummary: function() {
      return this.getConstructorCurrentStage == 'Show summary' ? true : false
    },
    showTransports: function() {
      if (this.choosenCities.length === 0) {
        return false
      } 
      return true
    },
  },
  created() {
    this.fetchCities()
    this.fetchTransport()
    this.fetchAllTourOptions()
  },
  methods: {
    ...mapActions([
      'fetchCities',
      'fetchTransport',
      'fetchAllTourOptions',
    ]),
    log() {
      console.log(this.allTourOptions)
    },
    close() {
      this.dialog = false
      this.reset()
    },
    submitType() {
      if (this.$refs.tourTypeForm.validate()) {
        this.snackbar = true
        this.firstSlide = false
      }
    },
    reset () {
      this.tourTypeFormValid = false
      this.tourName = ''
      this.firstSlide = true
      this.showDateStart = false
      this.showDateEnd = false
      this.secondSlide = false
      this.tourType = ''
      this.tourGrade = []
      this.tourLanguages = []
      this.dateStart = new Date().toISOString().substr(0, 10)
      this.dateEnd = new Date().toISOString().substr(0, 10)
      this.choosenCities = []
      this.choosenTransport = []
      this.transportCount = 2
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
