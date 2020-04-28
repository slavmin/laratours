<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
    class="tc-blue-bg"
  >
    <h1 class="text-center white--text mb-5">
      <Add
        :token="token"
        :cities-select="cities"
      />
    </h1>
    <Table
      :items="items"
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
    customers: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
}
</script>

<style lang="css" scoped>
</style>
