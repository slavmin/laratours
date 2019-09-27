<template>
  <v-layout 
    row 
    wrap
    justify-center
  >
    <table>
      <thead>
        <th>
          №
        </th>
        <th>
          Имя тура
        </th>
        <th>
          Данные о туристах
        </th>
        <th>
          Стоимость
        </th>
        <th>
          Коммиссия
        </th>
        <th>
          Оператор
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
          <td class="text-xs-right">
            {{ item.total_price }}
            <br>
            <div
              v-if="item.total_paid"
              class="grey--text"
            >
              Оплачено: {{ item.total_paid }}
              <br>
            </div>
            <span class="grey--text">К оплате:</span> 
            {{ item.total_price - item.total_paid }}
          </td>
          <td>
            {{ item.commission }}
          </td>
          <td>
            {{ operators[item.operator_id] }}
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
                :href="'/agency/order/' + item.id + '/edit'"
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
                :action="'/agency/order/' + item.id"
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
  </v-layout>
</template>

<script>
import Details from './Details'
export default {
  name: 'OrderTable',
  components:{
    Details,
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    items: {
      type: Object,
      default: () => {
        return {}
      },
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
  },
  mounted() {
    console.log(this.items)
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