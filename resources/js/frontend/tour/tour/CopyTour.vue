<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on }">
        <v-btn 
          color="green" 
          fab
          small
          flat
          outline
          dark 
          v-on="on"
        >
          <i class="material-icons">
            file_copy
          </i>         
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="green subheading white--text"
          primary-title
        >
          Копировать тур
        </v-card-title>

        <v-card-text>
          <v-date-picker 
            v-model="picker" 
            color="green"
            locale="ru-ru" 
            :min="dateToday"
            multiple
          />
        </v-card-text>

        <v-divider />

        <v-card-actions>
          <v-spacer />
          <CreateTour
            :tour="tour"
            :token="token"
            :date-start="picker"
          />
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import moment from 'moment'
import CreateTour from '../includes/CreateTour'
export default {
  name: 'CopyTour',
  components: {
    CreateTour,
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
      dialog: false,
      picker: [new Date().toISOString().substr(0, 10)],
      landscape: false,
      reactive: false
    }
  },
  computed: {
    dateToday: function() {
      return moment().format('YYYY-MM-DD')
    }
  },
  mounted() {
    this.picker = [JSON.parse(this.tour.extra).options.dateStart]
  },
}
</script>