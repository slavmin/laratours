<template>
  <v-dialog 
    v-model="dialog" 
    lazy
    max-width="600px"
  >
    <template v-slot:activator="{ on }">
      <v-btn 
        fab
        small
        outline
        color="green"
        :title="`Редактировать экскурсию: ` + event.name"
        dark 
        v-on="on"
      >
        <i class="material-icons">
          edit
        </i>
      </v-btn>
    </template>
    <v-card>
      <v-card-title
        style="background-color: #66a5ae;"
      >
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
          <h4>
            Редактирование экскурсии:
            <br>
            {{ event.name }}
          </h4>
        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-container grid-list-md>
          <v-form 
            :id="'form' + museum.id + event.id"
            ref="form"
            lazy-validation
            :action="'/operator/attribute/' + event.id"
            method="POST"
          >
            <input 
              type="hidden" 
              name="_method" 
              value="PATCH"
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
              v-model="event.id"
              type="hidden" 
              name="id"
            > 
            <input 
              type="hidden" 
              name="qnt" 
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
                <v-text-field 
                  v-model="name"
                  label="Название" 
                  outline
                  color="#aa282a"
                  class="mb-3"
                />
                <div
                  v-show="!isCustomOrder"
                >
                  <v-text-field 
                    v-model="duration"
                    label="Продолжительность экскурсии" 
                    mask="##"
                    outline
                    color="#aa282a"
                  />
                  <h5 class="subheading grey--text">
                    Цены:
                  </h5>
                  <div class="grey--text">
                    Заполните только нужные поля. Остальные оставьте пустыми.
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
                <div
                  v-show="isCustomOrder"
                >
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
          :form="'form' + museum.id + event.id"
        >
          Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {

  name: 'EditObjectables',
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
      }
    },
    event: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {
      dialog: false,
      prevEvent: {},
      duration: 0,
      customerId: 0,
      name: '',
      price: 0,
      priceArray: [],
      isCustomOrder: false,
      customOrder: {
        about: '',
        count: NaN,
        price: NaN,
      }
    };
  },
  computed: {
    attribute: function() {
      return 'attribute[' + this.event.id + ']'
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
        duration: this.duration,
        priceList: this.getPriceList()
      })
    },
    customerTypes: function() {
      let result = []
      Object.keys(this.customers).map((key) => {
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
  mounted() {
    this.parseInfo()
  },
  methods: {
    parseInfo() {
      if (!JSON.parse(this.event.extra).isCustomOrder) {
        this.name = this.event.name
        this.price = this.event.price
        this.duration = JSON.parse(this.event.extra).duration
        this.customerId = JSON.parse(this.event.extra).customer
        if (JSON.parse(this.event.extra).priceList) {
          JSON.parse(this.event.extra).priceList.forEach((price, i) => {
            this.priceArray[i] = price.price
          })
        }
      } else {
        this.isCustomOrder = true
        this.name = this.event.name
        this.customOrder = JSON.parse(this.event.extra)
      }
    },
    close() {
      this.parseInfo()
      this.dialog = false
    },
    getPriceList() {
      let result = []
      this.customerTypes.forEach((customer) => {
        if (this.priceArray[customer.id]) {
          result.push({
            customerId: customer.id,
            customerName: customer.name,
            customerAge: customer.description,
            price: parseInt(this.priceArray[customer.id])
          })
        }
      })
      return result
    }
  }
};
</script>

<style lang="css" scoped>
</style>
