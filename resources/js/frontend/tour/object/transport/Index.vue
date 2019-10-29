<template>
  <v-container 
    fluid
    grid-list-md 
    text-xs-center
    style="background-color: #66a5ae;"
  >
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <h1 class="text-center white--text mb-5">
          <v-icon
            dark
            large
          >
            commute
          </v-icon>
          Транспорт
          <AddCompany
            :token="token"
            :transport="transport" 
          />
        </h1>
        <Table :token="token" />
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Vue from 'vue';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)
import Table from './Table'
import AddCompany from './AddCompany'
export default {

  name: 'ObjectTransportIndex',
  components: {
    Table,
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
      transport: {}
    };
  },
};
</script>

<style lang="scss" scoped>
.container {
  font-family: 'Roboto', sans-serif;
}
</style>
