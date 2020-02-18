<template>
  <v-dialog
    v-model="dialog"
    fullscreen
    hide-overlay
    transition="dialog-bottom-transition"
    @input="parseInfo"
  >
    <template v-slot:activator="{ on }">
      <v-btn
        :icon="editMode"
        :fab="!editMode"
        small
        :color="editMode ? 'yellow' : '#aa282a'"
        :title="(editMode ? 'Редактировать' :'Добавить') + ' транспорт'"
        dark
        v-on="on"
      >
        <i class="material-icons">
          {{ editMode ? 'edit' : 'add' }}
        </i>
      </v-btn>
    </template>
    <v-card>
      <v-toolbar
        dark
        color="#66a5ae"
      >
        <v-btn
          icon
          @click="close"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          {{ editMode ? 'Редактировать' :'Добавить' }} транспорт
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-container>
        <v-layout
          row
          wrap
        >
          <!-- Add transport form -->
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
                  <v-form
                    :id="'form' + tourObject.id"
                    ref="form"
                    lazy-validation
                    :action="editMode ? `/operator/attribute/${objectAttribute.id}` : '/operator/attribute'"
                    method="POST"
                  >
                    <input
                      v-if="editMode"
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
                      :value="tourObject.id"
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
                      value="0"
                      name="price"
                    >
                    <v-text-field
                      v-model="name"
                      name="name"
                      label="Название"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      color="#aa282a"
                      required
                    />
                    <v-text-field
                      v-model="description"
                      name="description"
                      label="Описание"
                      color="#aa282a"
                    />
                    <v-select
                      v-model="grade"
                      :items="grades"
                      color="#aa282a"
                      :menu-props="{ maxHeight: '400' }"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      label="Класс обслуживания"
                      multiple
                      hint="Можно выбрать несколько"
                      persistent-hint
                    />
                  </v-form>
                </v-flex>
                <!-- <v-flex
                  xs3
                  offset-xs3
                >
                  <h2 class="grey--text text--darken-1 mb-2">
                    Цены
                  </h2>
                  <v-text-field
                    v-model="price0"
                    color="#aa282a"
                    label="1 час"
                  />
                  <v-text-field
                    v-model="price1"
                    color="#aa282a"
                    label="1 км"
                  />
                </v-flex> -->
              </v-layout>
              <v-layout
                row
                wrap
                mt-5
              >
                <v-flex>
                  <v-layout
                    row
                    wrap
                    justify-start
                  >
                    <v-btn
                      small
                      text
                      color="#aa282a"
                      dark
                      @click="showScheme = !showScheme"
                    >
                      {{ showScheme ? 'Скрыть схему' : 'Показать схему' }}
                      <v-icon right>
                        expand_{{ showScheme ? 'less' : 'more' }}
                      </v-icon>
                    </v-btn>
                  </v-layout>
                  <div v-if="showScheme">
                    <Scheme
                      :company-id="tourObject.id"
                      :token="token"
                      new
                      :current-scheme="currentScheme"
                      @update="updateScheme"
                    />
                  </div>
                </v-flex>
              </v-layout>
              <v-layout
                row
                wrap
                mt-5
              >
                <v-flex>
                  <v-row>
                    <v-btn
                      small
                      text
                      color="#aa282a"
                      dark
                      @click="showDocs = !showDocs"
                    >
                      {{ showDocs ? 'Скрыть' : 'Документы' }}
                      <v-icon right>
                        expand_{{ showDocs ? 'less' : 'more' }}
                      </v-icon>
                    </v-btn>
                  </v-row>
                  <div v-if="showDocs">
                    <TransportDocs
                      edit-mode
                      :bus-data="JSON.parse(objectAttribute.extra)"
                      @update="updateTransportData"
                    />
                  </div>
                </v-flex>
              </v-layout>
              <v-layout
                row
                wrap
                justify-end
              >
                <v-btn
                  type="submit"
                  dark
                  color="#aa282a"
                  :form="'form' + tourObject.id"
                >
                  Сохранить
                </v-btn>
              </v-layout>
            </v-container>
            <!-- /Add transport form -->
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
import Scheme from './Scheme'
import TransportDocs from './TransportDocs'
export default {
  name: 'AddObjectables',
  components: {
    Scheme,
    TransportDocs,
  },
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
    objectAttributePrices: {
      type: Array,
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
      name: '',
      cityId: 0,
      qnt: '',
      description: '',
      grade: [],
      grades: ['Стандарт', 'C-Class', 'VIP'],
      priceList: [
        {
          dateRange: '1 января - 10 января',
          prices: [
            { id: 0, name: '1 час', price: '2000' },
            { id: 1, name: '3 часа', price: '3500' },
            { id: 2, name: '8 часов', price: '6000' },
            { id: 3, name: 'Сутки', price: '15000' },
          ],
        },
        {
          dateRange: '11 января - 30 апреля',
          prices: [
            { id: 0, name: '1 час', price: '1800' },
            { id: 1, name: '3 часа', price: '3000' },
            { id: 2, name: '8 часов', price: '5500' },
            { id: 3, name: 'Сутки', price: '13000' },
          ],
        },
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
        prices: [],
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
        totalPassengersCount: 0,
      },
      showScheme: false,
      currentScheme: {},
      showDocs: false,
      drivers: [],
      busDocs: {},
    }
  },
  computed: {
    ...mapGetters(['allTransports']),
    extra: function() {
      let result = {}
      result.prices = this.getPricesArray()
      result.grade = this.grade
      result.scheme = this.currentScheme
      result.drivers = this.drivers
      result.busDocs = this.busDocs
      // if (JSON.parse(this.objectAttribute.extra).scheme != undefined) {
      //   result.scheme = JSON.parse(this.objectAttribute.extra).scheme
      // }
      return result
    },
  },
  created() {
    let element = this.priceList.find(
      item => item.dateRange == this.currentDateRange
    )
    this.currentPrices = element.prices
    // this.attribute = this.attribute + '[' + this.objectAttribute.id + ']'
    this.currentScheme = this.defaultScheme
  },
  mounted() {
    if (this.editMode) this.parseInfo()
  },
  methods: {
    ...mapMutations(['addTransportCompany', 'addTransport']),
    close() {
      this.dialog = false
      // Set default scheme
      this.currentScheme = {
        rows: 10,
        cols: 4,
        driver: ['1-1', '1-2'],
        doors: ['1-4'],
        guide: ['2-4'],
        pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
        unavailable: [],
        totalPassengersCount: 0,
      }
      this.price0 = 0
      this.price1 = 0
      this.showScheme = false
    },
    save() {
      this.dialog = false
    },
    setDefaultValues() {
      this.selectedCompany = ''
      this.newCompany = ''
      this.name = ''
      this.qnt = ''
      this.grade = []
      this.cityId = 0
      this.description = ''
      this.companyIsNotSelected = false
    },
    getPricesArray() {
      return [
        { name: '1 час', value: parseInt(this.price0) },
        { name: '1 км', value: parseInt(this.price1) },
      ]
    },
    updateScheme(scheme) {
      this.currentScheme = scheme
    },
    updateTransportData(data) {
      this.drivers = data.drivers
      this.busDocs = data.bus
      console.log(this.drivers, this.busDocs)
    },
    parseInfo() {
      this.name = this.objectAttribute.name
      this.description = this.objectAttribute.description
      this.grade = JSON.parse(this.objectAttribute.extra).grade
      this.currentScheme = Object.assign(
        {},
        JSON.parse(this.objectAttribute.extra).scheme
      )
      this.initialScheme = Object.assign(
        {},
        JSON.parse(this.objectAttribute.extra).scheme
      )
    },
  },
}
</script>

<style lang="scss" scoped>
.container {
  font-family: 'Roboto' sans-serif;
}
.choose-company-form,
.add-company-form {
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
