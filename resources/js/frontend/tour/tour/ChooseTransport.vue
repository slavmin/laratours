<template>
  <div>
    <h2 class="text-xs-center grey--text">
      Выберите транспорт:
    </h2>
    <v-layout
      row
      wrap
    >
      <v-layout 
        v-for="transport in actualTransports"
        :key="transport.id"
        row 
        wrap
        align-center
        mb-5
      >
        <v-flex xs12>
          <div class="text-xs-center display-2">
            {{ transport.name }}
          </div>
          <div class="text-xs-center subheading">
            {{ getCityName(transport.city_id) }},
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ transport.description }}
          </div>
        </v-flex>
        <v-layout
          row
          wrap
          justify-center
        >
          <v-flex
            v-for="item in transport.objectables"
            :key="item.id"
            xs3
            lg2
            ma-2
          >
            <v-card 
              color="green lighten-5"
              pa-3
            >
              <v-card-title primary-title>
                <div>
                  <div class="headline mb-2">
                    {{ item.name }}
                    <i 
                      class="material-icons ml-2"
                      style="color: grey; font-size: 20px;"
                      :title="item.description"
                    >
                      info
                    </i>
                  </div>
                  <v-divider />
                  <div
                    v-for="(price, i) in JSON.parse(item.extra).prices"
                    :key="i"
                    row
                    justify-content-between
                    wrap
                  >
                    <span class="grey--text text--darken-1">
                      {{ price.name }}: 
                    </span>
                    <p 
                      style="display: inline-block;"
                    >
                      {{ price.value }}
                    </p>
                  </div>
                  <br>
                  <div
                    v-for="(grade, i) in JSON.parse(item.extra).grade"
                    :key="i"
                    row
                    justify-center
                    wrap
                    my-1
                  >
                    <span class="grey--text text--darken-1">
                      {{ grade }}
                    </span>
                  </div>
                  <div class="mt-2">
                    Мест: {{ item.qnt }}
                  </div>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn 
                  flat
                  @click="$emit('choose', transport, item)"
                >
                  Выбрать
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-layout>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'ChooseTransport',
  props: {
    actualTransports: {
      type: Array,
      default: function() {
        return []
      }
    },  
  },
  data() {
    return {

    };
  },
  computed: {
    ...mapGetters(['allCities'])
  },
  methods: {
    ...mapActions(['fetchCities']),
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
