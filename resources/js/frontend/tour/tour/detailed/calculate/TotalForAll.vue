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
                <th class="text-right">
                  Цена
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="customer in tourData.customers"
                :key="customer.id"
              >
                <td class="text-left">
                  {{ customer.name }}
                </td>
                <td class="text-right">
                  {{ getPriceValueByCustomerTypeId(customer.id) }}
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-col>
      <v-overlay
        :value="loader"
        style="z-index: 10000;"
      >
        <v-progress-circular
          indeterminate
          size="64"
        />
      </v-overlay>
    </v-row>
    <v-row
      class="justify-end"
      style="margin: 16px;"
    >
      <v-btn
        v-if="!saved"
        dark
        color="#aa282a"
        @click="savePrices"
      >
        Сохранить
      </v-btn>
      <v-icon
        v-if="saved"
        color="green"
      >
        check
      </v-icon>
      <v-icon
        v-if="error"
        color="red"
      >
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
        let priceWithCommission = 0
        parts.forEach(part => {
          this.tourData[part].forEach(part => {
            priceWithCommission += parseFloat(
              this.$parent.commissPrice(part, customer.id)
            )
          })
        })
        this.pricesArray.push({
          id: customer.id,
          price: priceWithCommission.toFixed(2),
        })
      })
    },
    getPriceValueByCustomerTypeId(customerTypeId) {
      const result = this.pricesArray.find(price => price.id == customerTypeId)
      if (result) {
        return result.price
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
  },
}
</script>