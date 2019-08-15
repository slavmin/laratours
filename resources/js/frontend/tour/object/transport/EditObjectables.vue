<template>
  <v-dialog 
    v-model="dialog" 
    fullscreen 
    lazy
    hide-overlay 
    transition="dialog-bottom-transition"
  >
    <template v-slot:activator="{ on }">
      <v-btn 
        fab
        small
        outline
        title="Добавить"
        color="green"
        dark 
        v-on="on"
      >
        <i class="material-icons">
          edit
        </i>
      </v-btn>  
    </template>
    <v-card>
      <v-toolbar
        dark
        color="green"
      >
        <v-btn 
          icon 
          @click="close"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          Редактирование транспорта: {{ item.name }}
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-container>
        <v-layout 
          row 
          wrap
        >
          <!-- Edit transport form -->
          <v-flex 
            mt-5
            xs12
            column
            class="add-transport-form"
          >
            <v-container>
              <v-layout 
                row
                wrap
              >
                <v-flex xs6>
                  <h2 class="grey--text text--darken-1 mb-2">
                    Транспорт:
                  </h2>
                  <form 
                    method="POST"
                    :action="'/operator/attribute/' + item.id" 
                  >
                    <input 
                      id="_method" 
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
                      :value="companyId"
                    >
                    <input 
                      type="hidden" 
                      name="parent_model_alias" 
                      value="transport"
                    >  
                    <input 
                      type="hidden"
                      :value="JSON.stringify(extra)"
                      name="extra"
                    > 
                    <input 
                      type="hidden" 
                      name="id" 
                      value="0"
                    > 
                    <input 
                      type="hidden" 
                      name="customer_type_id" 
                      value="1"
                    > 
                    <input 
                      type="hidden" 
                      name="qnt" 
                      value="1"
                    >
                    <input
                      type="hidden" 
                      value="1"
                      name="price"
                    >
                    <v-text-field
                      v-model="name"
                      name="name" 
                      label="Название"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      color="green"
                      required
                    />
                    <v-text-field
                      v-model="description"
                      name="description" 
                      label="Описание"
                      color="green"
                    />
                    <v-layout 
                      row 
                      wrap
                    >
                      <!-- <v-flex xs6>
                        <v-text-field
                          v-model="qnt"
                          :name="attribute + '[qnt]'" 
                          :rules="[v => !!v || 'Это обязательное поле']"
                          label="Вместимость"
                          color="green"
                          required
                        />
                      </v-flex>  -->
                      <!-- <v-flex xs6>
                        Схема салона:
                        <Scheme
                          :object="editItem"
                          :company-id="companyId"
                          :token="token"
                        />
                      </v-flex>  -->
                    </v-layout>
                    <v-select
                      v-model="grade"
                      :items="grades"
                      color="green"
                      :menu-props="{ maxHeight: '400' }"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      label="Класс обслуживания"
                      multiple
                      hint="Можно выбрать несколько"
                      persistent-hint
                    />
                    <v-btn 
                      type="submit"
                      dark
                      color="green"
                    >
                      Сохранить
                    </v-btn>
                  </form>
                </v-flex>
                <v-flex 
                  xs3
                  offset-xs3
                >
                  <h2 class="grey--text text--darken-1 mb-2">
                    Цены
                  </h2>
                  <v-text-field
                    v-model="price0"
                    color="green"
                    label="1 час"
                  />
                  <v-text-field
                    v-model="price1"
                    color="green"
                    label="1 км"
                  />
                </v-flex>
              </v-layout>
            </v-container>
            <!-- /Edit transport form -->
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
// import Scheme from './Scheme'
export default {

  name: 'EditObjectables',
  components: {
    // Scheme,
  },
  props: {
    citiesSelect: {
      type: Object,
      default: () => {
        return {}
      }
    },
    item: {
      type: Object,
      default: () => {
        return {}
      }
    },
    companyId: {
      type: Number,
      default: 0
    },
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      dialog: false,
      cities: [],
      selectedCompany: '',
      newCompany: '',
      newCompanyDescription: '',
      newCompanyCityId: 3,
      addCompanyAlert: false,
      companyIsNotSelected: false,
      addTransportAlert: false,
      name: '',
      cityId: 0,
      qnt: '',
      description: '',
      grade: [],
      grades: ['Стандарт', 'C-Class', 'VIP'],
      priceList: [
          { dateRange: '1 января - 10 января',
            prices: [
              { id: 0, name: '1 час', price: '2000' },
              { id: 1, name: '3 часа', price: '3500' },
              { id: 2, name: '8 часов', price: '6000' },
              { id: 3, name: 'Сутки', price: '15000' }
            ]
          },
          { dateRange: '11 января - 30 апреля',
            prices: [
              { id: 0, name: '1 час', price: '1800' },
              { id: 1, name: '3 часа', price: '3000' },
              { id: 2, name: '8 часов', price: '5500' },
              { id: 3, name: 'Сутки', price: '13000' }
            ]
          }
      ],
      currentDateRange: '1 января - 10 января',
      currentPrices: [],
      durations: ['1 час', '1 км'],
      price0: 0,
      price1: 0,
      result: {
        name: '',
        qnt: '',
        grade: [],
        transportCompanyId: '',
        cityId: '',
        description: '',
        prices: []
      },
      attribute: 'attribute',
      price: 10000,
      defaultScheme: {
        rows: 10,
        cols: 4,
        driver: ['1-1', '1-2'],
        doors: ['1-4'],
        guide: ['2-4'],
        pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
        unavailable: [],
        totalPassengersCount: 0
      },
    }
  },
  computed: {
    ...mapGetters(['allTransports']),
    extra: function() {
      let result = {}
      result.prices = this.getPricesArray()
      result.grade = this.grade
      result.scheme = this.defaultScheme
      // if (JSON.parse(this.editItem.extra).scheme != undefined) {
      //   result.scheme = JSON.parse(this.editItem.extra).scheme
      // }
      return result
    }
  },
  // created() {
  //   for (let city in this.citiesSelect.Россия) {
  //     this.cities.push({'id': city, 'name': this.citiesSelect.Россия[city]})
  //   }
  //   let element = this.priceList.find(item => item.dateRange == this.currentDateRange)
  //   this.currentPrices = element.prices
  //   this.attribute = this.attribute + '[' + this.editItem.id + ']'
  // },
  mounted() {
    this.name = this.item.name
    this.description = this.item.description
    this.grade = JSON.parse(this.item.extra).grade
    this.price0 = JSON.parse(this.item.extra).prices[0].value
    this.price1 = JSON.parse(this.item.extra).prices[1].value
  },
  methods: {
    ...mapMutations(['addTransportCompany', 'addTransport']),
    close() {
      this.dialog = false
      console.log('closed')
    },
    save() {
      this.dialog = false
      console.log('saved!')
    },
    setDefaultValues() {
      this.selectedCompany = ''
      this.newCompany = ''
      this.show = {
        addCompany: false,
        company: true, //true
      }
      this.name = ''
      this.qnt = ''
      this.grade = []
      this.cityId = 0
      this.description = ''
      this.companyIsNotSelected = false
      // console.log('set to default')
    },
    getPricesArray() {
      return [ 
        { name: '1 час', value: parseInt(this.price0) }, 
        { name: '1 км', value:parseInt(this.price1) }, 
      ]
    },
  }
};
</script>

<style lang="scss" scoped>
.container {
  font-family: 'Roboto' sans-serif;
}
.choose-company-form,
.add-company-form,
.edit-company-form
 {
  form {
    max-width: 500px;
    margin: 0 auto;
    .v-select__selection {
      margin: 0 auto;
    }
  }
}
.name-enter-active {
  animation: bounceIn 2s;
}
.name-leave-active {
  animation: bounceIn 2s reverse;
}
@keyframes bounceIn {
  0% {
    transform: scale(0.1);
    opacity: 0;
  }
  60% {
    transform: scale(1.2);
    opacity: 1;
  }
  100% {
    transform: scale(1);
  }
}
</style>
