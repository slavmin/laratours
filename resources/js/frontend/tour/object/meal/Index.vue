<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
    style="background-color: #66a5ae;"
  >
    <h1 class="text-center white--text mb-5">
      <v-icon
        dark
        large
      >
        fastfood
      </v-icon>
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
  },
  data() {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
</style>
