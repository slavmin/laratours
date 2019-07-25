<template>
  <v-flex>
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
        <v-flex xs2>
          <v-text-field
            v-model="days"
            label="Дней"
            :rules="[v => !!v || 'Укажите количество дней']"
            name="days"
            mask="###"
            color="green lighten-3"
          />
        </v-flex>
        <v-flex xs2>
          <v-text-field
            v-model="nights"
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
</template>

<script>
import { mapActions, mapGetters } from 'vuex'

export default {

  name: 'Options',

  data() {
    return {
      tourTypeFormValid: false,
      tourName: '',
      nameRules: [
        v => !!v || 'Введите название тура',
      ],
      tourType: 0,
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
      tourLanguages: [1],
      showDateStart: false,
      showDateEnd: false,
      dateStart: new Date().toISOString().substr(0, 10),
      dateEnd: new Date().toISOString().substr(0, 10),
      choosenCities: [],
      days: NaN,
      nights: 0
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'allTourOptions',
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
    tourOptions: function() {
      return {
        type: this.tourType,
        name: this.tourName,
        dateStart: this.dateStart,
        days: this.days,
        nights: this.nights,
        grade: this.tourGrade,
        languages: this.tourLanguages,
        cities: this.choosenCities,
      }
    },
  },
  created() {
    this.fetchAllTourOptions()
  },
  methods: {
    ...mapActions([
      'fetchAllTourOptions',
      'updateTourOptions',
      'updateConstructorCurrentStage',
    ]),
    submitType() {
      if (this.$refs.tourTypeForm.validate()) {
        this.snackbar = true
        this.updateTourOptions(this.tourOptions)
        this.updateConstructorCurrentStage('Options are set')
      }
    },
  },
};
</script>

<style lang="css" scoped>
</style>
