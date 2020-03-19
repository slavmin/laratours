<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Персонал: Водители
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
              v-for="(driver, i) in drivers"
              :key="i"
            >
              <td class="tc-calculate-width__200">
                <div class="body-1">
                  Водитель {{ i + 1 }}
                </div>
              </td>
              <td class="text-center">
                {{ $parent.getPersonalPrice('driver', i) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="driver.margin"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.pseudoOverlay"
                />
              </td>
              <td>
                {{ $parent.marginPersonalPrice('driver', i, driver.margin) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="driver.commission"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.pseudoOverlay"
                />
              </td>
              <td>
                {{ $parent.commissPersonalPrice('driver', i, driver.margin, driver.commission) }}
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
  name: 'CalculatePersonalDriversTable',
  props: {
    drivers: {
      type: Array,
      default: () => [],
    },
  },
  methods: {},
}
</script>