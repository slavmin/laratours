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
        <Filters :req-params="reqParams" />
        <v-layout
          row
          wrap
          justify-center
        >
          <v-flex
            xs4
            class="text-xs-center white--text subheading"
          >
            Найдено заявок: {{ items.data.length }}
          </v-flex>
        </v-layout>
        <v-divider />
        <Table
          :token="token"
          :tour-names="tourNames"
          :tour-infos="tourInfos"
          :cities="cities"
          :agencies="agencies"
          :statuses="statuses"
        />
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import Table from './Table'
import Filters from './Filters'
import { mapActions } from 'vuex'
export default {
  name: 'OperatorOrderIndex',
  components: {
    Table,
    Filters,
  },
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      },
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
    tourInfos: {
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
    cities: {
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
    reqParams: {
      type: Object,
      default: () => {
        return []
      },
    },
  },
  mounted() {
    this.updateTours(this.items.data)
    console.log(this.cities)
  },
  methods: {
    ...mapActions(['updateTours']),
  },
}
</script>
<style lang="scss" scoped>
</style>