<template>
  <div>
    <v-layout
      row
      wrap
    >
      <v-flex>
        <h2 class="text-xs-center grey--text">
          Выберите музеи и экскурсии:
        </h2>
        <v-layout 
          v-for="museum in getActualMuseum"
          :key="museum.id"
          row 
          wrap
          align-center
          mb-5
        >
          <v-flex xs12>
            <div class="text-xs-center display-2">
              {{ museum.name }}
            </div>
            <div class="text-xs-center subheading">
              {{ getCityName(museum.city_id) }},
              <i 
                class="material-icons"
                style="font-size: 12px;"
              >
                phone
              </i>
              {{ JSON.parse(museum.description).contacts.phone }}
            </div>
          </v-flex>
          <v-layout
            row
            wrap
            justify-center
          >
            <v-flex
              v-for="item in museum.objectables"
              :key="item.id"
              xs3
              lg2
              ma-2
            >
              <v-card 
                class="museum-card"
                :class="{'is-select' : item.selected}"
                pa-3
              >
                <v-card-title primary-title>
                  <div>
                    <div class="headline mb-2">
                      {{ item.description }}
                      <i 
                        class="material-icons ml-2"
                        style="color: grey; font-size: 20px;"
                        :title="item.description"
                      >
                        info
                      </i>
                    </div>
                    <v-divider />
                    <v-select
                      :items="days"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="День тура"
                      outline
                    />
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
                    <span class="grey--text text--darken-1">
                      Цена: {{ item.price }}
                    </span>
                    <div class="mt-2">
                      Длительность: {{ JSON.parse(item.extra).duration }}ч.
                    </div>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn 
                    flat
                    :dark="item.selected"
                    @click="choose(museum, item)"
                  >
                    {{ item.selected ? 'Убрать' : 'Выбрать' }}
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-layout>
        <v-layout 
          row 
          wrap
          justify-end
        >
          <v-flex xs2>  
            <v-btn 
              dark
              color="green"
              @click="done"
            >
              OK
            </v-btn>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'ChooseMuseum',

  data() {
    return {

    };
  },
  computed: {
    ...mapGetters([
      'allCities',
      'getActualMuseum',
      'getTour'
    ]),
    days: function() {
      let result = []
      for (let i = 1; i <= this.getTour.options.days; i++) {
        result.push(i)
      } 
      return result
    },
  },
  created() {
    this.updateActualMuseum()
  },
  methods: {
    ...mapActions([
      'updateActualMuseum',
      'updateNewMuseumOptions',
      'updateTourMuseum',
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
    choose(museum, item) {
      let updData = {
        'museum': museum,
        'item': {
          ...item,
          selected: !item.selected,
        }, 
      }
      this.updateNewMuseumOptions(updData)
    },
    done() {
      this.updateTourMuseum()
    },
  }
};
</script>

<style lang="css" scoped>
.museum-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
}
</style>
