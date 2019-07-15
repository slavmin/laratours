<template>
  <v-container fluid>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <v-data-table
          :headers="headers"
          :items="items.data"
          class="elevation-1"
          rows-per-page-text="На странице:"
          :rows-per-page-items="[10, 20, { 'text': 'Все', 'value': -1}]"
          :pagination.sync="pagintaion"
        >
          <template v-slot:items="props">
            <td>
              {{ props.item.name }}
            </td>
            <td class="text-xs-center">
              {{ props.item.description }}
            </td>
            <td class="text-xs-right">
              <div>
                <customer-type-edit 
                  :item="props.item"
                  :token="token"
                />
                <customer-type-delete 
                  :item="props.item"
                  :token="token"
                />
              </div>
            </td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
// import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'CustomerTable',
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      }
    },
    headerEdit: {
      type: String,
      default: ''
    },
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      headers: [
        {
          text: 'Название',
          align: 'left',
          value: 'name'
        },
        {
          text: 'Описание',
          align: 'center',
          value: 'description'
        },
        {
          text: 'Действия',
          align: 'center',
          value: 'actions'
        },
      ],
      pagintaion: {
        rowsPerPage: -1 // -1 for All",
      }
    };
  },
  // computed: mapGetters(['refreshToken', 'allCustomerTypes']),
  // created() {
  //   console.log('-- Created:')
  //   console.log(this.allCustomerTypes)
  // },
  // updated() {
  //   console.log(this.allCustomerTypes)
  // },
  // async mounted() {
  //   this.fetchCustomerTypes()
  // },
  // methods: {
  //   ...mapActions(['fetchCustomerTypes'])
  // }
};
</script>

<style lang="css" scoped>
</style>
