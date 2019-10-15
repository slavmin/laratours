<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
  >
    <h1 class="display-3 mb-5">
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
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)

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
