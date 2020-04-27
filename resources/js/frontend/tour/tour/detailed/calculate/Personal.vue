<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Персонал:
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
            <tr v-for="(driver, i) in drivers" :key="`driver-${i}`">
              <td class="tc-calculate-width__200">
                <div class="body-1">Водитель {{ i + 1 }}</div>
              </td>
              <td class="text-center">
                {{ $parent.getPersonalPrice('driver', i) }}
              </td>
              <td />
              <td />
              <td />
              <td />
            </tr>
            <tr v-for="(guide, i) in guides" :key="`guide-${i}`">
              <td class="tc-calculate-width__200">
                <div class="body-1">(гид) {{ guide.name }}</div>
              </td>
              <td class="text-center">
                {{ $parent.getPersonalPrice('guide', i) }}
              </td>
              <td />
              <td />
              <td />
              <td />
            </tr>
            <tr v-for="(attendant, i) in attendants" :key="`attendant-${i}`">
              <td class="tc-calculate-width__200">
                <div class="body-1">(сопр.) {{ attendant.name }}</div>
              </td>
              <td class="text-center">
                {{ $parent.getPersonalPrice('attendant', i) }}
              </td>
              <td />
              <td />
              <td />
              <td />
            </tr>
            <tr>
              <td class="tc-calculate-width__200">
                <div class="body-1">
                  Итог:
                </div>
              </td>
              <td class="text-center">
                {{ charge }}
              </td>
              <td>
                <v-text-field
                  v-model.number="$parent.personalMargin"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(personalTotal)"
                />
              </td>
              <td>
                {{ priceWithMargin }}
              </td>
              <td>
                <v-text-field
                  v-model.number="$parent.personalCommission"
                  type="number"
                  color="#aa282a"
                  class="tc-calculate__input"
                  @input="$parent.throttledSave(personalTotal)"
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
  name: 'Personal',
  props: {
    drivers: {
      type: Array,
      default: () => [],
    },
    guides: {
      type: Array,
      default: () => [],
    },
    attendants: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      margin: null,
      commission: null,
    }
  },
  computed: {
    personalTotal() {
      const result = {
        id: null,
        model_alias: 'tour-personal',
        properties: {
          margin: this.$parent.personalMargin,
          commission: this.$parent.personalCommission,
        },
      }
      return result
    },
    charge: function() {
      let result = 0
      this.drivers.forEach((driver, i) => {
        result += Number(this.$parent.getPersonalPrice('driver', i))
      })
      this.guides.forEach((guide, i) => {
        result += Number(this.$parent.getPersonalPrice('guide', i))
      })
      this.attendants.forEach((attendant, i) => {
        result += Number(this.$parent.getPersonalPrice('attendant', i))
      })
      return result
    },
    priceWithMargin: function() {
      let result = 0
      this.drivers.forEach((driver, i) => {
        result += Number(
          this.$parent.marginPersonalPrice(
            'driver',
            i,
            this.$parent.personalMargin
          )
        )
      })
      this.guides.forEach((guide, i) => {
        result += Number(
          this.$parent.marginPersonalPrice(
            'guide',
            i,
            this.$parent.personalMargin
          )
        )
      })
      this.attendants.forEach((attendant, i) => {
        result += Number(
          this.$parent.marginPersonalPrice(
            'attendant',
            i,
            this.$parent.personalMargin
          )
        )
      })
      return parseFloat(result).toFixed(2)
    },
    priceWithCommission: function() {
      let result = 0
      this.drivers.forEach((driver, i) => {
        result += Number(
          this.$parent.commissPersonalPrice(
            'driver',
            i,
            this.$parent.personalMargin,
            this.$parent.personalCommission
          )
        )
      })
      this.guides.forEach((guide, i) => {
        result += Number(
          this.$parent.commissPersonalPrice(
            'guide',
            i,
            this.$parent.personalMargin,
            this.$parent.personalCommission
          )
        )
      })
      this.attendants.forEach((attendant, i) => {
        result += Number(
          this.$parent.commissPersonalPrice(
            'attendant',
            i,
            this.$parent.personalMargin,
            this.$parent.personalCommission
          )
        )
      })
      return parseFloat(result).toFixed(2)
    },
  },
}
</script>