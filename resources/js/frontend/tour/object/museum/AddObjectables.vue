<template>
  <v-container>
    <v-layout
      row
      justify-end
    >
      <v-dialog
        v-model="dialog"
        persistent
        max-width="600px"
      >
        <template v-slot:activator="{ on }">
          <v-btn
            fab
            small
            color="#aa282a"
            :title="`Добавить экскурсию. Музей: ` + museum.name"
            dark
            v-on="on"
          >
            <i class="material-icons">
              add
            </i>
          </v-btn>
        </template>
        <v-card>
          <v-card-title style="background-color: #66a5ae;">
            <v-layout
              column
              wrap
              class="white--text"
            >
              <h3 class="mb-4">
                <i class="material-icons mr-2">
                  account_balance
                </i>
                {{ museum.name }}
              </h3>
              <h4>Добавить экскурсию:</h4>
            </v-layout>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-form
                :id="'form' + museum.id"
                ref="form"
                lazy-validation
                action="/operator/attribute"
                method="POST"
              >
                <input
                  type="hidden"
                  name="_method"
                  value="POST"
                >
                <input
                  type="hidden"
                  name="_token"
                  :value="token"
                >
                <input
                  type="hidden"
                  name="parent_model_id"
                  :value="museum.id"
                >
                <input
                  type="hidden"
                  name="parent_model_alias"
                  value="museum"
                >
                <input
                  type="hidden"
                  name="id"
                  value="0"
                >
                <input
                  type="hidden"
                  name="qnt'"
                  value="1"
                >
                <input
                  value="1"
                  type="hidden"
                  name="customer_type_id"
                >
                <input
                  v-model="name"
                  type="hidden"
                  name="name"
                >
                <input
                  v-model="extra"
                  type="hidden"
                  name="extra"
                >
                <input
                  value="0"
                  type="hidden"
                  name="price"
                >
                <v-layout
                  column
                  wrap
                >
                  <v-flex
                    xs12
                    sm6
                  >
                    <v-checkbox
                      v-model="isCustomOrder"
                      label="Заказ-наряд"
                      color="#aa282a"
                    />
                    <v-layout
                      row
                      wrap
                    >
                      <v-flex :class="isCustomOrder ? 'xs12' : 'xs8'">
                        <v-text-field
                          v-model="name"
                          label="Название"
                          outline
                          color="#aa282a"
                          class="mb-3"
                        />
                      </v-flex>
                      <v-flex
                        v-if="!isCustomOrder"
                        xs2
                      >
                        <v-layout
                          row
                          wrap
                        >
                          <v-checkbox
                            v-model="isExtra"
                            color="#aa282a"
                            label="Доп"
                          />
                          <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                              <v-icon
                                color="grey"
                                v-on="on"
                              >
                                info
                              </v-icon>
                            </template>
                            <span>
                              Можно будет выбрать в расчёте тура как
                              дополнительную экскурсию, не входящую в основную
                              стоимость.
                            </span>
                          </v-tooltip>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                    <div v-show="!isCustomOrder">
                      <v-text-field
                        v-model="duration"
                        label="Продолжительность экскурсии"
                        outline
                        color="#aa282a"
                      />
                      <h5 class="subheading grey--text">
                        Цены:
                      </h5>
                      <div class="grey--text">
                        Заполните только нужные поля. Остальные оставьте
                        пустыми.
                      </div>
                      <v-layout
                        row
                        wrap
                        justify-space-between
                      >
                        <v-flex
                          v-for="(customer, i) in customerTypes"
                          :key="customer.id"
                        >
                          <v-text-field
                            v-model="priceArray[i]"
                            :label="customer.name"
                            outline
                            mask="#####"
                          />
                        </v-flex>
                      </v-layout>
                    </div>
                    <div v-show="isCustomOrder">
                      <v-layout
                        row
                        wrap
                        justify-space-between
                      >
                        <v-flex>
                          <v-text-field
                            v-model="customOrder.count"
                            label="Кол-во человек"
                            outline
                            mask="#####"
                          />
                        </v-flex>
                        <v-flex>
                          <v-text-field
                            v-model="customOrder.price"
                            label="Цена"
                            outline
                            mask="#####"
                          />
                        </v-flex>
                        <v-flex>
                          <v-text-field
                            v-model="customOrder.about"
                            label="Описание"
                            outline
                            color="#aa282a"
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
            <v-btn
              color="#aa282a"
              dark
              @click="close"
            >
              Закрыть
            </v-btn>
            <v-btn
              color="#aa282a"
              dark
              type="submit"
              :form="'form' + museum.id"
            >
              Сохранить
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  name: 'AddObjectables',
  props: {
    museum: {
      type: Object,
      required: true,
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
  },
  data() {
    return {
      dialog: false,
      customerId: 0,
      duration: 0,
      name: '',
      priceArray: [],
      isCustomOrder: false,
      customOrder: {
        about: '',
        count: NaN,
        price: NaN,
      },
      isExtra: false,
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
        priceList: this.getPriceList(),
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
  },
  methods: {
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
    close() {
      this.customerId = 0
      this.duration = 0
      this.name = ''
      this.priceArray = []
      this.dialog = false
    },
  },
}
</script>

<style lang="css" scoped>
</style>
