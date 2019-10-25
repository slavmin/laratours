<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
    style="background-color: #66a5ae;"
  >
    <h1 class="text-center white--text mb-5">
      Музеи
      <Add 
        :token="token" 
        :cities-select="cities"
      />
    </h1>
    <Table 
      :customers="customers"
      :token="token" 
      :cities="cities"
    />
  </v-container>
</template>

<script>
import Table from './Table'
import Add from './Add'
export default {

  name: 'ObjectMuseumIndex',
  components: {
    Table,
    Add,
  },
  props: {
    cities: {
      type: Object,
      default: () => {
        return {}
      }
    },
    token: {
      type: String,
      default: ''
    },
    customers: {
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
};
</script>

<style lang="css" scoped>
</style>
