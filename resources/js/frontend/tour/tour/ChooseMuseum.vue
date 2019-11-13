<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
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
              {{ JSON.parse(museum.extra).contacts.phone }}
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
                :class="[
                  {'is-select' : item.selected}, 
                  {'is-custom-order': JSON.parse(item.extra).isCustomOrder}
                ]"
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
                      color="#aa282a"
                    />
                    <!-- Regular events -->
                    <div
                      v-if="!JSON.parse(item.extra).isCustomOrder"
                    >
                      <div
                        v-for="(price, i) in JSON.parse(item.extra).priceList"
                        :key="i"
                        row
                        justify-content-between
                        wrap
                      >
                        <span class="grey--text text--darken-1">
                          {{ price.customerName }}: 
                        </span>
                        <p 
                          style="display: inline-block;"
                        >
                          {{ price.price }}
                        </p>
                      </div>
                      <br>
                      <div class="mt-2">
                        Длительность: {{ JSON.parse(item.extra).duration }}ч.
                      </div>
                    </div>
                    <!-- Custom events. ЗАКАЗ НАРЯД -->
                    <div
                      v-if="JSON.parse(item.extra).isCustomOrder"
                    >
                      <v-layout 
                        row 
                        wrap
                        justify-space-between
                      >
                        <v-flex xs8>
                          <span class="grey--text text--darken-1">
                            Цена: 
                          </span>  
                          <p 
                            style="display: inline-block;"
                          >
                            {{ JSON.parse(item.extra).price }}
                          </p>
                          <br>
                          <span class="grey--text text--darken-1">
                            Кол-во человек: 
                          </span>  
                          <p 
                            style="display: inline-block;"
                          >
                            {{ JSON.parse(item.extra).count }}
                          </p>
                        </v-flex>
                        <v-flex xs4>
                          <v-text-field
                            v-model.number="item.count"
                            :disabled="item.selected"
                            label="Штук"
                            type="number"
                          />
                        </v-flex>
                      </v-layout>
                    </div>

                    <div
                      v-if="item.count"
                      class="body-2"
                    >
                      <v-divider />
                      <span class="grey--text text--darken-1">
                        Итого: 
                      </span>  
                      <p 
                        style="display: inline-block;"
                      >
                        {{ item.count * JSON.parse(item.extra).price }}
                      </p>
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
      </v-flex>
      <v-btn 
        dark
        fab
        class="done-btn"
        color="#aa282a"
        @click="done"
      >
        <i class="material-icons">
          arrow_forward
        </i>
      </v-btn>
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
    // this.updateActualMuseum()
  },
  mounted() {
    // this.fillStorageInEditMode()
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
      let updData = {}
      if (!JSON.parse(item.extra).isCustomOrder) {
        updData = {
          'museum': museum,
          'item': {
            ...item,
            selected: !item.selected,
            'about': document.getElementById('about' + item.id).value,
            isCustomOrder: false,
          }, 
        }
      } else {
        updData = {
          museum: museum,
          item: {
            ...item,
            selected: !item.selected,
            isCustomOrder: true,
          }
        }
      }
      this.updateNewMuseumOptions(updData)
    },
    done() {
      this.$emit('scrollme')
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
.is-custom-order {
  background-color: rgb(77, 238, 187);
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
