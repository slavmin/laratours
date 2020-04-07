<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Информация о заявителе</strong>
    </h5>
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <v-form
        ref="form1"
        class="text-center"
      >
        <!-- Name -->
        <div class="md-form">
          <v-text-field
            v-model="info.name"
            type="text"
            label="ФИО"
          />
        </div>
        <!-- Position -->
        <div class="md-form">
          <v-text-field
            v-model="info.position"
            type="text"
            label="Должность"
          />
        </div>
        <!-- Phone number -->
        <div class="md-form">
          <v-text-field
            v-model="info.phone"
            type="text"
            label="Телефон"
          />
        </div>
        <!-- email -->
        <div class="md-form">
          <v-text-field
            v-model="info.email"
            type="email"
            label="Email"
            :rules="rules.email"
          />
        </div>
        <!-- Region -->
        <div class="row">
          <div class="col-12 text-center grey-text">
            Регионы, по маршруту, включая регион начала движения
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <v-select
              v-model="info.selectedRegionCodes"
              color="#aa282a"
              :items="regionsWithCodesArray"
              attach
              chips
              multiple
            />
          </div>
        </div>
        <!-- Count -->
        <div class="md-form">
          <v-text-field
            v-model="info.count"
            type="text"
            label="Количество детей"
          />
        </div>
        <!-- Goal -->
        <div class="md-form">
          <v-text-field
            v-model="info.goal"
            type="text"
            label="Цель"
          />
        </div>
        <!-- Date start -->
        <div class="row">
          <div class="col-12 text-center grey-text">
            Предполагаемое время начала перевозки
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <v-menu
              v-model="showDateStart"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="info.dateStart"
                  label="Дата"
                  readonly
                  v-on="on"
                />
              </template>
              <v-date-picker
                v-model="info.dateStart"
                color="#aa282a"
                :min="dateToday"
                locale="ru-ru"
                first-day-of-week="1"
              />
            </v-menu>
          </div>
          <div class="col-6">
            <v-menu
              v-model="showTimeStart"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="info.timeStart"
                  label="Время"
                  readonly
                  v-on="on"
                />
              </template>
              <v-time-picker
                v-model="info.timeStart"
                color="#aa282a"
                locale="ru-ru"
                :allowed-minutes="allowedStep"
                class="mt-3"
                format="24hr"
              />
            </v-menu>
          </div>
        </div>
        <!-- Date end -->
        <div class="row">
          <div class="col-12 text-center grey-text">
            Предполагаемое время окончания перевозки
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <v-menu
              v-model="showDateEnd"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="info.dateEnd"
                  label="Дата"
                  readonly
                  v-on="on"
                />
              </template>
              <v-date-picker
                v-model="info.dateEnd"
                :min="minDateEnd"
                color="#aa282a"
                locale="ru-ru"
                first-day-of-week="1"
              />
            </v-menu>
          </div>
          <div class="col-6">
            <v-menu
              v-model="showTimeEnd"
              :close-on-content-click="false"
              :nudge-right="40"
              transition="scale-transition"
              offset-y
              min-width="290px"
            >
              <template v-slot:activator="{ on }">
                <v-text-field
                  v-model="info.timeEnd"
                  label="Время"
                  readonly
                  v-on="on"
                />
              </template>
              <v-time-picker
                v-model="info.timeEnd"
                color="#aa282a"
                locale="ru-ru"
                :allowed-minutes="allowedStep"
                class="mt-3"
                format="24hr"
              />
            </v-menu>
          </div>
        </div>
      </v-form>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import moment from 'moment'
export default {
  name: 'Form1',
  data() {
    return {
      showDateStart: false,
      showTimeStart: false,
      showDateEnd: false,
      showTimeEnd: false,
    }
  },
  computed: {
    ...mapGetters({
      info: 'getForm1',
      regionsWithCodesArray: 'getRegionsWithCodesArray',
      rules: 'getValidationRules',
    }),
    dateToday: function() {
      return moment().format('YYYY-MM-DD')
    },
    minDateEnd: function() {
      let result = ''
      if (this.info.dateStart) {
        result = this.info.dateStart
      } else {
        result = this.dateToday
      }
      return result
    },
  },
  mounted() {
    this.validate()
  },
  methods: {
    allowedStep: m => m % 15 === 0,
    validate() {
      if (this.$refs.form1.validate()) {
        this.snackbar = true
      }
    },
  },
}
</script>