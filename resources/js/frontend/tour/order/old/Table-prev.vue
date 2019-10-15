<template>
  <table>
    <thead>
      <th>
        №
      </th>
      <th>
        Имя тура
      </th>
      <th>
        Туристов
      </th>
      <th>
        Агент
      </th>
      <th>
        Статус агентства
      </th>
      <th>
        Статус оператора
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
          {{ item.id }}
        </td>
        <td>
          {{ tourNames[item.tour_id] }}
        </td>
        <td>
          Туристов: {{ touristsCount(item.profiles[0].content) }}
          <br>
          <i
            v-for="n in touristsCount(item.profiles[0].content)"
            :key="n" 
            class="material-icons body-2"
          >
            accessibility_new
          </i>
          <br>
          <Details 
            :profiles="item.profiles"
            :order-id="item.id"
          />
        </td>
        <td>
          {{ agencies[item.team_id] }}
        </td>
        <td>
          {{ item.profiles[0].content[0].orderStatus }}
        </td>
        <td>
          <span 
            :class="statuses[item.status]"
          >
            {{ statuses[item.status] }}
          </span>
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
              :action="'/operator/order/' + item.id"
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
import Details from './Details'
export default {
  name: 'OrdersTable',
  components: {
    Details,
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
      default: ''
    }
  },
  mounted() {
    console.log(this.items.data)
  },
  methods: {
    touristsCount(content) {
      let count = 0
      for (let key in content) {
        count += 1
      }
      return count
    },
  }
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
span {
  &.pending {
    display: block;
    background-color: #FDD835;
    padding: 6px;
    border-radius: 6px;
    color: white;
  }
}
</style>
