<template>
  <div>
    <div>
      <div
        v-for="(meal, i) in mealByDay"
        :key="`${day} ${i}`"
      >
        <MealSelect
          :meal="meal"
        />
      </div>
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
    mealByDay: function() {
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
  },
  methods: {
    ...mapActions([]),
    chooseMeal() {
      console.log(this.choosenMeal)
      // this.updateChoosenMeal(this.mealOptions.find(item => item.name == this.choosenMeal))
    },
  }
}
</script>