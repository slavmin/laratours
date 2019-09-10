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
            color="green" 
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
          <v-card-title>
            <v-layout 
              column
              wrap
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
                  id="_method" 
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
                    <v-text-field 
                      v-model="name"
                      label="Название" 
                      outline
                      color="green"
                      class="mb-3"
                    />
                    <v-text-field 
                      v-model="duration"
                      label="Продолжительность экскурсии"
                      outline
                      color="green"
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
                  </v-flex>
                </v-layout>
              </v-form>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn 
              color="green" 
              flat 
              @click="close"
            >
              Закрыть
            </v-btn>
            <!-- <v-btn 
              color="green" 
              flat 
              @click="log"
            >
              заложить
            </v-btn> -->
            <v-btn 
              color="green" 
              flat 
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
      }
    }
  },
  data() {
    return {
      dialog: false,
      customerId: 0,
      duration: 0,
      name: '',
      priceArray: [],
    };
  },
  computed: {
    attribute: function() {
      return ''
    },
    extra: function() {
      return JSON.stringify({
        duration: this.duration,
        priceList: this.getPriceList(),
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
  methods: {
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
    },
    close() {
      this.customerId = 0
      this.duration = 0
      this.name = ''
      this.priceArray = []
      this.dialog = false
    }
  },
  
};
</script>

<style lang="css" scoped>
</style>
