<template>
  <v-container 
    grid-list-md 
    text-xs-center
  >
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <AddEdit :cities-select="cities" />
        <Table />
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

import Table from './Table'
import AddEdit from './AddEdit'
export default {

  name: 'Index',
  components: {
    Table,
    AddEdit,
  },
  props: {
    cities: {
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

<style lang="scss" scoped>
.container {
  font-family: 'Roboto', sans-serif;
}
</style>
