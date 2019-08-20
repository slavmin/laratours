<template>
  <table>
    <thead>
      <th>
        Статус
      </th>
      <th>
        Агент
      </th>
      <th>
        Имя тура
      </th>
      <th>
        Действия
      </th>
    </thead>
    <tbody>
      <tr
        v-for="item in items.data"
        :key="item.id"
      >
        <td>
          {{ statuses[item.status] }}
        </td>
        <td>
          {{ agencies[item.team_id] }}
        </td>
        <td>
          {{ tourNames[item.tour_id] }}
        </td>
        <td>
          <v-layout 
            row 
            wrap
          >
            <v-btn
              :href="'/operator/order/' + item.id + '/edit'"
              color="green"
              dark
              small
              fab
              flat
              outline
            >
              <i class="material-icons">
                edit
              </i>
            </v-btn>
            <form 
              action="/operator/attribute/"
              method="POST"
            >
              <input 
                id="_method" 
                type="hidden" 
                name="_method" 
                value="DELETE"
              >
              <input 
                type="hidden" 
                name="_token" 
                :value="token"
              > 
              <!-- <input 
                type="hidden" 
                name="parent_model_id" 
                :value="meal.id"
              >
              <input 
                type="hidden" 
                name="parent_model_alias" 
                value="meal"
              >   -->
              <v-btn 
                fab
                small
                outline
                color="red"
                type="submit"
              >
                <i class="material-icons">
                  delete
                </i>
              </v-btn>
            </form>
          </v-layout>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: 'OrdersTable',
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
      default: ''
    }
  },
  mounted() {
    console.log(this.items.data)
  },
}
</script>

<style lang="scss" scoped>
table {
  td,
  th {
    border: 1px solid gray;
    font-size: 16px;
    padding: 12px;
  }
}
</style>
