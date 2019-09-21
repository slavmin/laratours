<template>
  <v-layout
    row
    wrap
  >
    <v-flex
      v-for="day in mealCount"
      :key="day"
    >
      <span class="subheading grey--text">
        День: {{ day }}
      </span>
      <MealForm
        :day="day"
      />
    </v-flex>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import MealForm from './MealForm'
export default {
  name: 'ChangeMeal',
  components: {
    MealForm,
  },
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
      choosenMeal: {}
    }
  },
  computed: {
    ...mapGetters([
      'getDefaultMeal',
      'getAlternativeMeal',
    ]),
    defaultMeal: function() {
      return JSON.parse(this.tour.extra).meal
    },
    meals: function() {
      let result = [{
        name: 'Без питания',
        noMeal: true,
        selected: false,
      }]
      this.getAlternativeMeal.forEach((meal) => {
        meal.objectables.forEach((obj) => {
          result.push({
            mealId: meal.id,
            objId: obj.id,
            name: `${meal.name} ${obj.name}`,
            selected: obj.selected,
          })
        })
      })
      return result
    },
    mealCount: function() {
      const allMeals = JSON.parse(this.tour.extra).meal
      let result = [1,2]
      allMeals.forEach((meal) => {
        meal.obj.daysArray.forEach(day => result.push(day))
        result = _.uniq(result)
      })
      return result
    }
  },
  mounted() {
    this.updateDefaultMeal(this.tour)
    this.updateAlternativeMeal(this.tour)
    // this.choosenMeal = this.meals.find(item => item.selected)
    // console.log(this.choosenMeal)
    // console.log(JSON.parse(this.tour.extra))
  },
  methods: {
    ...mapActions([
      'updateDefaultMeal',
      'updateAlternativeMeal',  
      'updateChoosenMeal',
    ]),
    chooseMeal() {
      this.updateChoosenMeal(this.meals.find(item => item.name == this.choosenMeal))
    },
    getMealAtDay(day) {
      const meal = JSON.parse(this.tour.extra).meal
      let result = []
      meal.forEach((item) => {
        if (item.obj.daysArray.indexOf(day) != -1) {
          result.push(item)
        }
      })
      console.log(day, result)
      return result
    }
  }
}
</script>