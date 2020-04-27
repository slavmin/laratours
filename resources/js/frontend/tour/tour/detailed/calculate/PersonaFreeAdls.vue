<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Персонал: "Бесплатные взрослые"
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
            <tr v-for="(freeadl, i) in freeadls" :key="i">
              <td class="tc-calculate-width__200">
                <div class="body-1">
                  {{ freeadl.name }}
                </div>
              </td>
              <td class="text-center">
                {{ $parent.getPersonalPrice('freeadl', i) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="freeadl.margin"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(freeadl)"
                />
              </td>
              <td>
                {{ $parent.marginPersonalPrice('freeadl', i, freeadl.margin) }}
              </td>
              <td>
                <v-text-field
                  v-model.number="freeadl.commission"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(freeadl)"
                />
              </td>
              <td>
                {{
                  $parent.commissPersonalPrice(
                    'freeadl',
                    i,
                    freeadl.margin,
                    freeadl.commission
                  )
                }}
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
  name: 'CalculatePersonalFreeadlsTable',
  props: {
    freeadls: {
      type: Array,
      default: () => [],
    },
  },
  methods: {},
}
</script>