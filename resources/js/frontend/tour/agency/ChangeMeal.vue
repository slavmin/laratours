<template>
  <div class="body-1">
    <v-select
      v-model="choosenMeal"
      :items="meals"
      item-text="name"
      label="Питание"
      @change="chooseMeal"
    />
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'ChangeMeal',
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
  },
  mounted() {
    this.updateDefaultMeal(this.tour)
    this.updateAlternativeMeal(this.tour)
    this.choosenMeal = this.meals.find(item => item.selected)
    console.log(JSON.parse(this.tour.extra))
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
  }
}
</script>