<template>
  <v-layout column>
    <v-layout 
      row
      wrap
    >
      <v-flex
        v-for="transport in allTransports"
        :key="transport.id"
        mb-5
        xs12
        md12
        lg12
        xl6
      >
        <h3 class="display-1">
          {{ transport.name }}
        </h3>
        <div class="subheading mb-3">
          {{ getCityName(transport.city_id) }}, {{ transport.description }}
        </div>
        <AttributesTable 
          :transport-attributes="transport.objectables" 
          :company-id="transport.id"
          :token="token"
        />
      </v-flex>
    </v-layout>
  </v-layout>
</template>

<script>
import AttributesTable from './AttributesTable'
import { mapActions, mapGetters, mapMutations } from 'vuex'
export default {

  name: 'ObjectTransportTable',
  components: {
    AttributesTable
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
  computed: mapGetters([
    'allTransports', 
    'allTransportCompanies',
    'allCities'
  ]),
  mounted() {
    this.fetchTransport()
    this.fetchCities()
  },
  updated() {
  },
  methods: {
    ...mapMutations(['deleteTransport']),
    ...mapActions(['fetchTransport', 'fetchCities']),
    getTransportCompanyName(id) {
      let company = this.allTransportCompanies.find(item => item.id == id)
      return company.name
    },
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
    del(id) {
      // this.deleteTransport(id)
    }
  }
};
</script>

<style lang="css" scoped>
</style>
