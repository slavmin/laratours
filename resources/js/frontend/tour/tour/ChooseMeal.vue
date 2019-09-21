<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
    >
      <v-flex>
        <h2 class="text-xs-center grey--text">
          Выберите питание:
        </h2>
        <v-layout 
          v-for="meal in getActualMeal"
          :key="meal.id"
          row 
          wrap
          align-center
          mb-5
        >
          <v-flex xs12>
            <div class="text-xs-center display-2">
              {{ meal.name }}
            </div>
            <div class="text-xs-center subheading">
              {{ getCityName(meal.city_id) }},
              <i 
                class="material-icons"
                style="font-size: 12px;"
              >
                phone
              </i>
              {{ JSON.parse(meal.extra).contacts.phone }}
            </div>
          </v-flex>
          <v-layout
            row
            wrap
            justify-center
          >
            <v-flex
              v-for="item in meal.objectables"
              :key="item.id"
              xs3
              lg2
              ma-2
            >
              <v-card 
                :id="'meal-' + meal.id + '-card-' + meal.id"
                class="meal-card"
                :class="{'is-select' : item.selected}"
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
                      v-model="item.daysArray"
                      :items="days"
                      multiple
                      color="green"
                      :dark="item.selected"
                      :disabled="item.selected"
                      label="День тура"
                      outline
                      @change="calcTotalPrice(item)"
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
                    <v-layout
                      row
                      justify-content-between
                      wrap
                    >
                      <span class="grey--text text--darken-1">
                        {{ item.description }}: 
                      </span>
                      <p 
                        style="display: inline-block;"
                      >
                        {{ item.price }}
                      </p>
                    </v-layout>
                    <br>
                    <v-layout
                      v-if="item.totalPrice"
                      row
                      justify-content-between
                      wrap
                    >
                      <span class="grey--text text--darken-1">
                        Итого: 
                      </span>
                      <p 
                        style="display: inline-block;"
                      >
                        {{ item.totalPrice }}
                      </p>
                    </v-layout>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn 
                    flat
                    :dark="item.selected"
                    @click="choose(meal, item)"
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
        color="green"
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

  name: 'ChooseMeal',
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
      'getActualMeal',
      'getTour',
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
    // this.updateActualMeal()
  },
  mounted() {
  },
  methods: {
    ...mapActions([
      'updateActualMeal',
      'updateNewMealOptions',
      'updateTourMeal',
      'updateConstructorCurrentStage',
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
    calcTotalPrice(item) {
      item.day = item.daysArray.length
      console.log(item)
      item.totalPrice = item.price * item.day
    },
    choose(meal, item) {
      if (!item.day) item.totalPrice = item.price
      let updData = {
        'meal': meal,
        'item': {
          ...item,
          selected: !item.selected,
        }, 
      }
      this.updateNewMealOptions(updData)
    },
    done() {
      this.$emit('scrollme')
      this.updateTourMeal()
      this.end()
    },
    unselect(item) {
      item.selected = false
    },
    end() {
      this.updateConstructorCurrentStage('Meal is set')
    },
  }
};
</script>

<style lang="css" scoped>
.meal-card {
  background-color: #E8F5E9;
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
