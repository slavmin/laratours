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
              <td>
                {{ charge }}
              </td>
              <td>
                <v-text-field
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                />
              </td>
              <td>
                {{ priceWithMargin }}
              </td>
              <td>
                <v-text-field
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                />
              </td>
              <td>
                {{ priceWithCommission }}
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
      charge: 0,
      priceWithMargin: 0,
      priceWithCommission: 0,
    }
  },
  watch: {
    customerTypeId: function() {
      this.calculatePrices()
    },
  },
  mounted() {
    this.calculatePrices()
  },
  methods: {
    calculatePrices() {
      let charge = 0
      let priceWithMargin = 0
      let priceWithCommission = 0
      const parts = [
        'transport',
        'museum',
        'hotel',
        'meal',
        'guide',
        'attendant',
        'extras',
      ]
      parts.forEach(part => {
        this.tourData[part].forEach(part => {
          charge += parseFloat(this.$parent.getPrice(part))
          priceWithMargin += parseFloat(this.$parent.marginPrice(part))
          priceWithCommission += parseFloat(this.$parent.commissPrice(part))
        })
      })
      this.charge = charge.toFixed(2)
      this.priceWithMargin = priceWithMargin.toFixed(2)
      this.priceWithCommission = priceWithCommission.toFixed(2)
    },
  },
}
</script>