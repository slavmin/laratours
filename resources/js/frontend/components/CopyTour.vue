<template>
  <div class="text-xs-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on }">
        <v-btn color="green" icon title="Копировать" dark v-on="on">
          <i class="material-icons">
            file_copy
          </i>
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="subheading white--text"
          primary-title
          style="background-color: #66a5ae;"
        >
          Копировать тур
        </v-card-title>

        <v-card-text>
          <v-row justify="center" class="mt-5">
            <v-date-picker
              v-model="picker"
              color="#66a5ae"
              locale="ru-ru"
              :min="dateToday"
              :selected-items-text="`${picker.length} выбрано`"
              multiple
              first-day-of-week="1"
            />
          </v-row>
        </v-card-text>

        <v-divider />

        <v-card-actions>
          <v-btn small text color="#aa282" @click="dialog = false">
            Закрыть
          </v-btn>
          <v-spacer />
          <!-- <CreateTour
            :tour="tour"
            :token="token"
            :date-start="picker"
          /> -->
          <v-btn
            v-if="picker.length > 0"
            dark
            small
            color="#aa282a"
            @click="sendRequest"
          >
            Создать ({{ picker.length }})
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  name: 'CopyTour',
  props: {
    tour: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      dialog: false,
      picker: [],
      landscape: false,
      reactive: false,
    }
  },
  computed: {
    dateToday: function() {
      return moment().format('YYYY-MM-DD')
    },
  },
  methods: {
    sendRequest() {
      axios
        .post('/api/copy-tour', {
          tour_id: this.tour.id,
          dates: this.picker,
        })
        .catch(e => console.log(e))
        .finally(() => location.replace('/operator/tour'))
    },
  },
}
</script>

<style>
</style>