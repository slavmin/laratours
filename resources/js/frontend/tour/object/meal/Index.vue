<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
    class="tc-blue-bg"
  >
    <h1 class="text-center white--text mb-5">
      <Add :token="token" />
    </h1>
    <Table
      :items="items"
      :token="token"
    />
  </v-container>
</template>

<script>
import Add from './Add'
import Table from './Table'
export default {
  name: 'ObjectMealIndex',
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
  },
  data() {
    return {}
  },
}
</script>

<style lang="css" scoped>
</style>
