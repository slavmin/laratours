<template>
  <div>
    <v-row>
      <v-col cols="12">
        <v-simple-table>
          <template v-slot:default>
            <thead>
              <tr>
                <th class="text-left">
                  Тип
                </th>
                <th />
                <th class="text-right">
                  Цена
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="customer in tourData.customers" :key="customer.id">
                <td class="text-left tc-calculate-width__200">
                  {{ customer.name }}
                </td>
                <td
                  class="overline grey--text text-right"
                  style="line-height: 22px;"
                >
                  Цена:
                  <br />
                  Цена с наценкой:
                  <br />
                  Итого:
                  <br />
                  <br />
                  Прибыль оператора:
                  <br />
                  Комиссия агентства:
                </td>
                <td
                  class="text-right"
                  v-html="getPriceValueByCustomerTypeId(customer.id)"
                />
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>
      <v-overlay :value="loader" style="z-index: 10000;">
        <v-progress-circular indeterminate size="64" />
      </v-overlay>
    </v-row>
    <h2 class="grey--text">
      Округление
    </h2>
    <v-row justify="center">
      <v-col>
        <v-radio-group v-model="roundPricesParameter" row>
          <v-radio label="до 100" color="#aa282a" value="100" />
          <v-radio label="до 1000" color="#aa282a" value="1000" />
        </v-radio-group>
        <v-radio-group v-model="roundPricesMinusValue" row>
          <v-radio label="не вычитать" color="#aa282a" value="0" />
          <v-radio label="минус 10" color="#aa282a" value="10" />
          <v-radio label="минус 100" color="#aa282a" value="100" />
        </v-radio-group>
      </v-col>
    </v-row>
    <v-row>
      <v-col>
        <v-btn dark small text color="#aa282a" @click="roundPrices">
          Округлить
        </v-btn>
      </v-col>
      <v-col>
        <v-btn dark small text color="#aa282a" @click="resetPrices">
          Сбросить
        </v-btn>
      </v-col>
    </v-row>
    <v-row class="justify-end" style="margin: 16px;">
      <v-btn v-if="!saved" dark color="#aa282a" @click="savePrices">
        Сохранить
      </v-btn>
      <v-icon v-if="saved" color="green">
        check
      </v-icon>
      <v-icon v-if="error" color="red">
        close
      </v-icon>
    </v-row>
  </div>
