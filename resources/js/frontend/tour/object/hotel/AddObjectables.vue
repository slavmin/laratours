<template>
  <v-container>
    <v-layout 
      row 
      justify-end
    >
      <v-dialog 
        v-model="dialog" 
        max-width="600px"
      >
        <template v-slot:activator="{ on }">
          <v-btn 
            fab
            small
            color="green" 
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
                  hotel
                </i>
                {{ hotel.name }}
              </h3>  
              <h4>Добавить номер:</h4>
            </v-layout>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-form 
                :id="'form' + hotel.id"
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
                  :value="hotel.id"
                >
                <input 
                  type="hidden" 
                  name="parent_model_alias" 
                  value="hotel"
                >  
                <input  
                  type="hidden" 
                  name="id" 
                  value="0"
                > 
                <input 
                  value="1"
                  type="hidden" 
                  name="customer_type_id" 
                >
                <input 
                  value="0"
                  type="hidden" 
                  name="price" 
                >
                <input 
                  v-model="extra"
                  type="hidden" 
                  name="extra" 
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
                      name="name" 
                      label="Название" 
                      outline
                      color="green"
                    />
                    <v-text-field 
                      v-model="qnt"
                      name="qnt"
                      label="Количество номеров" 
                      mask="#####"
                      outline
                      color="green"
                      required
                    />
                    <v-layout 
                      row 
                      wrap
                    >
                      <v-flex>
                        <v-text-field 
                          v-model="priceList.standard"
                          label="Цена стандартного размещения" 
                          mask="#####"
                          outline
                          color="green"
                          required
                        />
                      </v-flex>
                      <v-flex>
                        <v-text-field
                          v-model="priceList.single" 
                          label="Цена single размещения" 
                          mask="#####"
                          outline
                          color="green"
                          required
                        />
                      </v-flex>
                    </v-layout>
                    <v-divider />
                    <h5 class="subheading grey--text text-xs-center mb-2">
                      Дополнительные места: {{ additionalCount }}
                      <i 
                        class="material-icons green--text"
                        style="font-size: 16px; cursor: pointer;"
                        @click="incrementAdditional" 
                      >
                        add_circle
                      </i>
                      <i 
                        class="material-icons red--text"
                        style="font-size: 16px; cursor: pointer;" 
                        @click="decrementAdditional" 
                      >
                        remove_circle
                      </i>
                    </h5> 
                    <div
                      v-for="i in additionalCount"
                      :key="i"
                    >
                      <h6 class="grey--text text-xs-center">
                        Доп. место {{ i }}
                      </h6>
                      <v-layout 
                        row 
                        wrap
                      >
                        <v-flex>
                          <v-text-field 
                            v-model="additionalPrices[i - 1][0].price"
                            label="Ребёнок" 
                            mask="#####"
                            outline
                            color="green"
                            required
                          />
                        </v-flex>
                        <v-flex>
                          <v-text-field 
                            v-model="additionalPrices[i - 1][1].price"
                            label="Взрослый" 
                            mask="#####"
                            outline
                            color="green"
                            required
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
              :form="'form' + hotel.id"
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
    hotel: {
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
      name: '',
      qnt: 0,
      roomTypes: [
        { count: 1, name: 'Одноместный номер' },
        { count: 2, name: 'Двухместный номер' },
        { count: 3, name: 'Трёхместный номер' },
        { count: 4, name: 'Четырёхместный номер' },
      ],
      customerId: 15,
      roomType: 0,
      priceList: {
        standard: 0,
        single: 0,
      },
      additionalCount: 1,
      additionalPrices: [
        [
          { name: 'Ребёнок', price: 0 },
          { name: 'Взрослый', price: 0 }
        ],
      ]
    };
  },
  computed: {
    attribute: function() {
      return 'attribute[0]'
    },
    extra: function() {
      return JSON.stringify({
        priceList: {
          ...this.priceList,
          additionalPrices: this.additionalPrices,
        }
      })
    },
    customerTypes: function() {
      let result = []
      Object.keys(this.customers).map((key) => {
        if (key != '') {
          result.push({
            id: key,
            name: this.customers[key]
          })
        }
      })
      return result
    },
  },
  mounted() {
    
  },
  methods: {
    log() {
      console.log(this.extra)
    },
    incrementAdditional() {
      if (this.additionalCount < 10) {
        this.additionalCount += 1
        this.additionalPrices.push([
          { name: 'Ребёнок', price: 0 },
          { name: 'Взрослый', price: 0 }
        ])
      }
    },
    decrementAdditional() {
      if (this.additionalCount > 0) {
        this.additionalPrices[this.additionalCount - 1][0].price = 0
        this.additionalPrices[this.additionalCount - 1][1].price = 0
        this.additionalCount -= 1
        this.additionalPrices.pop()
      }
    },
    close() {
      this.name = ''
      this.qnt = 0
      this.priceList = {
        standard: 0,
        single: 0,
      }
      this.additionalCount = 1
      this.additionalPrices = [
        [
          { name: 'Ребёнок', price: 0 },
          { name: 'Взрослый', price: 0 }
        ],
      ]
      this.dialog = false
    }
  },
  
};
</script>

<style lang="css" scoped>
</style>
