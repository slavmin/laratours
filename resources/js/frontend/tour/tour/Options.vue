<template>
  <v-flex>
    <v-select
      v-model="getTour.constructorType"
      :items="constructorTypes"
      label="Тип конструктора:"
    />
    <v-form
      ref="tourTypeForm"
      v-model="tourTypeFormValid"
      lazy-validation
    >
      <v-select
        v-model="getTour.options.tourType"
        :items="tourTypes"
        label="Тип тура:"
        item-text="name"
        item-value="id"
        :rules="[v => !!v || 'Выберите тип']"
        append-outer-icon="find_in_page"
        color="#aa282a"
        required
      />
      <v-text-field
        v-model="getTour.options.name"
        label="Название тура"
        name="name"
        :rules="nameRules"
        append-outer-icon="title"
        color="#aa282a"
        outline
        required
      />
      <v-autocomplete
        v-model="getTour.options.cities"
        item-text="name"
        item-value="id"
        :items="allCities"
        :rules="[v => v.length != 0 || 'Выберите тип']"
        append-outer-icon="location_city"
        label="Тур по городам:"
        color="#aa282a"
        multiple
        chips
        required
      >
        <template v-slot:selection="data">
          <v-chip
            :selected="data.selected"
            close
            class="chip--select-multi"
            @input="chipRemove(data.item.id)"
          >
            {{ data.item.name }}
          </v-chip>
        </template>
      </v-autocomplete>
      <v-divider />
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
            v-model="datesPrettyString"
            label="Дата начала"
            prepend-icon="event"
            readonly
            v-on="on"
          />
        </template>
        <v-date-picker 
          v-model="startDate" 
          :min="dateToday"
          color="#aa282a"
          locale="ru-ru"
          first-day-of-week="1"
          @input="showDateStart = false"
        />
      </v-menu>
      <!-- Multiple dates vvv -->
      <!-- <v-layout 
        row 
        wrap
      >
        <v-flex>
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
                v-model="datesPrettyString"
                label="Дата начала"
                :rules="[v => !!v || 'Выберите дату']"
                prepend-icon="event"
                readonly
                required
                v-on="on"
              />
            </template>
            <v-date-picker 
              v-model="startDates" 
              :min="dateToday"
              color="#aa282a"
              locale="ru-ru"
              first-day-of-week="1"
              multiple
            />
          </v-menu>
        </v-flex>
      </v-layout> -->
      <!-- Multiple dates ^^^^ -->
      <!-- Multiple times vvv -->
      <!-- <v-layout 
        row 
        wrap
      >
        <v-flex>
          <div class="subheading grey--text">
            Время начала
          </div>
          <v-chip
            v-for="(time, i) in startTimes"
            :key="i"
            close
            @input="removeStartTime(time)"
          >
            <strong>{{ time }}</strong>&nbsp;
          </v-chip>
          <v-layout
            row
            wrap
            justify-center
          >
            <v-flex xs1>
              <v-text-field
                v-model="newStartTime"
                placeholder="12:30"
                @keydown.enter="addStartTime"
              />
            </v-flex>
            <v-flex xs1>
              <v-btn 
                fab 
                dark 
                small 
                color="#aa282a"
                @click="addStartTime"
              >
                <v-icon 
                  dark
                >
                  add
                </v-icon>
              </v-btn>
            </v-flex>
          </v-layout>
        </v-flex>  
      </v-layout> -->
      <!-- <v-divider /> -->
      <!-- Multiple times ^^^^ -->
      <v-layout 
        row 
        wrap
        justify-content-between
      >
        <v-flex xs2>
          <v-text-field
            v-model="getTour.options.days"
            label="Дней"
            :rules="[v => !!v || 'Укажите количество дней']"
            name="days"
            mask="###"
            color="#aa282a"
          />
        </v-flex>
        <v-flex xs2>
          <v-text-field
            v-model="getTour.options.nights"
            label="Ночей"
            :rules="[v => !!v || 'Укажите количество дней']"
            name="nights"
            mask="###"
            color="#aa282a"
            required
          />
        </v-flex>
        <v-flex xs4>
          <v-text-field
            v-model="getTour.qnt"
            label="Количество туристов"
            name="qnt"
            mask="###"
            color="#aa282a"
          />
        </v-flex>
      </v-layout>
      <!-- <v-layout 
        row 
        wrap
        justify-content-between
      >
        <v-flex xs3>
          <v-select
            v-model="getTour.options.tourGrade"
            :items="tourGrades"
            name="grade"
            label="Класс:"
            item-text="name"
            item-value="id"
            :rules="[v => v.length != 0 || 'Выберите класс']"
            prepend-icon="grade"
            color="#aa282a"
            multiple
          />
        </v-flex>
        <v-flex 
          xs6
        >
          <v-select
            v-model="getTour.options.tourLanguages"
            :items="availableLanguages"
            name="languages"
            label="Язык:"
            item-text="name"
            item-value="id"
            :rules="[v => v.length != 0 || 'Выберите язык']"
            prepend-icon="language"
            color="#aa282a"
            multiple
            required
          />
        </v-flex>
      </v-layout> -->
      <v-layout 
        row 
        wrap
        justify-content-end
      >
        <v-btn
          :disabled="!tourTypeFormValid"
          color="#aa282a"
          class="white--text"
          @click="submitType"
        >
          Далее
        </v-btn>
      </v-layout>
    </v-form>
  </v-flex>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import moment from 'moment'
