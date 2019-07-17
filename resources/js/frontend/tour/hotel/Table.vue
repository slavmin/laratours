<template>
  <v-layout column> 
    <v-layout 
      row
      wrap
    >
      <v-flex
        v-for="hotel in allHotel"
        :key="hotel.id"
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
              {{ hotel.name }}
            </h3>
            <div class="text-xs-left subheading mb-3">
              {{ getCityName(hotel.city_id) }}
            </div>
          </div>
          <Edit 
            :hotel="hotel" 
            :token="token"
          />
        </v-layout>
        <v-layout 
          row 
          wrap
          mb-3
          align-center
        >
          <i class="material-icons mr-2">
            hotel
          </i>
          <div 
            v-for="(type, i) in JSON.parse(hotel.description).hotelType"
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
              :href="JSON.parse(hotel.description).contacts.site"
              target="_blank"
            >
              {{ JSON.parse(hotel.description).contacts.site }}
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
              :href="'mailto:' + JSON.parse(hotel.description).contacts.email"
            >
              {{ JSON.parse(hotel.description).contacts.email }}
            </a>
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ JSON.parse(hotel.description).contacts.phone }}
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
            {{ JSON.parse(hotel.description).staff.name }}
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ JSON.parse(hotel.description).staff.phone }}
          </div>
        </v-layout>
        <div class="heading text-xs-left mb-3">
          {{ JSON.parse(hotel.description).about }}
        </div> 
        <v-data-table
          :headers="headers"
          :items="hotel.objectables"
          class="elevation-1"
          rows-per-page-text="На странице:"
        >
          <template v-slot:items="props">
            <td class="text-xs-left">
              {{ JSON.parse(props.item.extra).roomType }}
            </td>
            <td class="text-xs-center">
              {{ props.item.price }}
            </td>
            <!-- <td class="text-xs-center">
              {{ JSON.parse(props.item.extra).duration }} ч.
            </td> -->
            <td class="text-xs-center">
              {{ props.item.name }}
            </td>
          </template>
        </v-data-table>
        <AddObjectables
          :hotel="hotel" 
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

  name: 'ObjectHotelTable',
  components: {
    Edit,
    AddObjectables
  },
  props: {
    token: {
      type: String,
      default: ''
    },
  },
  data() {
    return {
      headers: [
        {
          text: 'Тип номера',
          align: 'left',
          value: 'description'
        },
        {
          text: 'Цена',
          align: 'center',
          value: 'price'
        },
        {
          text: 'Посетитель',
          align: 'center',
          value: 'name'
        },
      ]
    };
  },
  computed: {
    ...mapGetters([
      'allHotel',
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
