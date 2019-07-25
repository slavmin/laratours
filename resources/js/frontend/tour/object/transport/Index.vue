<template>
  <v-container 
    fluid
    grid-list-md 
    text-xs-center
  >
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <h1 class="mb-5">
          Транспорт
          <AddCompany
            :token="token"
            :transport="transport" 
          />
          <AddEdit 
            :token="token"
            :cities-select="cities" 
          />
        </h1>
        <Table :token="token" />
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
import AddCompany from './AddCompany'
export default {

  name: 'ObjectTransportIndex',
  components: {
    Table,
    AddEdit,
    AddCompany,
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
    }
  },

  data() {
    return {
      transport: {
        name: '',
        city_id: 0,

      }
    };
  },
};
</script>

<style lang="scss" scoped>
.container {
  font-family: 'Roboto', sans-serif;
}
</style>
