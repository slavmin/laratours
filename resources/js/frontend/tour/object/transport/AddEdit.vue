<template>
  <v-layout 
    row 
    justify-center
  >
    <v-dialog 
      v-model="dialog" 
      fullscreen 
      lazy
      hide-overlay 
      transition="dialog-bottom-transition"
      @input="setDefaultValues"
    >
      <template v-slot:activator="{ on }">
        <v-btn 
          color="green"
          dark 
          v-on="on"
        >
          Добавить транспорт
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
          <v-toolbar-title>Добавление нового транспорта</v-toolbar-title>
          <v-spacer />
          <v-toolbar-items>
            <v-btn 
              flat 
              @click="save"
            >
              Сохранить
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-container>
          <v-layout 
            row 
            wrap
          >
            <!-- Choose company -->
            <v-flex 
              v-if="show.company"
              mt-5 
              xs12
              column
              class="choose-company-form"
            >
              <h2 class="grey--text text--darken-1">
                Выберите транспортную компанию
              </h2>  
              <v-form
                ref="form"
                lazy-validation
              >
                <v-select
                  v-model="selectedCompany"
                  :items="allTransportCompanies"
                  item-text="name"
                  item-value="id"
                  :rules="[v => !!v || 'Это обязательное поле']"
                  color="green lighten-3"
                  required
                />
                <v-btn 
                  dark
                  color="green"
                  @click="showAddCompany"
                >
                  Добавить новую
                </v-btn>
                <v-btn 
                  dark
                  color="green"
                  @click="selectCompany"
                >
                  Выбрать
                </v-btn>
              </v-form>
            </v-flex>
            <!-- /Choose company -->
            <!-- Add company -->
            <v-flex 
              v-if="show.addCompany"
              mt-5 
              xs12
              column
              class="add-company-form"
            >
              <h2 class="grey--text text--darken-1">
                Введите название компании:
              </h2> 
              <v-form
                ref="form"
                lazy-validation
              >
                <v-text-field
                  v-model="newCompany"
                  color="green lighten-3"
                  required
                />
                <v-btn 
                  dark
                  color="green"
                  @click="setDefaultValues"
                >
                  Вернуться
                </v-btn>
                <v-btn 
                  color="green"
                  :disabled="!newCompany"
                  class="white--text"
                  @click="addCompany"
                >
                  Добавить
                </v-btn>
              </v-form>
            </v-flex>
            <!-- /Add company -->
            <!-- Alert. Company is not seleted -->
            <v-alert
              :value="companyIsNotSelected"
              color="red"
              type="success"
              transition="scale-transition"
            >
              Транспортная компания не выбрана!
            </v-alert>
            <!-- /Alert. Company is not selected -->
            <!-- Alert. Company successfully added -->
            <v-alert
              :value="addCompanyAlert"
              color="green"
              type="success"
              transition="scale-transition"
            >
              Транспортная компания {{ newCompany }} добавлена!
            </v-alert>
            <!-- /Alert. Company successfully added -->
            <!-- Add transport form -->
            <v-flex 
              v-if="show.addTransport"
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
                    <form @submit.prevent="addTransportToStore">
                      <v-text-field
                        v-model="name"
                        label="Название"
                        :rules="[v => !!v || 'Это обязательное поле']"
                        color="green"
                        required
                      />
                      <v-text-field
                        v-model="description"
                        label="Описание"
                        color="green"
                      />
                      <v-select
                        v-model="cityId"
                        :items="cities"
                        placeholder="Город"
                        item-text="name"
                        item-value="id"
                        :rules="[v => !!v || 'Это обязательное поле']"
                        color="green lighten-3"
                        required
                      />
                      <v-text-field
                        v-model="qnt"
                        :rules="[v => !!v || 'Это обязательное поле']"
                        label="Вместимость"
                        color="green"
                        required
                      />
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
                        Добавить
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
                    <!-- <v-select
                      v-model="currentDateRange"
                      :items="priceList"
                      item-text="dateRange"
                      color="green"
                      mt-2
                      :menu-props="{ maxHeight: '400' }"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      persistent-hint
                    /> -->
                    <v-text-field
                      v-for="(duration, i) in durations"
                      :key="duration"
                      :v-model="'price' + i"
                      color="green"
                      :label="duration"
                    />
                  </v-flex>
                </v-layout>
              </v-container>
              <!-- /Add transport form -->
              <!-- Alert. Company successfully added -->
              <v-alert
                :value="addTransportAlert"
                color="green"
                type="success"
                transition="scale-transition"
              >
                Транспорт  добавлен!
              </v-alert>
              <!-- /Alert. Company successfully added -->
            </v-flex>
          </v-layout>
        </v-container>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
export default {

  name: 'AddEdit',
  props: {
    citiesSelect: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },

  data() {
    return {
      dialog: false,
      show: {
        company: true,  //true
        addCompany: false,
        addTransport: false //false
      },
      cities: [],
      companies: ['Ромашка', 'Рейс'],
      selectedCompany: '',
      newCompany: '',
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
      durations: ['1 час', '3 часа', '8 часов', 'Сутки'],
      simplePrices: [
        { id: 0, name: '1 час', price: '1800' },
        { id: 1, name: '3 часа', price: '3000' },
        { id: 2, name: '8 часов', price: '5500' },
        { id: 3, name: 'Сутки', price: '13000' }
      ],
      price0: 100,
      price1: 200,
      price2: 300,
      price3: 400,
      result: {
        name: '',
        qnt: '',
        grade: [],
        transportCompanyId: '',
        cityId: '',
        description: '',
        prices: []
      }
    }
  },
  computed: mapGetters(['allTransportCompanies', 'allTransports']),
  created() {
    for (let city in this.citiesSelect.Россия) {
      this.cities.push({'id': city, 'name': this.citiesSelect.Россия[city]})
    }
    let element = this.priceList.find(item => item.dateRange == this.currentDateRange)
    this.currentPrices = element.prices
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
    showAddCompany() {
      this.show.company = false
      this.selectedCompany = ''
      this.show.addCompany = true
    },
    addCompany() {
      this.addTransportCompany({
        name: this.newCompany,
        id: this.allTransportCompanies.length + 1
      })
      this.addCompanyAlert = true
      setTimeout(() => {
        this.addCompanyAlert = false
      }, 3000)
      this.setDefaultValues()
    },
    selectCompany() {
      if (this.selectedCompany === '') {
        this.companyIsNotSelected = true
      } 
      if (this.selectedCompany) {
        this.companyIsNotSelected = false
        this.show.company = false
        this.show.addTransport = true
      }
    },
    addTransportToStore() {
      let result = {}
      this.result.id = this.allTransports.length + 1
      this.result.name = this.name
      this.result.qnt = this.qnt
      this.result.grade = this.grade
      this.result.cityId = this.cityId
      this.result.description = this.description
      this.result.transportCompanyId = this.selectedCompany
      this.result.prices = this.getPricesArray()
      console.log(this.result)
      this.addTransport(this.result)
      this.addTransportAlert = true
      this.result = {}
      setTimeout(() => {
        this.addTransportAlert = false
        this.dialog = false
      }, 2000)
    },
    getPricesArray() {
      return [ this.price0, this.price1, this.price2, this.price3 ]
    }
  }
};
</script>

<style lang="scss" scoped>
.container {
  font-family: 'Roboto' sans-serif;
}
.choose-company-form,
.add-company-form
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
