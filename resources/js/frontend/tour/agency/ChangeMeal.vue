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
        :profile-id="profileId"
        :day="day"
        :last-day="day == mealCount.length"
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
    profileId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      choosenMeal: {}
    }
  },
  computed: {
    ...mapGetters([
      'getMealByDay',
      'getDefaultMealPriceArray',
    ]),
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
  methods: {
    ...mapActions([]),
  }
}
</script>