export default {

  name: 'Options',
  props: {
    tourToEdit: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      tourTypeFormValid: false,
      nameRules: [
        v => !!v || 'Введите название тура',
      ],
      tourGrades: [
        { id: 1, name: 'Стандарт'},
        { id: 2, name: 'VIP'}
      ],
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
      showDateStart: false,
      showDateEnd: false,
      dateEnd: new Date().toISOString().substr(0, 10),
      commissionManualMode: false,
      commissionManualValue: 0,
      startDate: '',
      startDates: [],
      startTimes: [],
      newStartTime: '09:00',
      selectedConstructorType: 'Подробный',
      constructorTypes: [
        'Подробный',
        'Тур от партнёра',
      ],
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'allTourOptions',
      'getTour',
      'getTourName',
      'getEditMode',
    ]),
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
    dateToday: function() {
      return moment().format('YYYY-MM-DD')
      // return '2019-09-21'
    },
    datesPrettyString: function() {
      let result = ''
      // this.startDates.forEach((date) => {
      //   result += `${moment(date).format('ll')}, `
      // })
      if (this.startDate != '') {
        result += `${moment(this.startDate).format('ll')}, `
      }
      return result.substring(0, result.length - 2)
    }
  },
  watch: {
    startTimes: function() {
      this.setTourDateTimes()
    },
    startDates: function() {
      this.setTourDateTimes()
    },
    startDate: function() {
      this.setTourDateTimes()
    }
  },
  created() {
    this.fetchAllTourOptions()
  },
  mounted() {
    this.commissionManualMode = this.getTour.calc.commissionManualMode
    this.commissionManualValue = this.getTour.calc.commissionManualValue
    this.updateCurrentCustomerType(1)
    if (this.getEditMode) {
      this.selectedConstructorType = this.getTour.options.constructorType
    }
    if (this.getEditMode && this.getTour.options.dates.length != 0) {
      this.getTour.options.dates.forEach((item) => {
        const date = item.substring(0, 10)
        const time = item.substring(11, 19)
        // if (!this.startDates.includes(date)) {
        //   this.startDates.push(date)
        // }
        // if (!this.startTimes.includes(time)) {
        //   this.startTimes.push(time)
        // }
        this.startDate = date
      })
    }
  },
  methods: {
    ...mapActions([
      'fetchAllTourOptions',
      'updateTourOptions',
      'updateConstructorCurrentStage',
      'updateTourName',
      'updateActualTransport',
      'updateActualMuseum',
      'updateActualHotel',
      'updateActualMeal',
      'updateActualGuide',
      'updateActualAttendant',
      'updateTourTotalPrice',  
      'updateTourCorrectedPrice',
      'updateCorrectedPriceValues',
      'updateCommissionPriceValues',
      'updateTourCommissionPrice',
      'updateCurrentCustomerType',
      'updateTourMuseum',
      'updateTourHotel',
      'updateTourGuide',
      'updateTourAttendant',
      'updateTourStaff',
      'updateTourFreeAdls',
      'updateTourTransport',
      'updateCustomPriceWithNewPassangersCount',
    ]),
    submitType() {
      if (this.$refs.tourTypeForm.validate()) {
        if (this.getTour.constructorType == 'Тур от партнёра') {
          console.log('tour partner')
          this.updateConstructorCurrentStage('Partner tour')
        } 
        else {
          this.snackbar = true
          this.updateActualTransport()
          this.updateActualMuseum()
          this.updateActualHotel()
          this.updateActualMeal()
          this.updateActualGuide()
          this.updateActualAttendant()
          this.updateConstructorCurrentStage('Options are set')
        }
        //if (this.getEditMode) {
        //  this.updateTourTransport()
        //  this.updateTourMuseum()
        //  this.updateTourHotel()
        //  this.updateTourGuide()
        //  this.updateTourAttendant()
        //  this.updateTourStaff()
        //  this.updateTourFreeAdls()
        //  this.updateCustomPriceWithNewPassangersCount()
        //  this.updateTourTotalPrice()
        //  this.updateCorrectedPriceValues()
        //  this.updateTourCorrectedPrice()
        //  if (!this.commissionManualMode) {
        //    this.updateCommissionPriceValues()
        //    this.updateTourCommissionPrice()
        //  } else {
        //    this.updateManualCommissionPriceValues(parseFloat(this.commissionManualValue).toFixed(2))
        //  }
        //}
      }
    },
    chipRemove(cityId) {
      console.log(cityId, this.getTour.options.cities)
      const index = this.getTour.options.cities.indexOf(cityId)
      if (index >= 0)  this.getTour.options.cities.splice(index, 1)
    },
    removeStartTime(time) {
      this.startTimes = this.startTimes.filter(i => i != time)
    },
    addStartTime() {
      if (this.newStartTime != '' && !this.startTimes.includes(this.newStartTime)) {
        this.startTimes.push(this.newStartTime)
        this.newStartTime = ''
      }
    },
    setTourDateTimes() {
      if (this.startDates.length != 0) {
        this.getTour.options.dates = []
        this.startDates.forEach((date) => {
          if (this.startTimes.length != 0) {
            this.startTimes.forEach((time) => {
              this.getTour.options.dates.push(`${date} ${time}`)
            })
          }
          else {
            this.getTour.options.dates.push(`${date} 00:00`)
          }
        })
      }
      if (this.startDate != ''){
        this.getTour.options.dates = []
        this.getTour.options.dates.push(`${this.startDate} 00:00`)
        this.getTour.options.dateStart = `${this.startDate} 00:00`
      }
    }
  },
};
</script>

<style lang="css" scoped>
</style>
