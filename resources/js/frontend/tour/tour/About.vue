<template>
  <v-layout>
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
          color="#aa282a"
          small
          dark 
          v-on="on"
        >
          О туре
        </v-btn>
      </template>
      <v-card>
        <v-card-title
          style="background-color:#66a5ae;"
          class="display-2 white--text"
        >
          Информация о туре: {{ tour.name }}
        </v-card-title>
        <v-divider />
        <v-card-text>
          <v-card-text 
            class="text-xs-left"
            v-html="contentString" 
          />
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-spacer />
          <v-btn 
            color="#aa282a"
            dark 
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
      return JSON.parse(this.tour.extra)
    },
    contentString: function() {
      if (this.tourInfo.editorsContent.length > 0) {
        let result = ''
         this.tourInfo.editorsContent.forEach((item) => {
           result += item
         })
        return result
      } else {
        return 'Программа не заполнена'
      }
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
