<template>
  <v-layout
    row
    wrap
    justify-space-around
  >
    <v-flex
      v-for="day in mealCount"
      :key="day"
      xs4
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
    ...mapGetters([]),
    defaultMeal: function() {
      return JSON.parse(this.tour.extra).meal
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
    // this.choosenMeal = this.meals.find(item => item.selected)
    // console.log(this.choosenMeal)
    console.log(JSON.parse(this.tour.extra))
  },
  methods: {
    ...mapActions([]),
  }
}
</script>