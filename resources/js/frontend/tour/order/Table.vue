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
