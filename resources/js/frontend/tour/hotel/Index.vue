<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
  >
    <h1 class="display-3 mb-5">
      Отели
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

  name: 'ObjectHotelIndex',
  components: {
    Add,
    Table
  },
  props: {
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {

    };
  },
};
</script>

<style lang="css" scoped>
</style>
