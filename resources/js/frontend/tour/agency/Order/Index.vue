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
        <v-card>
          <Table
            :items="items"
            :token="token"
            :tour-names="tourNames"
            :operators="operators"
            :statuses="statuses"
          />
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import Table from './Table'
export default {
  name: 'AgencyOrderIndex',
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
    operators: {
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