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
              v-if="showTypes"
              xs6
            >
              <v-form
                ref="tourTypeForm"
                v-model="tourTypeFormValid"
                lazy-validation
              >
                <v-select
                  v-model="tourType"
                  :items="tourTypes"
                  label="Тип тура:"
                  item-text="name"
                  item-value="id"
                  :rules="[v => !!v || 'Выберите тип']"
                  append-outer-icon="find_in_page"
                  color="green lighten-3"
                  required
                />
                <v-text-field
                  v-model="tourName"
                  label="Название тура"
                  name="name"
                  :rules="nameRules"
                  append-outer-icon="title"
                  color="green lighten-3"
                  outline
                  required
                />
                <v-select
                  v-model="choosenCities"
                  :items="allCities"
                  label="Тур по городам:"
                  item-text="name"
                  item-value="id"
                  :rules="[v => v.length != 0 || 'Выберите тип']"
                  append-outer-icon="location_city"
                  color="green lighten-3"
                  multiple
                  required
                />
                <v-divider />
                <v-layout 
                  row 
                  wrap
                  justify-content-between
                >
                  <v-flex xs3>
                    <v-menu
                      v-model="showDateStart"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateStart"
                          label="Дата начала"
                          :rules="[v => !!v || 'Выберите дату']"
                          prepend-icon="event"
                          readonly
                          required
                          v-on="on"
                        />
                      </template>
                      <v-date-picker 
                        v-model="dateStart" 
                        color="green"
                        locale="ru-ru"
                        @input="showDateStart = false"
                      />
                    </v-menu>
                  </v-flex>
                  <v-flex xs3>
                    <v-menu
                      v-model="showDateEnd"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="dateEnd"
                          label="Дата окончания"
                          :rules="[v => !!v || 'Выберите дату']"
                          prepend-icon="event"
                          readonly
                          required
                          v-on="on"
                        />
                      </template>
                      <v-date-picker 
                        v-model="dateEnd" 
                        color="green"
                        locale="ru-ru"
                        :min="dateStart"
                        @input="showDateEnd = false"
                      />
                    </v-menu>
                  </v-flex>
                  <v-flex xs2>
                    <v-text-field
                      v-model="days"
                      label="Дней"
                      name="days"
                      disabled
                      color="green lighten-3"
                    />
                  </v-flex>
                  <v-flex xs2>
                    <v-text-field
                      v-model="nights"
                      label="Ночей"
                      name="nights"
                      disabled
                      color="green lighten-3"
                    />
                  </v-flex>
                </v-layout>
                <v-layout 
                  row 
                  wrap
                  justify-content-start
                >
                  <v-flex xs3>
                    <v-select
                      v-model="tourGrade"
                      :items="tourGrades"
                      name="grade"
                      label="Класс:"
                      item-text="name"
                      item-value="id"
                      :rules="[v => v.length != 0 || 'Выберите класс']"
                      prepend-icon="grade"
                      color="green lighten-3"
                      multiple
                      required
                    />
                  </v-flex>
                  <v-flex 
                    xs6
                    offset-xs1
                  >
                    <v-select
                      v-model="tourLanguages"
                      :items="availableLanguages"
                      name="languages"
                      label="Язык:"
                      item-text="name"
                      item-value="id"
                      :rules="[v => v.length != 0 || 'Выберите язык']"
                      prepend-icon="language"
                      color="green lighten-3"
                      multiple
                      required
                    />
                  </v-flex>
                </v-layout>
                <v-layout 
                  row 
                  wrap
                  justify-content-end
                >
                  <v-btn
                    :disabled="!tourTypeFormValid"
                    color="green"
                    class="white--text"
                    @click="submitType"
                  >
                    Далее
                  </v-btn>
                </v-layout>
              </v-form>
            </v-flex>
            <DayConstructor 
              :all-cities="allCities"
              :actual-transports="actualTransports"
              :actual-museum="actualMuseum"
              :show-day-constructor="showDayConstructor"
              :tour="tour"
              @log="onLog"
            />
          </v-layout>
          <!-- <v-btn 
            dark 
            color="green"
            @click="log"
          >
            log
          </v-btn> -->
        </v-container>    
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import DayConstructor from './DayConstructor'
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'TourAdd',
  components: {
    DayConstructor,
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
    days: function() {
      return (new Date(this.dateEnd) - new Date(this.dateStart)) / 864e5
    },
    nights: function() {
      return this.days != 0 ? this.days - 1 : 0
    },
    showTypes: function() {
      return this.firstSlide
    },
    showDayConstructor: function() {
      return !this.firstSlide
    },
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
    actualMuseum: function() {
      let result = []
      this.allTourOptions.museum_options.map((item) => {
          if (this.choosenCities.indexOf(item.city_id) !== -1) {
            result.push(item)
          }
        }
      )
      return result
    },
    transportFull: function() {
      return this.choosenTransport.length == this.transportCount
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
      console.log(this.actualMuseum)
    },
    onLog: function() {
      console.log('hello from DayConstructor')
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
