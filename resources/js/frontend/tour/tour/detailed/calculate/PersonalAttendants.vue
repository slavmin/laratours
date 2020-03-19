<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Персонал: Сопровождающие
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
              v-for="(attendant, i) in attendants"
              :key="i"
            >
              <td class="tc-max-width__250">
                <div class="body-1">
                  {{ attendant.name }}
                </div>
              </td>
              <td class="text-center">
                {{ $parent.getPersonalPrice('attendant', i) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="attendant.margin"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                />
              </td>
              <td>
                {{ $parent.marginPersonalPrice('attendant', i, attendant.margin) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="attendant.commission"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                />
              </td>
              <td>
                {{ $parent.commissPersonalPrice('attendant', i, attendant.margin, attendant.commission) }}
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
  name: 'CalculatePersonalAttendantTable',
  props: {
    attendants: {
      type: Array,
      default: () => [],
    },
  },
  methods: {},
}
</script>