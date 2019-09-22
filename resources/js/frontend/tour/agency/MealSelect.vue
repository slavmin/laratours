<template>
  <v-select
    v-model="choosenMeal"
    :items="mealOptions"
    item-text="name"
    item-value="objId"
    return-object
    single-line
    @change="chooseMeal"
  />
</template>
<script>
export default {
  name: 'MealSelect',
  props: {
    mealOptions: {
      type: Array,
      default: () => {
        return []
      }
    },
  },
  data() {
    return {
      choosenMeal: 0,
    }
  },
  methods: {
    chooseMeal() {
      console.log(this.choosenMeal)
    }
  }
}
</script>