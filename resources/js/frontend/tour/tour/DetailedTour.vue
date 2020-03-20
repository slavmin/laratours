<template>
  <v-container>
    <v-row
      no-gutters
      justify="center"
      class="wrap"
    >
      <v-card>
        <v-toolbar
          dark
          prominent
          color="#94CED7"
          src="/img/frontend/tour-toolbar_bg.jpg"
        >
          <v-toolbar-title>
            <h1>
              Подробный конструктор
            </h1>
          </v-toolbar-title>
          <v-spacer />
          <v-btn
            icon
            :href="`/operator/tour/${tourId}/edit`"
            title="Общие данные тура"
          >
            <svg
              style="width:24px;height:24px"
              viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M15.9,18.45C17.25,18.45 18.35,17.35 18.35,16C18.35,14.65 17.25,13.55 15.9,13.55C14.54,13.55 13.45,14.65 13.45,16C13.45,17.35 14.54,18.45 15.9,18.45M21.1,16.68L22.58,17.84C22.71,17.95 22.75,18.13 22.66,18.29L21.26,20.71C21.17,20.86 21,20.92 20.83,20.86L19.09,20.16C18.73,20.44 18.33,20.67 17.91,20.85L17.64,22.7C17.62,22.87 17.47,23 17.3,23H14.5C14.32,23 14.18,22.87 14.15,22.7L13.89,20.85C13.46,20.67 13.07,20.44 12.71,20.16L10.96,20.86C10.81,20.92 10.62,20.86 10.54,20.71L9.14,18.29C9.05,18.13 9.09,17.95 9.22,17.84L10.7,16.68L10.65,16L10.7,15.31L9.22,14.16C9.09,14.05 9.05,13.86 9.14,13.71L10.54,11.29C10.62,11.13 10.81,11.07 10.96,11.13L12.71,11.84C13.07,11.56 13.46,11.32 13.89,11.15L14.15,9.29C14.18,9.13 14.32,9 14.5,9H17.3C17.47,9 17.62,9.13 17.64,9.29L17.91,11.15C18.33,11.32 18.73,11.56 19.09,11.84L20.83,11.13C21,11.07 21.17,11.13 21.26,11.29L22.66,13.71C22.75,13.86 22.71,14.05 22.58,14.16L21.1,15.31L21.15,16L21.1,16.68M6.69,8.07C7.56,8.07 8.26,7.37 8.26,6.5C8.26,5.63 7.56,4.92 6.69,4.92A1.58,1.58 0 0,0 5.11,6.5C5.11,7.37 5.82,8.07 6.69,8.07M10.03,6.94L11,7.68C11.07,7.75 11.09,7.87 11.03,7.97L10.13,9.53C10.08,9.63 9.96,9.67 9.86,9.63L8.74,9.18L8,9.62L7.81,10.81C7.79,10.92 7.7,11 7.59,11H5.79C5.67,11 5.58,10.92 5.56,10.81L5.4,9.62L4.64,9.18L3.5,9.63C3.41,9.67 3.3,9.63 3.24,9.53L2.34,7.97C2.28,7.87 2.31,7.75 2.39,7.68L3.34,6.94L3.31,6.5L3.34,6.06L2.39,5.32C2.31,5.25 2.28,5.13 2.34,5.03L3.24,3.47C3.3,3.37 3.41,3.33 3.5,3.37L4.63,3.82L5.4,3.38L5.56,2.19C5.58,2.08 5.67,2 5.79,2H7.59C7.7,2 7.79,2.08 7.81,2.19L8,3.38L8.74,3.82L9.86,3.37C9.96,3.33 10.08,3.37 10.13,3.47L11.03,5.03C11.09,5.13 11.07,5.25 11,5.32L10.03,6.06L10.06,6.5L10.03,6.94Z"
              />
            </svg>
          </v-btn>
          <v-btn
            icon
            title="Транспорт"
            :color="steps[currentStep] == 'transport' ? 'yellow' : ''"
            @click="changeStep(0)"
          >
            <v-icon>mdi-train-car</v-icon>
          </v-btn>
          <v-btn
            icon
            title="Музеи и экскурсии"
            :color="steps[currentStep] == 'museum' ? 'yellow' : ''"
            @click="changeStep(1)"
          >
            <v-icon>mdi-bank-outline</v-icon>
          </v-btn>
          <v-btn
            icon
            title="Размещения"
            :color="steps[currentStep] == 'hotel' ? 'yellow' : ''"
            @click="changeStep(2)"
          >
            <svg
              style="width:24px;height:24px"
              viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M7 14C8.66 14 10 12.66 10 11C10 9.34 8.66 8 7 8C5.34 8 4 9.34 4 11C4 12.66 5.34 14 7 14M7 10C7.55 10 8 10.45 8 11C8 11.55 7.55 12 7 12C6.45 12 6 11.55 6 11C6 10.45 6.45 10 7 10M19 7H11V15H3V5H1V20H3V17H21V20H23V11C23 8.79 21.21 7 19 7M21 15H13V9H19C20.1 9 21 9.9 21 11Z"
              />
            </svg>
          </v-btn>
          <v-btn
            icon
            title="Питание"
            :color="steps[currentStep] == 'meal' ? 'yellow' : ''"
            @click="changeStep(3)"
          >
            <v-icon>mdi-silverware</v-icon>
          </v-btn>
          <v-btn
            icon
            title="Гиды"
            :color="steps[currentStep] == 'guide' ? 'yellow' : ''"
            @click="changeStep(4)"
          >
            <v-icon>mdi-human-greeting</v-icon>
          </v-btn>
          <v-btn
            icon
            title="Сопровождающие"
            :color="steps[currentStep] == 'attendant' ? 'yellow' : ''"
            @click="changeStep(5)"
          >
            <v-icon>mdi-human-handsup</v-icon>
          </v-btn>
          <v-btn
            icon
            :color="steps[currentStep] == 'services' ? 'yellow' : ''"
            @click="changeStep(6)"
          >
            <v-icon>mdi-playlist-plus</v-icon>
          </v-btn>
          <v-btn
            icon
            :color="steps[currentStep] == 'calculate' ? 'yellow' : ''"
            @click="changeStep(7)"
          >
            <v-icon>mdi-cash-100</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <ChooseTransport
            v-if="steps[currentStep] == 'transport'"
            :tour-id="parseInt(tourId)"
          />
          <ChooseMuseum
            v-if="steps[currentStep] == 'museum'"
            :tour-id="parseInt(tourId)"
          />
          <ChooseHotel
            v-if="steps[currentStep] == 'hotel'"
            :tour-id="parseInt(tourId)"
          />
          <ChooseMeal
            v-if="steps[currentStep] == 'meal'"
            :tour-id="parseInt(tourId)"
          />
          <ChooseGuide
            v-if="steps[currentStep] == 'guide'"
            :tour-id="parseInt(tourId)"
          />
          <ChooseAttendant
            v-if="steps[currentStep] == 'attendant'"
            :tour-id="parseInt(tourId)"
          />
          <ChooseServices
            v-if="steps[currentStep] == 'services'"
            :tour-id="parseInt(tourId)"
          />
          <Calculate
            v-if="steps[currentStep] == 'calculate'"
            :tour-id="parseInt(tourId)"
          />
        </v-card-text>
      </v-card>
    </v-row>
    <v-btn
      v-if="currentStep != (steps.length - 1)"
      dark
      fab
      class="done-btn"
      color="#aa282a"
      @click="nextStep"
    >
      <i class="material-icons">
        arrow_forward
      </i>
    </v-btn>
  </v-container>
