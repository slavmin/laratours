<template>
  <v-container>
    <h3 class="text-xs-center grey--text">
      Цены
    </h3>
    <v-layout 
      row 
      wrap
      justify-center
    >
      <v-flex xs6>
        <v-text-field
          id="price-name-prices"
          v-model="priceName"
          label="Название"
        />
      </v-flex>
      <v-flex xs4>
        <v-text-field
          v-model.number="priceValue"
          label="Цена"
          @keyup.enter="addPriceOnEnter"
        />
      </v-flex>
      <v-flex xs2>
        <v-btn 
          v-if="!editPriceFlag"
          dark
          small
          color="#aa282a"
          @click="addPrice"
        >
          <v-icon>
            add
          </v-icon>
        </v-btn>
        <v-btn 
          v-if="editPriceFlag"
          flat
          small
          color="green"
          @click="addEditedPrice"
        >
          <v-icon>
            check
          </v-icon>
        </v-btn>
        <v-btn 
          v-if="editPriceFlag"
          flat
          small
          color="red"
          @click="cancelEditPrice"
        >
          <v-icon>
            close
          </v-icon>
        </v-btn>
      </v-flex>
    </v-layout>
    <v-layout 
      v-if="pricesArray.length > 0"
      row 
      wrap
      justify-center
    >
      <v-flex xs11>
        <table>
          <thead>
            <th>
              Название
            </th>
            <th>
              Цена
            </th>
            <th />
          </thead>
          <tbody>
            <tr
              v-for="(price, i) in pricesArray"
              :key="i"
            >
              <td>
                {{ price.name }}
              </td>
              <td>
                {{ price.value }}
              </td>
              <td>
                <v-btn 
                  flat
                  small
                  color="yellow"
                  @click="editPrice(price)"
                >
                  <v-icon>
                    edit
                  </v-icon>
                </v-btn>
                <v-btn 
                  flat
                  small
                  color="red"
                  @click="removePrice(price)"
                >
                  <v-icon>
                    delete
                  </v-icon>
                </v-btn>
              </td>
            </tr>
          </tbody>
        </table>
      </v-flex>  
    </v-layout>
  </v-container>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'PartnerTourPrices',
  data() {
    return {
      priceName: '',
      priceValue: 0,
      pricesArray: [],
      editPriceFlag: false,
      prevPrice: {},
    }
  },
  computed: {
    ...mapGetters([
      'getEditMode',
      'getPartnerTour',
    ])
  },
  watch: {
    pricesArray: function() {
      this.getPartnerTour.prices = this.pricesArray
    }
  },
  mounted() {
    if (this.getEditMode) {
      this.pricesArray = this.getPartnerTour.prices
    }
  },
  methods: {
    clearFields() {
      this.priceName = ''
      this.priceValue = 0
    },
    addPrice() {
      this.pricesArray.push({
        name: this.priceName,
        value: this.priceValue,
      })
      this.clearFields()
    },
    addPriceOnEnter() {
      this.addPrice()
      let input = document.getElementById('price-name-prices')
      input.focus()
    },
    removePrice(price) {
      this.pricesArray = this.pricesArray.filter((item) => {
        return item != price
      })
    },
    editPrice(price) {
      this.editPriceFlag = true
      this.prevPrice = Object.assign({}, price)
      this.priceName = price.name
      this.priceValue = price.value
      this.removePrice(price)
    },
    addEditedPrice() {
      this.addPrice()
      this.editPriceFlag = false
    },
    cancelEditPrice() {
      this.priceName = this.prevPrice.name
      this.priceValue = this.prevPrice.value
      this.addPrice()
      this.editPriceFlag = false
    }
  }
}
</script>
<style lang="scss" scoped>
table {
  color: grey;
  width: 100%;
  margin: 0 auto;
  td,
  th {
    border: 1px solid lightgray;
    padding: 16px;
    font-size: 24px;
  }
}
</style>