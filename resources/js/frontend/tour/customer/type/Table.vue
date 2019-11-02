<template>
  <v-container fluid>
    <h1 class="text-center mb-5">
      <v-icon
        large
      >
        view_list
      </v-icon>
      Типы туристов
    </h1>
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
              {{ getDescription(props.item.description) }}
            </td>
            <td class="text-xs-right">
              <v-layout 
                row 
                wrap
                justify-end
              >
                <customer-type-edit 
                  :item="props.item"
                  :token="token"
                />
                <customer-type-delete 
                  :item="props.item"
                  :token="token"
                />
              </v-layout>
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
          text: 'Возраст',
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
  methods: {
    getDescription(item) {
      const data = JSON.parse(item)
      if (data) {
        if (!data.isPens){
          return data.ageFrom 
                  ? `от ${data.ageFrom} до ${data.ageTo}` 
                  : `до ${data.ageTo}` 
        }
        if (data.isPens) {
          return `Мужчины от ${data.agePensMale}, женщины от ${data.agePensFemale}`
        }
      }
    }
  },
};
</script>

<style lang="css" scoped>
</style>
