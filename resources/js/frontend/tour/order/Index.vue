<template>
  <v-container 
    grid-list-xs
    fluid
    style="background-color: #66a5ae;"
  >
    <v-layout 
      row 
      wrap
    >
      <NoData />
      <v-flex xs12>
        <h1 class="text-center white--text mb-5">
          <v-icon
            dark
            large
          >
            view_list
          </v-icon>
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
import NoData from '../../components/NoData'
export default {
  name: 'OperatorOrderIndex',
  components: {
    Table,
    NoData,
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
}
</script>
<style lang="scss" scoped>
  
</style>