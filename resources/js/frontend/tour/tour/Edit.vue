<template>
  <v-dialog 
    v-model="dialog" 
    fullscreen 
    hide-overlay 
    lazy
    transition="dialog-bottom-transition"
    @input="fillStore"
  >
    <template v-slot:activator="{ on }">
      <v-btn 
        color="green" 
        small
        fab
        dark 
        title="Редактировать тур"
        v-on="on"
      >
        <i class="material-icons">
          edit
        </i>      
      </v-btn>
    </template>
    <v-card>
      <v-toolbar 
        id="toolbar"
        dark 
        color="#66a5ae"
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
          Редактирование
        </v-toolbar-title>
        <v-spacer />
        <v-toolbar-items>
          <v-btn 
            v-for="item in nav" 
            :key="item.name"
            dark 
            flat
            @click="changeConstructorStage(item.stage)"
          >
            {{ item.name }}
          </v-btn>
        </v-toolbar-items>
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
            <ChooseTransport 
              @scrollme="scrollToTop"
            />
          </v-flex>
          <v-flex 
            v-if="showChooseMuseum"
            xs12
          >
            <ChooseMuseum 
              @scrollme="scrollToTop"
            />
          </v-flex>
          <v-flex 
            v-if="showChooseHotel"
            xs12
          >
            <ChooseHotel 
              @scrollme="scrollToTop"
            />
          </v-flex>
          <v-flex
            v-if="showChooseMeal"
            xs12
          >
            <ChooseMeal 
              @scrollme="scrollToTop"
            />
          </v-flex>
          <v-flex 
            v-if="showChooseGuide"
            xs12
          >
            <ChooseGuide 
              @scrollme="scrollToTop"
            />
          </v-flex>
          <v-flex 
            v-if="showServices"
            xs12
          >
            <Services 
              @scrollme="scrollToTop"
            />
          </v-flex>
          <v-flex 
            v-if="showChooseAttendant"
            xs12
          >
            <ChooseAttendant 
              @scrollme="scrollToTop"
            />
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
      </v-container>    
    </v-card>
  </v-dialog>
</template>

<script>
import Options from './Options'
import ChooseTransport from './ChooseTransport'
import ChooseMuseum from './ChooseMuseum'
import ChooseHotel from './ChooseHotel'
import ChooseMeal from './ChooseMeal'
import ChooseGuide from './ChooseGuide'
import ChooseAttendant from './ChooseAttendant'
import Services from './Services'
import Summary from './Summary'
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'TourEdit',
  components: {
    Options,
    ChooseTransport,
    ChooseMuseum,
    ChooseHotel,
    ChooseMeal,
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
    },
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {
      tourTypeFormValid: false,
      tourName: '',
      nameRules: [
        v => !!v || 'Введите название тура',
      ],
      nav: [
        { 
          name: 'Настройки', 
          stage: 'Initial stage', 
          active: false,
          disabled: false,
        },
        { 
          name: 'Транспорт', 
          stage: 'Options are set', 
          active: false,
          disabled: false, 
        },
        { 
          name: 'Экскурсии', 
          stage: 'Transport is set', 
          active: false,
          disabled: false, 
        },
        { 
          name: 'Проживание', 
          stage: 'Museum is set', 
          active: false,
          disabled: false, 
        },
        { 
          name: 'Питание', 
          stage: 'Hotel is set', 
          active: false,
          disabled: false, 
        },
        { 
          name: 'Гиды', 
          stage: 'Meal is set', 
          active: false,
          disabled: false, 
        },
        { 
          name: 'Сопровождающие', 
          stage: 'Show attendant', 
          active: false,
          disabled: false, 
        },
        { 
          name: 'Допы', 
          stage: 'Show services', 
          active: false,
          disabled: false, 
        }
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
      'getConstructorCurrentStage',
      'allState',
      'getTour',
      
    ]),
    showOptions: function() {
      // return false
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
    showChooseMeal: function() {
      return this.getConstructorCurrentStage == 'Hotel is set' ? true : false
    },
    showChooseGuide: function() {
      return this.getConstructorCurrentStage == 'Meal is set' ? true : false
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
  updated() {
  },
  methods: {
    ...mapActions([
      'updateEditTour',
      'fetchCities',
      'fetchTransport',
      'fetchAllTourOptions',
      'updateConstructorCurrentStage',
      'updateActualTransport',
      'updateActualMuseum',
      'updateActualHotel',
      'updateActualMeal',
      'updateActualGuide',
      'updateActualAttendant',
      'clearStore'
    ]),
    log() {
      console.log(this.allTourOptions)
    },
    close() {
      this.dialog = false
      this.updateConstructorCurrentStage('Initial stage')
      this.clearStore()
      // this.reset()
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
    changeConstructorStage(stage) {
      this.updateConstructorCurrentStage(stage)
    },
    scrollToTop() {
      document.getElementById('toolbar').scrollIntoView()
    },
    fillStore() {
      this.updateEditTour(this.tour)
      this.updateActualTransport()
      this.updateActualMuseum()
      this.updateActualHotel()
      this.updateActualMeal()
      this.updateActualGuide()
      this.updateActualAttendant()
      console.log(this.getTour)
    },
  }
};
</script>

<style lang="scss" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
  transform: scale(1);
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
  transform: scale(0.1)
}
.navigator {
  text-align: left;
  color: white;
  font-size: 14px;
  ul {
    display: flex;
    flex-direction: row;
    list-style: none;
    li {
      cursor: pointer;
    }
    li:hover {
      color: white;
    }
  }
}
</style>
