<template>
  <v-row>
    <v-col>
      <v-card>
        <v-toolbar
          dark
          color="#94CED7"
        >
          <h2>
            Допы
          </h2>
        </v-toolbar>
        <v-form
          ref="priceForm"
          v-model="valid"
          lazy-validation
        >
          <v-row
            justify="center"
            align="center"
          >
            <v-col cols="6">
              <v-text-field
                id="price-name-extras"
                v-model="priceName"
                color="#aa282a"
                :rules="priceNameRules"
                label="Название"
                required
              />
            </v-col>
            <v-col cols="4">
              <v-text-field
                v-model.number="priceValue"
                color="#aa282a"
                label="Цена"
                :rules="priceRules"
                required
                @keyup.enter="addPriceOnEnter"
              />
            </v-col>
            <v-col cols="1">
              <v-btn
                v-if="!editPriceFlag"
                :disabled="!valid"
                dark
                icon
                color="#aa282a"
                @click="addPrice"
              >
                <v-icon>
                  add
                </v-icon>
              </v-btn>
              <v-btn
                v-if="editPriceFlag"
                icon
                small
                color="green"
                @click="editPriceQuery"
              >
                <v-icon>
                  check
                </v-icon>
              </v-btn>
              <v-btn
                v-if="editPriceFlag"
                icon
                small
                color="red"
                @click="cancelEditPrice"
              >
                <v-icon>
                  restore
                </v-icon>
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
        <v-row
          v-if="pricesArray.length > 0"
          justify="center"
        >
          <v-col cols="11">
            <v-simple-table dense>
              <template v-slot:default>
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
                    v-for="price in pricesArray"
                    :key="price.id"
                    :class="price.id == editPriceId ? 'price-in-edit' : ''"
                  >
                    <td>
                      {{ price.name }}
                    </td>
                    <td>
                      {{ price.price }}
                    </td>
                    <td>
                      <v-row
                        v-if="!(price.id == editPriceId)"
                        justify="end"
                      >
                        <v-btn
                          icon
                          small
                          color="yellow"
                          @click="editPrice(price)"
                        >
                          <v-icon>
                            edit
                          </v-icon>
                        </v-btn>
                        <v-btn
                          icon
                          small
                          color="red"
                          @click="removePrice(price.id)"
                        >
                          <v-icon>
                            delete
                          </v-icon>
                        </v-btn>
                      </v-row>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
          </v-col>
        </v-row>
      </v-card>
    </v-col>
    <v-overlay :value="loading">
      <v-progress-circular
        indeterminate
        size="64"
      />
    </v-overlay>
  </v-row>
</template>
<script>
export default {
  name: 'PartnerTourExtras',
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      priceName: '',
      priceValue: 0,
      pricesArray: [],
      editPriceFlag: false,
      editPriceId: NaN,
      prevPrice: {},
      priceNameRules: [v => !!v || 'Введите название'],
      priceRules: [v => !!v || 'Введите цену'],
      valid: false,
      loading: false,
    }
  },
  mounted() {
    this.fetchPrices()
  },
  methods: {
    clearFields() {
      this.priceName = ''
      this.priceValue = 0
      this.editPriceId = null
    },
    addPrice() {
      if (this.$refs.priceForm.validate()) {
        this.snackbar = true
        axios
          .post('/api/create-partner-tour-price', {
            tour_id: this.tourId,
            price_name: this.priceName,
            price_value: this.priceValue,
            is_extra: true,
          })
          .then(response => {
            this.fetchPrices()
            this.clearFields()
          })
          .catch(e => console.log(e))
      }
    },
    fetchPrices() {
      this.loading = true
      axios
        .get('/api/get-partner-tour-prices', {
          params: {
            tour_id: this.tourId,
            is_extra: true,
          },
        })
        .then(r => {
          this.pricesArray = r.data
        })
        .finally(() => (this.loading = false))
    },
    addPriceOnEnter() {
      this.addPrice()
      let input = document.getElementById('price-name-extras')
      input.focus()
    },
    removePrice(priceId) {
      axios
        .post('/api/delete-partner-tour-price', {
          price_id: priceId,
        })
        .then(response => {
          // console.log(response)
          this.fetchPrices()
          // this.clearFields()
        })
        .catch(e => console.log(e))
    },
    editPrice(price) {
      this.editPriceFlag = true
      this.editPriceId = price.id
      this.priceName = price.name
      this.priceValue = price.price
    },
    editPriceQuery() {
      this.loading = true
      axios
        .post('/api/edit-partner-tour-price', {
          price_id: this.editPriceId,
          price_name: this.priceName,
          price_value: this.priceValue,
        })
        .then(response => {
          this.editPriceFlag = false
          this.fetchPrices()
          this.clearFields()
        })
        .catch(e => console.log(e))
    },
    cancelEditPrice() {
      this.priceName = ''
      this.priceValue = 0
      this.editPriceFlag = false
      this.editPriceId = null
    },
    reset() {
      this.$refs.priceForm.reset()
    },
  },
}
</script>

<style lang="scss" scoped>
.price-in-edit {
  background-color: #b1e6ba;
  color: #263b7a;
}
</style>