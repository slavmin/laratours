<template>
  <v-container 
    grid-list-xs
    fluid
  >
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <h1 class="text-center grey--text mb-5">
          {{ header }}
        </h1>
        <Table
          :items="items"
          :token="token"
          :tour-names="tourNames"
          :agencies="agencies"
          :statuses="statuses"
        />
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import Table from './Table'
export default {
  name: 'OperatorOrderIndex',
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
    header: {
      type: String,
      default: '',
    },
    token: {
      type: String,
      default: '',
    },
    tourNames: {
      type: Object,
      default: () => {
        return {}
      },
    },
    agencies: {
      type: Object,
      default: () => {
        return {}
      },
    },
    statuses: {
      type: Array,
      default: () => {
        return []
      },
    },
    statusesList: {
      type: Array,
      default: () => {
        return []
      },
    },
  },
  data() {
    return {
    }
  },
  mounted() {
    console.log(this.statusesList)
  }
}
</script>
<style lang="scss" scoped>
  
</style>