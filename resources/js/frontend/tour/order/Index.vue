<template>
  <v-container 
    grid-list-xs
    fluid  
  >
    <v-layout 
      row 
      wrap
      justify-center
    >
      <Table 
        :items="items"
        :agencies="agencies"
        :statuses="statuses"
        :tour-names="tourNames"
        :token="token"
      />
    </v-layout>
  </v-container>
</template>

<script>
import Table from './Table'
export default {
  name: 'OrdersIndex',
  components: {
    Table,
  },
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      }
    },
    agencies: {
      type: Object,
      default: () => {
        return {}
      }
    },
    statuses: {
      type: Array,
      default: () => {
        return []
      }
    },
    tourNames: {
      type: Object,
      default: () => {
        return []
      }
    },
    token: {
      type: String,
      default: '',
    },
  },
  mounted() {
    console.log(this.items)
  }
}
</script>

<style lang="scss" scoped>

</style>
