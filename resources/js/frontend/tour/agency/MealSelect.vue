<template>
  <v-select
    v-model="choosenMeal"
    :items="meal"
    item-text="name"
    item-value="objId"
    return-object
    single-line
    class="body-1"
    @change="chooseMeal"
  />
</template>
<script>
export default {
  name: 'MealSelect',
  props: {
    meal: {
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
  mounted() {
    this.choosenMeal = this.meal.find((item) => {
      return item.default
    })
  },
  methods: {
    chooseMeal() {
      console.log(this.choosenMeal)
    }
  }
}
</script>