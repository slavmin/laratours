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
                :id="'museum-' + museum.id + '-card-' + item.id"
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
                      v-model="item.day"
                      :items="days"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="День тура"
                      outline
                    />
                    <v-text-field
                      :id="'about' + [item.id]"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="Описание"
                      append-outer-icon="watch"
                      class="mt-3"
                      color="green"
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
      about: '',
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
  mounted() {
    this.fillStorageInEditMode()
  },
  methods: {
    ...mapActions([
      'updateActualMuseum',
      'updateNewMuseumOptions',
      'updateTourMuseum',
      'updateConstructorCurrentStage',
      'updateMuseumInEditMode',
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
          'about': document.getElementById('about' + item.id).value,
        }, 
      }
      this.updateNewMuseumOptions(updData)
    },
    done() {
      this.updateTourMuseum()
      this.end()
    },
    unselect(item) {
      item.selected = false
    },
    end() {
      this.updateConstructorCurrentStage('Museum is set')
    },
    fillStorageInEditMode() {
      if (this.tourToEdit != {}) {
        let museum = []
        this.tourToEdit.extra.museum.forEach(m =>  {
          console.log(m)
          let updData = {
            ...m
          }
          updData.obj.selected = true
          museum.push(updData)
        })
        console.log(museum)
        this.updateMuseumInEditMode(museum)
        // let el = document.getElementById()
      }
    }
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
  transform: scale(0.9);
}
</style>
