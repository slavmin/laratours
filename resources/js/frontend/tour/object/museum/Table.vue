<template>
  <v-layout column> 
    <!-- <v-btn 
      color="green"
      dark
      @click="show"
    >
      Show me
    </v-btn> -->
    <v-layout 
      row
      wrap
    >
      <v-flex
        v-for="museum in allMuseum"
        :key="museum.id"
        mb-5
        xs12
        md12
        lg6
        xl4
      >
        <v-layout 
          row 
          wrap
          justify-start
        >
          <div>
            <h3 class="display-1">
              {{ museum.name }}
            </h3>
            <div class="text-xs-left subheading mb-3">
              {{ getCityName(museum.city_id) }}
            </div>
          </div>
          <Edit 
            :museum="museum" 
            :token="token"
            :cities-select="cities"
          />
        </v-layout>
        <v-layout 
          row 
          wrap
          mb-3
          align-center
        >
          <i class="material-icons mr-2">
            account_balance
          </i>
          <div 
            v-for="(type, i) in JSON.parse(museum.description).museumType"
            :key="i"
            class="mr-2"
          >
            {{ type }}
          </div>
        </v-layout>
        <v-layout 
          row 
          wrap
          mb-2
        >
          <div class="mr-3">
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              web
            </i>
            <a 
              :href="JSON.parse(museum.description).contacts.site"
              target="_blank"
            >
              {{ JSON.parse(museum.description).contacts.site }}
            </a>
          </div>
          <div class="mr-3">
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              email
            </i>
            <a 
              :href="'mailto:' + JSON.parse(museum.description).contacts.email"
            >
              {{ JSON.parse(museum.description).contacts.email }}
            </a>
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ JSON.parse(museum.description).contacts.phone }}
          </div>
        </v-layout>
        <v-layout 
          row 
          wrap
          mb-2
        >
          <div class="mr-3">
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              person
            </i>
            {{ JSON.parse(museum.description).staff.name }}
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ JSON.parse(museum.description).staff.phone }}
          </div>
        </v-layout>
        <div class="heading text-xs-left mb-3">
          {{ JSON.parse(museum.description).about }}
        </div> 
        <v-data-table
          :headers="headers"
          :items="museum.objectables"
          class="elevation-1"
          rows-per-page-text="На странице:"
        >
          <template v-slot:items="props">
            <td class="text-xs-left">
              {{ props.item.name }}
            </td>
            <td class="text-xs-center">
              {{ props.item.price }}
            </td>
            <td class="text-xs-center">
              {{ props.item.description }}
            </td>
          </template>
        </v-data-table>
        <AddObjectables
          :museum="museum" 
          :token="token"
        />
      </v-flex>
    </v-layout>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
import Edit from './Edit'
import AddObjectables from './AddObjectables'
export default {

  name: 'ObjectMuseumTable',
  components: {
    Edit,
    AddObjectables
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    cities: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      headers: [
        {
          text: 'Название',
          align: 'left',
          value: 'name'
        },
        {
          text: 'Цена',
          align: 'center',
          value: 'price'
        },
        {
          text: 'Описание',
          align: 'center',
          value: 'description'
        },
      ]
    };
  },
  computed: {
    ...mapGetters([
      'allMuseum',
      'allCities'
    ])
  },
  mounted() {
    this.fetchMuseum()
    this.fetchCities()
  },
  methods: {
    ...mapActions([
      'fetchMuseum',
      'fetchCities'
    ]),
    show() {
      console.log(this.allMuseum)
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
  },

};
</script>

<style lang="css" scoped>
</style>
