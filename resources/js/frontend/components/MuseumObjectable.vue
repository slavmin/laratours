<template>
  <v-card>
    <v-card-text>
      <v-container grid-list-md>
        <v-form
          :id="'form' + tourObject.id"
          ref="form"
          lazy-validation
          :action="
            editMode
              ? `/operator/attribute/${objectAttribute.id}`
              : '/operator/attribute'
          "
          method="POST"
        >
          <input v-if="editMode" type="hidden" name="_method" value="PATCH" />
          <input type="hidden" name="_token" :value="token" />
          <input type="hidden" name="parent_model_id" :value="tourObject.id" />
          <input type="hidden" name="parent_model_alias" value="museum" />
          <input type="hidden" name="id" value="0" />
          <input v-model="name" type="hidden" name="name" />
          <input v-model="description" type="hidden" name="description" />
          <input v-model="extra" type="hidden" name="extra" />
          <div v-if="prices.length > 0">
            <input
              v-for="(price, k) in prices"
              :key="`price-${k}`"
              type="hidden"
              name="prices[]"
              :value="price"
            />
          </div>
          <v-layout column wrap>
            <v-flex xs12 sm6>
              <v-checkbox
                v-model="isCustomOrder"
                label="Заказ-наряд"
                color="#aa282a"
              />
              <v-layout row wrap>
                <v-flex :class="isCustomOrder ? 'xs12' : 'xs8'">
                  <v-text-field
                    v-model="name"
                    label="Название"
                    outline
                    color="#aa282a"
                    class="mb-3"
                  />
                </v-flex>
                <v-flex v-if="!isCustomOrder" xs2>
                  <v-layout row wrap>
                    <v-checkbox v-model="isExtra" color="#aa282a" label="Доп" />
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on }">
                        <v-icon color="grey" v-on="on">
                          info
                        </v-icon>
                      </template>
                      <span>
                        Можно будет выбрать в расчёте тура как дополнительную
                        экскурсию, не входящую в основную стоимость.
                      </span>
                    </v-tooltip>
                  </v-layout>
                </v-flex>
              </v-layout>
              <v-layout>
                <v-flex>
                  <v-textarea
                    v-model="description"
                    label="Описание"
                    rows="1"
                    color="#aa282a"
                    class="mb-3"
                  />
                </v-flex>
              </v-layout>
              <div v-show="!isCustomOrder">
                <v-text-field
                  v-model="duration"
                  label="Продолжительность экскурсии"
                  outline
                  color="#aa282a"
                />
                <v-divider />
              </div>
              <div v-show="isCustomOrder">
                <v-layout row wrap justify-space-between>
                  <v-flex>
                    <v-text-field
                      v-model="customOrder.count"
                      label="Кол-во человек"
                      outline
                      mask="#####"
                    />
                  </v-flex>
                </v-layout>
              </div>
            </v-flex>
          </v-layout>
        </v-form>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn color="#aa282a" dark type="submit" :form="'form' + tourObject.id">
        Сохранить
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  name: 'MuseumObjectable',
  props: {
    tourObject: {
      type: Object,
      required: true,
      default: null,
    },
    objectAttribute: {
      type: Object,
      default: null,
    },
    token: {
      type: String,
      required: true,
      default: null,
    },
    customers: {
      type: Object,
      default: () => {
        return {}
      },
    },
    editMode: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      dialog: false,
      customerId: 0,
      duration: 0,
      name: '',
      description: '',
      priceArray: [],
      isCustomOrder: false,
      customOrder: {
        about: '',
        count: 0,
        price: 0,
      },
      isExtra: false,
      showDateStart: false,
      dateStart: '',
      showDateEnd: false,
      dateEnd: '',
    }
  },
  computed: {
    attribute: function() {
      return ''
    },
    extra: function() {
      if (this.isCustomOrder) {
        let customOrderData = JSON.stringify({
          isCustomOrder: this.isCustomOrder,
          ...this.customOrder,
        })
        return customOrderData
      }
      return JSON.stringify({
        isExtra: this.isExtra,
        duration: this.duration,
        // priceList: this.getPriceList(),
      })
    },
    customerTypes: function() {
      let result = []
      Object.keys(this.customers).map(key => {
        if (key != '') {
          result.push({
            id: key,
            name: this.customers[key].name,
            description: this.customers[key].description,
          })
        }
      })
      return result
    },
    prices: function() {
      let result = []
      this.priceArray.forEach((price, i) => {
        if (price != 0) {
          result.push(
            JSON.stringify({
              period_start: this.dateStart,
              period_end: this.dateEnd,
              price: price,
              tour_customer_type_id: this.customers[i].id,
            })
          )
        }
      })
      return result
    },
  },
  mounted() {
    if (this.editMode) this.parseInfo()
  },
  methods: {
    parseInfo() {
      if (!JSON.parse(this.objectAttribute.extra).isCustomOrder) {
        this.name = this.objectAttribute.name
        this.description = this.objectAttribute.description
        this.price = this.objectAttribute.price
        this.isExtra = JSON.parse(this.objectAttribute.extra).isExtra
        this.duration = JSON.parse(this.objectAttribute.extra).duration
        this.customerId = JSON.parse(this.objectAttribute.extra).customer
        if (JSON.parse(this.objectAttribute.extra).priceList) {
          this.customerTypes.forEach((customerType, i) => {
            const value = JSON.parse(this.objectAttribute.extra).priceList.find(
              price => {
                return customerType.id == price.customerId
              }
            )
            this.priceArray[i] = value ? value.price : 0
          })
        }
      } else {
        this.isCustomOrder = true
        this.name = this.objectAttribute.name
        this.description = this.objectAttribute.description
        this.customOrder = JSON.parse(this.objectAttribute.extra)
      }
    },
    close() {
      if (this.editMode) {
        this.parseInfo()
        this.dialog = false
      }
      if (!this.editMode) {
        this.customerId = 0
        this.duration = 0
        this.name = ''
        this.priceArray = []
        this.dialog = false
      }
    },
    getPriceList() {
      let result = []
      this.customerTypes.forEach(customer => {
        if (this.priceArray[customer.id]) {
          result.push({
            customerId: customer.id,
            customerName: customer.name,
            customerAge: customer.description,
            price: parseInt(this.priceArray[customer.id]),
          })
        }
      })
      return result
    },
    test() {
      console.log(
        this.priceArray,
        this.customers,
        this.customerTypes,
        this.prices
      )
    },
  },
}
</script>
