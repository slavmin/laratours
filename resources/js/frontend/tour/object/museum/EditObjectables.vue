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
            :id="'form' + museum.id"
            ref="form"
            lazy-validation
            :action="'/operator/museum/' + museum.id"
            method="POST"
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
              :id="attribute + '[id]'" 
              v-model="event.id"
              type="hidden" 
              :name="attribute + '[id]'"
            > 
            <input 
              :id="attribute + '[qnt]'" 
              type="hidden" 
              :name="attribute + '[qnt]'" 
              value="1"
            > 
            <input 
              :id="attribute + '[customer_type_id]'" 
              v-model="customerId"
              type="hidden" 
              :name="attribute + '[customer_type_id]'" 
            > 
            <input 
              :id="attribute + '[name]'" 
              v-model="name"
              type="hidden" 
              :name="attribute + '[name]'" 
            > 
            <input 
              :id="attribute + '[extra]'" 
              v-model="extra"
              type="hidden" 
              :name="attribute + '[extra]'" 
            > 
            <v-layout
              column
              wrap
            >
              <v-flex 
                xs12 
                sm6 
              >
                <v-select
                  v-model="customerId"
                  :items="customerTypes"
                  item-text="name"
                  item-value="id"
                  label="Тип билета"
                  outline
                />
                <v-text-field 
                  v-model="name"
                  label="Название" 
                  outline
                  color="green"
                  class="mb-3"
                />
                <v-text-field 
                  v-model="price"
                  :name="attribute + '[price]'"
                  label="Цена" 
                  mask="#####"
                  outline
                  color="green"
                />
                <v-text-field 
                  v-model="duration"
                  label="Продолжительность экскурсии в часах" 
                  mask="##"
                  outline
                  color="green"
                />
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
    };
  },
  computed: {
    attribute: function() {
      return 'attribute[' + this.event.id + ']'
    },
    extra: function() {
      return JSON.stringify({
        duration: this.duration,
        customer: this.customerId,
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
    console.log(this.event)
    this.parseInfo()
  },
  methods: {
    parseInfo() {
      this.duration = JSON.parse(this.event.extra).duration
      this.customerId = JSON.parse(this.event.extra).customer
      this.name = this.event.name
      this.price = this.event.price
    },
    close() {
      this.parseInfo()
      this.dialog = false
    }
  }
};
</script>

<style lang="css" scoped>
</style>
