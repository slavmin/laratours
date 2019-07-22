<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
  >
    <h1 class="display-3 mb-5">
      Питание
      <Add 
        :token="token" 
      />
    </h1>
    <Table 
      :token="token" 
    />
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'
import Add from './Add'
import Table from './Table'
export default {

  name: 'ObjectMealIndex',
  components: {
    Add,
    Table
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    meal: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {

    };
  },
  created() {
    this.pushMealToStorage(this.meal.data)
  },
  methods: {
    ...mapActions(['pushMealToStorage']),
  }
};
</script>

<style lang="css" scoped>
</style>
