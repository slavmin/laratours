<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Персонал: Гиды
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
              v-for="(guide, i) in guides"
              :key="i"
            >
              <td class="tc-calculate-width__200">
                <div class="body-1">
                  {{ guide.name }}
                </div>
              </td>
              <td class="text-center">
                {{ $parent.getPersonalPrice('guide', i) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="guide.margin"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                />
              </td>
              <td>
                {{ $parent.marginPersonalPrice('guide', i, guide.margin) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="guide.commission"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                />
              </td>
              <td>
                {{ $parent.commissPersonalPrice('guide', i, guide.margin, guide.commission) }}
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
  name: 'CalculatePersonalGuidesTable',
  props: {
    guides: {
      type: Array,
      default: () => [],
    },
  },
  methods: {},
}
</script>