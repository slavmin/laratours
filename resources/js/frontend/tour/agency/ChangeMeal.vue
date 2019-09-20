<template>
  <div class="body-1">
    <div 
      v-for="meal in JSON.parse(tour.extra).meal"
      :key="meal.obj.id"
    >
      <div
        v-for="day in meal.obj.daysArray"
        :key="day"
      >
        <MealForm
          :day="day"
          :meal="meal"
        />
      </div>
    </div>
  </div>
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
      let result = 0
      allMeals.forEach((meal) => {
        result += meal.obj.daysArray.length
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