<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
    class="tc-blue-bg"
  >
    <v-layout
      row
      wrap
    >
      <v-flex xs12>
        <h1 class="text-center white--text mb-5">
          <AddCompany
            :token="token"
            :transport="transport"
          />
        </h1>
        <Table
          :items="items"
          :token="token"
        />
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Table from './Table'
import AddCompany from './AddCompany'
export default {
  name: 'ObjectTransportIndex',
  components: {
    Table,
    AddCompany,
  },
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      },
    },
    cities: {
      type: Object,
      default: () => {
        return {}
      },
    },
    token: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      transport: {},
    }
  },
}
</script>

<style lang="scss" scoped>
.container {
  font-family: 'Roboto', sans-serif;
}
</style>
