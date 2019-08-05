<template>
  <v-layout justify-center>
    <v-dialog 
      v-model="dialog" 
      scrollable 
      lazy
      max-width="500px"
    >
      <template 
        v-slot:activator="{ on }"
      >
        <v-btn 
          color="green"
          outline 
          small
          dark 
          v-on="on"
        >
          О туре
        </v-btn>
      </template>
      <v-card>
        <v-card-title
          class="display-2"
        >
          Информация о туре: {{ tour.name }}
        </v-card-title>
        <v-divider />
        <v-card-text style="height: 300px;">
          <div class="item">
            <span class="header">
              Города:
            </span>
            <span
              v-for="city in tour.cities_list"
              :key="city"
            >
              {{ getCityName(city) }}
            </span>
          </div>
          <div class="item">
            <span class="header">
              Дата начала:
            </span>
            <span>
              {{ tourInfo.options.dateStart }}
            </span>
          </div>
          <div class="item">
            <span class="header">
              Дней:
            </span>
            <span>
              {{ tourInfo.options.days }}
            </span>
          </div>
          <div class="item">
            <span class="header">
              Транспорт:
            </span>
            <span
              v-for="transport in tourInfo.transport"
              :key="transport.id"
            >
              <br>
              {{ transport.company.name }}: 
              {{ transport.item.name }}.
              Мест: 
              {{ transport.item.qnt }}
            </span>
          </div>
          <div class="item">
            <span class="header">
              Экскурсии:
            </span>
            <span
              v-for="event in tourInfo.museum"
              :key="event.obj.id"
            >
              <br>
              {{ event.museum.name }}: 
              {{ event.obj.description }}.
            </span>
          </div>
          <div class="item">
            <span class="header">
              Размещение:
            </span>
            <span
              v-for="hotel in tourInfo.hotel"
              :key="hotel.obj.id"
            >
              <br>
              {{ hotel.hotel.name }}
            </span>
          </div>
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-btn 
            color="green"
            dark 
            text 
            @click="dialog = false"
          >
            Закрыть
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'About',
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      dialog: false,
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
    ]),
    tourInfo: function() {
      return JSON.parse(this.tour.description)
    }
  },
  created() {
    this.fetchCities()
  },
  methods: {
    ...mapActions([
      'fetchCities',
    ]),
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
  }
};
</script>

<style lang="scss" scoped>
.item {
  font-size: 20px;
  .header {
    color: gray;
  }
}
</style>
