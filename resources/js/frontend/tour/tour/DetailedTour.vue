<template>
  <v-container fluid>
    <v-row
      no-gutters
      justify="center"
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
          <v-btn icon>
            <v-icon>mdi-train-car</v-icon>
          </v-btn>
          <v-btn icon>
            <v-icon>mdi-bank-outline</v-icon>
          </v-btn>
          <v-btn icon>
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
          <v-btn icon>
            <v-icon>mdi-silverware</v-icon>
          </v-btn>
          <v-btn icon>
            <v-icon>mdi-human-greeting</v-icon>
          </v-btn>
          <v-btn icon>
            <v-icon>mdi-playlist-plus</v-icon>
          </v-btn>
          <v-btn icon>
            <v-icon>mdi-cash-100</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <ChooseTransport :tour-id="parseInt(tourId)" />
        </v-card-text>
      </v-card>
    </v-row>
  </v-container>
</template>
<script>
import ChooseTransport from './ChooseTransport'
export default {
  name: 'DetailedTour',
  components: {
    ChooseTransport,
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
  },
}
</script>