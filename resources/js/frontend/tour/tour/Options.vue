<template>
  <v-flex>
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
        color="green lighten-3"
        required
      />
      <v-text-field
        v-model="getTour.options.name"
        label="Название тура"
        name="name"
        :rules="nameRules"
        append-outer-icon="title"
        color="green lighten-3"
        outline
        required
      />
      <v-select
        v-model="getTour.options.cities"
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
                v-model="getTour.options.dateStart"
                label="Дата начала"
                :rules="[v => !!v || 'Выберите дату']"
                prepend-icon="event"
                readonly
                required
                v-on="on"
              />
            </template>
            <v-date-picker 
              v-model="getTour.options.dateStart" 
              color="green"
              locale="ru-ru"
              @input="showDateStart = false"
            />
          </v-menu>
        </v-flex>
        <v-flex xs2>
          <v-text-field
            v-model="getTour.options.days"
            label="Дней"
            :rules="[v => !!v || 'Укажите количество дней']"
            name="days"
            mask="###"
            color="green lighten-3"
          />
        </v-flex>
        <v-flex xs2>
          <v-text-field
            v-model="getTour.options.nights"
            label="Ночей"
            name="nights"
            mask="###"
            color="green lighten-3"
          />
        </v-flex>
      </v-layout>
      <v-layout 
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
            color="green lighten-3"
            multiple
            required
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
            color="green lighten-3"
            multiple
            required
          />
        </v-flex>
      </v-layout>
      <v-layout 
        row 
        wrap
      >
        <v-flex xs12>
          <v-text-field
            v-model="getTour.qnt"
            label="Количество туристов"
            name="qnt"
            mask="###"
            color="green lighten-3"
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
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

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
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'allTourOptions',
      'getTour',
      'getTourName',
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
  },
  created() {
    this.fetchAllTourOptions()
  },
  mounted() {
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
    ]),
    submitType() {
      if (this.$refs.tourTypeForm.validate()) {
        this.snackbar = true
        this.updateActualTransport()
        this.updateActualMuseum()
        this.updateActualHotel()
        this.updateActualMeal()
        this.updateActualGuide()
        this.updateActualAttendant()
        this.updateConstructorCurrentStage('Options are set')
      }
    },
    logCity() {
    }
  },
};
</script>

<style lang="css" scoped>
</style>
