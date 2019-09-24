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
  },
  data() {
    return {
      choosenMeal: 0,
    }
  },
  watch: {
    choosenMeal: function(newMeal, prevMeal) {
      this.updateProfileMeal({
        prevMeal,
        newMeal,
        profileId: this.profileId,
        day: this.day,
        index: this.index,
      })
    }
  },
  mounted() {
    this.choosenMeal = this.meal.find((item) => {
      return item.default
    })
  },
  methods: {
    ...mapActions([
      'updateProfileMeal',
    ]),
    chooseMeal() {
      console.log(this.choosenMeal)
    }
  }
}
</script>