</template>
<script>
export default {
  name: 'CalculateTotalForAllTable',
  props: {
    tourData: {
      type: Object,
      default: () => {},
    },
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      pricesArray: [],
      loader: false,
      saved: false,
      error: false,
      roundPricesParameter: 0,
      roundPricesMinusValue: 0,
    }
  },
  mounted() {
    this.calculatePrices()
  },
  methods: {
    calculatePrices() {
      this.pricesArray = []
      const parts = [
        'transport',
        'museum',
        'hotel',
        'meal',
        'guide',
        'attendant',
        'extras',
      ]
      this.tourData.customers.forEach(customer => {
        let price = 0
        let priceWithMargin = 0
        let priceWithCommission = 0
        parts.forEach(part => {
          this.tourData[part].forEach(part => {
            price += parseFloat(this.$parent.getPrice(part, customer.id))
            priceWithMargin += parseFloat(
              this.$parent.marginPrice(part, customer.id)
            )
            priceWithCommission += parseFloat(
              this.$parent.commissPrice(part, customer.id)
            )
          })
        })
        const personalPrices = this.getAllPersonalPrice()
        price += parseFloat(personalPrices.price)
        priceWithMargin += parseFloat(personalPrices.priceWithMargin)
        priceWithCommission += parseFloat(personalPrices.priceWithCommission)
        this.pricesArray.push({
          id: customer.id,
          price: price.toFixed(2),
          priceWithMargin: priceWithMargin.toFixed(2),
          priceWithCommission: priceWithCommission.toFixed(2),
        })
      })
    },
    getAllPersonalPrice() {
      let price = 0
      let priceWithMargin = 0
      let priceWithCommission = 0
      this.$parent.drivers.forEach((driver, i) => {
        price += parseFloat(this.$parent.getPersonalPrice('driver', i))
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
        price += parseFloat(this.$parent.getPersonalPrice('guide', i))
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
        price += parseFloat(this.$parent.getPersonalPrice('attendant', i))
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
        price += parseFloat(this.$parent.getPersonalPrice('freeadl', i))
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
      return { price, priceWithMargin, priceWithCommission }
    },
    getPriceValueByCustomerTypeId(customerTypeId) {
      const result = this.pricesArray.find(price => price.id == customerTypeId)
      if (result) {
        return `${result.price}<br>
                ${result.priceWithMargin}<br>
                ${result.priceWithCommission}<br><br>
                ${parseFloat(result.priceWithMargin - result.price).toFixed(
                  2
                )}<br>
                ${parseFloat(
                  result.priceWithCommission - result.priceWithMargin
                ).toFixed(2)}`
      }
    },
    savePrices() {
      this.loader = true
      axios
        .post('/api/save-detailed-tour-prices', {
          tour_id: this.tourId,
          prices_array: this.pricesArray,
        })
        .then(r => {
          if (r.data == 'ok') this.showSavedIcon()
        })
        .catch(e => this.showErrorIcon())
        .finally(() => {
          this.loader = false
        })
    },
    showSavedIcon() {
      this.saved = true
      setTimeout(() => {
        this.saved = false
      }, 3000)
    },
    showErrorIcon() {
      this.error = true
      setTimeout(() => {
        this.error = false
      }, 3000)
    },
    roundPrices() {
      this.pricesArray.map(item => {
        item.price = this.roundFunction(item.price)
        item.priceWithMargin = this.roundFunction(item.priceWithMargin)
        item.priceWithCommission = this.roundFunction(item.priceWithCommission)
      })
    },
    roundFunction(price) {
      let digitsArray = parseInt(price)
        .toString()
        .split('')
      digitsArray.forEach((digit, i) => {
        digitsArray[i] = parseInt(digit)
      })
      const length = digitsArray.length
      let result = ''
      switch (this.roundPricesParameter) {
        case '100':
          // If price is 56, 64, etc. return 100
          if (digitsArray.length <= 2) {
            result = 100
            break
          }
          // If already round, ex. 12500
          if (digitsArray[length - 1] == 0 && digitsArray[length - 2] == 0) {
            return parseInt(price) - parseInt(this.roundPricesMinusValue)
          }
          // If price is 159, 122, 798
          digitsArray[length - 1] = 0
          digitsArray[length - 2] = 0
          digitsArray[length - 3] += 1
          for (let k = length - 3; k > 0; k--) {
            if (digitsArray[k] == 10) {
              digitsArray[k] = 0
              digitsArray[k - 1] += 1
            }
          }
          break
        case '1000':
          // If price is 856, 164, etc. return 1000
          if (digitsArray.length <= 3) {
            result = 1000
            break
          }
          // If already round, ex. 25000
          if (
            digitsArray[length - 1] == 0 &&
            digitsArray[length - 2] == 0 &&
            digitsArray[length - 3] == 0
          ) {
            return parseInt(price) - parseInt(this.roundPricesMinusValue)
          }
          // If price is 1159, 2122, 8798
          digitsArray[length - 1] = 0
          digitsArray[length - 2] = 0
          digitsArray[length - 3] = 0
          digitsArray[length - 4] += 1
          for (let k = length - 4; k > 0; k--) {
            if (digitsArray[k] == 10) {
              digitsArray[k] = 0
              digitsArray[k - 1] += 1
            }
          }
          break
        default:
          return parseInt(price) - parseInt(this.roundPricesMinusValue)
      }
      digitsArray.forEach(digit => {
        result += digit.toString()
      })
      return parseInt(result) - parseInt(this.roundPricesMinusValue)
    },
    resetPrices() {
      this.roundPricesParameter = 0
      this.roundPricesMinusValue = 0
      this.calculatePrices()
    },
  },
}
</script>