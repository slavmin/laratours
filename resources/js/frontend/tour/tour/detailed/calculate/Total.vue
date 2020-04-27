<template>
  <v-row>
    <v-col cols="12">
      <v-simple-table>
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">
                Расходы
              </th>
              <th class="text-left">
                Наценка на всё, в %
              </th>
              <th class="text-left">
                Оплата оператору
              </th>
              <th class="text-left">
                Комиссия на всё, в %
              </th>
              <th class="text-left">
                Конечная стоимость
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tc-calculate-width__200">
                {{ prices.charge }}
              </td>
              <td>
                <v-text-field
                  v-model="marginForAll"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="setMarginForAll"
                />
              </td>
              <td>
                {{ prices.priceWithMargin }}
              </td>
              <td>
                <v-text-field
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                />
              </td>
              <td>
                {{ prices.priceWithCommission }}
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
  name: 'CalculateTotalTable',
  props: {
    tourData: {
      type: Object,
      default: () => {},
    },
    customerTypeId: {
      type: Number,
      default: 0,
    },
    adultTypeId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      prices: {
        charge: 0,
        priceWithMargin: 0,
        priceWithCommission: 0,
      },
      marginForAll: null,
    }
  },
  watch: {
    customerTypeId: function() {
      this.prices = this.$parent.calculatePricesForCustomerId()
    },
  },
  mounted() {
    this.prices = this.$parent.calculatePricesForCustomerId()
  },
  methods: {
    setMarginForAll() {
      const parts = [
        'transport',
        'museum',
        'hotel',
        'meal',
        'guide',
        'attendant',
        'extras',
        'freeadls',
      ]
      parts.forEach(part => {
        this.tourData[part].forEach(part => {
          if (part.hasOwnProperty('properties')) {
            part.properties.margin = this.marginForAll
          } else {
            part.margin = this.marginForAll
          }
        })
      })
    },
  },
}
</script>