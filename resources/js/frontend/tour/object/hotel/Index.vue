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
        view_list
      </v-icon>
      <!-- Отели -->
      <Add :token="token" />
    </h1>
    <Table
      :items="items"
      :token="token"
      :customers="customers"
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
    Table,
  },
  props: {
    items: {
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
