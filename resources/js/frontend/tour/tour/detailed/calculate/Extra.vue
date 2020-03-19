<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Допы
      </h3>
    </v-col>
    <v-col cols="12">
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                Имя
              </th>
              <th class="text-left">
                Цена
              </th>
              <th class="text-left">
                Наценка в %
              </th>
              <th class="text-left">
                Цена с наценкой
              </th>
              <th class="text-left">
                Комиссия в %
              </th>
              <th class="text-left">
                Итог
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in items"
              :key="item.name"
            >
              <td class="tc-calculate-width__200">
                <div class="body-1">
                  {{ item.name }}
                </div>
              </td>
              <td class="text-center">
                {{ $parent.getPrice(item) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="item.margin"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(item, true)"
                />
              </td>
              <td>
                {{ $parent.marginPrice(item) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="item.commission"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(item, true)"
                />
              </td>
              <td>
                {{ $parent.commissPrice(item) }}
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>
    </v-col>
  </v-row>
</template>
<script>
export default {
  name: 'CalculateExtraTable',
  props: {
    items: {
      type: Array,
      default: () => [],
    },
  },
}
</script>