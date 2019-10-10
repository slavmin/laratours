<template>
  <v-layout column> 
    <v-layout 
      row
      wrap
      justify-center
    >
      <v-data-table
        :headers="headers"
        :items="allAttendant"
        class="elevation-1"
      >
        <template v-slot:items="props">
          <td>
            {{ props.item.name }}
          </td>
          <td class="text-xs-right">
            <span 
              v-for="cityId in JSON.parse(props.item.description).city"
              :key="cityId"
              class="grey--text"
            >
              {{ getCityName(cityId) }}
              <br>
            </span>
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
          <td>
            <Edit
              :token="token"
              :attendant="props.item"
            />
            <form 
              :action="'/operator/attendant/' + props.item.id"
              method="POST"
            >
              <input 
                id="_method" 
                type="hidden" 
                name="_method" 
                value="DELETE"
              >
              <input 
                type="hidden" 
                name="_token" 
                :value="token"
              > 
              <v-btn 
                fab
                small
                outline
                color="red"
                type="submit"
              >
                <i class="material-icons">
                  delete
                </i>
              </v-btn>
            </form>
          </td>
        </template>
      </v-data-table>
    </v-layout>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Edit from './Edit'
export default {
  name: 'ObjectAttendantTable',
  components: {
    Edit,
  },
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
          text: 'ФИО сопровождающего',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'Город', value: 'сity' },
        { text: 'Уровень', value: 'grade' },
        { text: 'Язык', value: 'language' },
        { text: 'Стоимость', value: 'price' },
        { text: 'Действия', value: 'actions'},
      ],
    }
  },
  computed: {
    ...mapGetters([
      'allAttendant',
      'allCities',
      'allAvailableLanguages',
    ]),
  },
  created() {
    this.fetchAttendant()
    this.fetchCities()
    console.log(this.allAttendant)
  },
  methods: {
    ...mapActions([
      'fetchAttendant',
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
