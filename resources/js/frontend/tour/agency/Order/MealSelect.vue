<template>
  <v-select
    v-model="choosenMeal"
    :items="meal"
    item-text="name"
    item-value="objId"
    return-object
    single-line
    class="body-1"
  />
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'MealSelect',
  props: {
    meal: {
      type: Array,
      default: () => {
        return []
      }
    },
    index: {
      type: Number,
      default: 0,
    },
    day: {
      type: Number,
      default: 0,
    },
    profileId: {
      type: Number,
      default: 0
    },
    lastDay: {
      type: Boolean,
      default: false,
    },
    lastMeal: {
      type: Boolean,
      default: false
    },
  },
  data() {
    return {
      choosenMeal: 0,
    }
  },
  computed: {
    ...mapGetters([
      'getMealCount',
    ]),
    resetProfileFlag: function() {
      return this.$store.getters.getResetProfileFlag(this.profileId)
    },
    isLastMeal: function() {
      return this.lastDay && this.lastMeal
    }
  },
  watch: {
    choosenMeal: function(newMeal, prevMeal) {
      console.log('choosenMeal!', prevMeal, newMeal)
      this.updateProfileMeal({
        prevMeal,
        newMeal,
        profileId: this.profileId,
        day: this.day,
        index: this.index,
      })
      this.updateOrderPrice()
    },
    resetProfileFlag: function(val) {
      if (val) {
        this.choosenMeal = this.meal.find((item) => {
          return item.default
        })
        if (this.isLastMeal) this.updateResetProfileFlag(this.profileId)
      }
    }
  },
  mounted() {
    // If profile is not empty, return choosed meal
    this.choosenMeal = this.meal.find((item) => {
      return item.manualChoose
    })
    // Else: return default meal
    if (!this.choosenMeal) {
      this.choosenMeal = this.meal.find((item) => {
        return item.default
      })
    }
  },
  methods: {
    ...mapActions([
      'updateProfileMeal',
      'updateOrderPrice',
      'updateResetProfileFlag',
    ]),
  }
}
</script>