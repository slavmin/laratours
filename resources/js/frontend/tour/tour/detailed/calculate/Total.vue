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
                {{ charge }}
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
      marginForAll: null,
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
      this.$parent.drivers.forEach((driver, i) => {
        charge += parseFloat(this.$parent.getPersonalPrice('driver', i))
        priceWithMargin += parseFloat(
          this.$parent.marginPersonalPrice('driver', i, driver.margin)
        )
        priceWithCommission += parseFloat(
          this.$parent.commissPersonalPrice(
            'driver',
            i,
            driver.margin,
            driver.commission
          )
        )
      })
      this.$parent.personalGuides.forEach((guide, i) => {
        charge += parseFloat(this.$parent.getPersonalPrice('guide', i))
        priceWithMargin += parseFloat(
          this.$parent.marginPersonalPrice('guide', i, guide.margin)
        )
        priceWithCommission += parseFloat(
          this.$parent.commissPersonalPrice(
            'guide',
            i,
            guide.margin,
            guide.commission
          )
        )
      })
      this.$parent.personalAttendants.forEach((attendant, i) => {
        charge += parseFloat(this.$parent.getPersonalPrice('attendant', i))
        priceWithMargin += parseFloat(
          this.$parent.marginPersonalPrice('attendant', i, attendant.margin)
        )
        priceWithCommission += parseFloat(
          this.$parent.commissPersonalPrice(
            'attendant',
            i,
            attendant.margin,
            attendant.commission
          )
        )
      })
      this.$parent.personalFreeAdls.forEach((freeadl, i) => {
        charge += parseFloat(this.$parent.getPersonalPrice('freeadl', i))
        priceWithMargin += parseFloat(
          this.$parent.marginPersonalPrice('freeadl', i, freeadl.margin)
        )
        priceWithCommission += parseFloat(
          this.$parent.commissPersonalPrice(
            'freeadl',
            i,
            freeadl.margin,
            freeadl.commission
          )
        )
      })
      this.charge = charge.toFixed(2)
      this.priceWithMargin = priceWithMargin.toFixed(2)
      this.priceWithCommission = priceWithCommission.toFixed(2)
    },
    setMarginForAll() {
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