</template>
<script>
import ChooseTransport from './detailed/ChooseTransport'
import ChooseMuseum from './detailed/ChooseMuseum'
import ChooseHotel from './detailed/ChooseHotel'
import ChooseMeal from './detailed/ChooseMeal'
import ChooseGuide from './detailed/ChooseGuide'
import ChooseAttendant from './detailed/ChooseAttendant'
import ChooseServices from './detailed/ChooseServices'

import Calculate from './detailed/Calculate'
export default {
  name: 'DetailedTour',
  components: {
    ChooseTransport,
    ChooseMuseum,
    ChooseHotel,
    ChooseMeal,
    ChooseGuide,
    ChooseAttendant,
    ChooseServices,
    Calculate,
  },
  props: {
    token: {
      type: String,
      default: '',
    },
    tourId: {
      type: String,
      default: '',
    },
    method: {
      type: String,
      default: '',
    },
    route: {
      type: String,
      default: '',
    },
  },
  data: () => {
    return {
      show: {
        transport: true,
        museum: false,
        hotel: false,
        meal: false,
        guide: false,
        attendant: false,
        services: false,
        calculate: false,
      },
      steps: [
        'transport',
        'museum',
        'hotel',
        'meal',
        'guide',
        'attendant',
        'services',
        'calculate',
      ],
      currentStep: 0,
    }
  },
  methods: {
    changeStep(step) {
      this.currentStep = step
    },
    nextStep() {
      if (this.currentStep < this.steps.length - 1) {
        this.currentStep += 1
      }
      this.scrollToTop()
    },
    scrollToTop() {
      document.getElementById('app').scrollIntoView()
    },
  },
}
</script>
<style lang="scss" scoped>
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>