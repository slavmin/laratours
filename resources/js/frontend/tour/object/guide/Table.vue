<template>
  <v-layout column> 
    <v-layout 
      row
      wrap
      justify-center
    >
      <v-data-table
        :headers="headers"
        :items="allGuide"
        class="elevation-1"
      >
        <template v-slot:items="props">
          <td>
            {{ props.item.name }}
          </td>
          <td class="text-xs-right">
            {{ getCityName(JSON.parse(props.item.description).city) }}
          </td>
          <td class="text-xs-right">
            <span 
              v-for="grade in JSON.parse(props.item.description).grade"
              :key="grade"
              class="grey--text"
            >
              {{ grade }}
            </span>
          </td>
          <td class="text-xs-right">
            <span 
              v-for="lang in JSON.parse(props.item.description).languages"
              :key="lang"
              class="grey--text"
            >
              {{ getLanguageName(lang) }}
              <br>
            </span>
          </td>
          <td class="text-xs-right">
            {{ props.item.price }}
          </td>
        </template>
      </v-data-table>
    </v-layout>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'ObjectGuideTable',
  props: {
    token: {
      type: String,
      default: ''
    },
  },
  data () {
    return {
      headers: [
        {
          text: 'ФИО гида',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'Город', value: 'сity' },
        { text: 'Уровень', value: 'grade' },
        { text: 'Язык', value: 'language' },
        { text: 'Стоимость', value: 'price' }
      ],
    }
  },
  computed: {
    ...mapGetters([
      'allGuide',
      'allCities',
      'allAvailableLanguages',
    ]),
  },
  created() {
    this.fetchGuide()
    this.fetchCities()
  },
  methods: {
    ...mapActions([
      'fetchGuide',
      'fetchCities',
    ]),
    show() {
      console.log(this.allAvailableLanguages)
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
    getLanguageName(id) {
      let languageName = ''
      this.allAvailableLanguages.forEach((language) => {
        if (language.id == id) {
          languageName = language.name
        }
      })
      return languageName
    },
  },

};
</script>

<style lang="css" scoped>
</style>
