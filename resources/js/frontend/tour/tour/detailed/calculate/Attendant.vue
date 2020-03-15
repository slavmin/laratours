<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Сопровождающие
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
              <td class="tc-max-width__250">
                <div class="body-1">
                  {{ item.name }}
                </div>
                <div>
                  Дни тура: {{ item.properties.days_array }}
                </div>
              </td>
              <td class="text-center">
                <div>
                  {{ $parent.getPrice(item) }}
                </div>
                <div class="subheading grey--text">
                  {{ $parent.getPriceCustomerName(item) }}
                </div>
              </td>
              <td>
                <v-text-field
                  v-model.number="item.properties.margin"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(item)"
                />
              </td>
              <td>
                {{ $parent.marginPrice(item) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="item.properties.commission"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(item)"
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
  name: 'CalculateAttendantTable',
  props: {
    items: {
      type: Array,
      default: () => [],
    },
  },
  methods: {},
}
</script>