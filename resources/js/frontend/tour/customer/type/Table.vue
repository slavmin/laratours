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
          hide-actions
          class="elevation-1"
        >
          <template v-slot:items="props">
            <td>
              {{ props.item.name }}
            </td>
            <td class="text-xs-center">
              {{ props.item.description }}
            </td>
          </template>
        </v-data-table>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {

  name: 'CustomerTable',
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      }
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
      ]
    };
  },
  created() {
    
  }
};
</script>

<style lang="css" scoped>
</style>
