<template>
  <div>
    <div
      v-for="i in mealCount"
      :key="i"
    >
      <MealSelect
        :meal-options="mealOptions"
      />
      <!-- <v-select
        v-model="choosenMeal"
        :items="mealOptions"
        item-text="name"
        item-value="objId"
        return-object
        single-line
        @change="chooseMeal"
      /> -->
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import MealSelect from './MealSelect'
export default {
  name: 'MealForm',
  components: {
    MealSelect,
  },
  props: {
    day: {
      type: Number,
      default: 0
    },
  },
  data() {
    return {
      // choosenMeal: []
    }
  },
  computed: {
    mealCount: function() {
      return this.$store.getters.getMealByDayCount(this.day)
    },
    mealOptions: function() {
      return this.$store.getters.getMealByDay(this.day)
    },
    choosenMeal: {
      get: function() {
        let result = 0
        for (let i = 0; i < this.mealCount; i++) {
          this.mealOptions.find((item) => {
            if (item.daysArray 
                && item.daysArray.indexOf(this.day) != -1
                && item.selected == true) {
              console.log(item)
              result = item.objId
            }
          })
        }
        return result
      },
      set: function(newValue) {
        console.log(newValue)
      }
    }
  },
  created() {
  },
  mounted() {
    // for (let i = 0; i < this.mealCount; i++) {
    //   this.mealOptions.find((item) => {
    //     if (item.daysArray 
    //         && item.daysArray.indexOf(this.day) != -1
    //         && item.selected == true) {
    //       console.log(item)
    //       this.choosenMeal = item.objId
    //     }
    //   })
    // }
    console.log(this.choosenMeal)
    console.log(this.mealOptions)
  },
  methods: {
    ...mapActions([
      'updateDefaultMeal',
      'updateAlternativeMeal',
      'updateChoosenMeal',
    ]),
    chooseMeal() {
      console.log(this.choosenMeal)
      // this.updateChoosenMeal(this.mealOptions.find(item => item.name == this.choosenMeal))
    },
  }
}
</script>