<template>
  <div>
    <div
      v-for="i in meal.length"
      :key="i"
    >
      <v-select
        v-model="choosenMeal"
        item-text="name"
        label="Питание"
        @change="chooseMeal"
      />
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'MealForm',
  props: {
    day: {
      type: Number,
      default: 0
    },
  },
  data() {
    return {
      choosenMeal: {}
    }
  },
  computed: {
    meal: function() {
      return this.$store.getters.getMealByDay(this.day)
    },
    alternativeMeal: function() {
      return this.$store.getters.getAlternativeMeal(this.day)
    }
    // mealOptions: function() {
    //   let result = [{
    //     name: 'Без питания',
    //     noMeal: true,
    //     selected: false,
    //     daysArray: [],
    //   }]
    //   this.getAlternativeMeal.forEach((meal) => {
    //     meal.objectables.forEach((obj) => {
    //       result.push({
    //         mealId: meal.id,
    //         objId: obj.id,
    //         name: `${meal.name} ${obj.name}`,
    //         selected: obj.selected,
    //         daysArray: obj.daysArray,
    //       })
    //     })
    //   })
    //   return result
    // }
  },
  created() {
  },
  mounted() {
    // this.choosenMeal = this.mealOptions.find((item) => {
    //   if (item.daysArray 
    //       && item.daysArray.indexOf(this.day) != -1 
    //       && item.mealId == this.meal.meal.id) {
    //     return item
    //   }
    // })
    console.log(this.meal)
  },
  methods: {
    ...mapActions([
      'updateDefaultMeal',
      'updateAlternativeMeal',
      'updateChoosenMeal',
    ]),
    chooseMeal() {
      // this.updateChoosenMeal(this.mealOptions.find(item => item.name == this.choosenMeal))
    },
  }
}
</script>