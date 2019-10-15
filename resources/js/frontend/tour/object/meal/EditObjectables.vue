<template>
  <v-dialog 
    v-model="dialog" 
    persistent 
    max-width="600px"
  >
    <template v-slot:activator="{ on }">
      <v-btn 
        fab
        small
        outline
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
      <v-card-title>
        <v-layout 
          column
          wrap
        >
          <h3 class="mb-4">
            <i class="material-icons mr-2">
              fastfood
            </i>
            {{ meal.name }}
          </h3>  
          <h4>Добавить номер:</h4>
        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-container grid-list-md>
          <v-form 
            :id="'form' + meal.id + event.id"
            ref="form"
            lazy-validation
            :action="'/operator/attribute/' + event.id"
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
              type="hidden" 
              name="parent_model_id" 
              :value="meal.id"
            >
            <input 
              type="hidden" 
              name="parent_model_alias" 
              value="meal"
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
              type="hidden" 
              name="customer_type_id" 
              value="1"
            > 
            <input  
              v-model="mealType"
              type="hidden" 
              name="name" 
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
                <v-select
                  v-model="mealType"
                  :items="mealTypes"
                  item-text="name"
                  item-value="id"
                  label="Тип питания:"
                  outline
                />
                <v-text-field 
                  v-model="description"
                  name="description" 
                  label="Описание" 
                  outline
                  color="green"
                  class="mb-3"
                />
                <v-text-field 
                  v-model="price"
                  name="price"
                  label="Цена" 
                  mask="#####"
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
          @click="dialog = false"
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
          :form="'form' + meal.id + event.id"
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
    meal: {
      type: Object,
      required: true,
      default: null,
    },
    event: {
      type: Object,
      required: true,
      default: null,
    },
    token: {
      type: String,
      required: true,
      default: null,
    }
  },
  data() {
    return {
      dialog: false,
      customerTypes: [
        { id: 15, name: 'Взрослый'},
        { id: 2, name: 'Ребёнок'},
        { id: 3, name: 'Иностранец'}
      ],
      mealTypes: [
        { count: 1, name: 'Завтрак' },
        { count: 2, name: 'Обед' },
        { count: 3, name: 'Ужин' },
      ],
      customerId: 15,
      mealType: 0,
      description: '',
      price: 0,
    };
  },
  computed: {
    attribute: function() {
      return 'attribute[' + this.meal.id + ']'
    },
    customerName: function() {
      return this.customerTypes.find(customer => customer.id == this.customerId).name
    },
    extra: function() {
      return JSON.stringify({
        mealType: this.mealType
      })
    }
  },
  mounted() {
    this.mealType = this.event.name
    this.description = this.event.description
    this.price = this.event.price
  },
  methods: {
    log() {
      console.log(this.customerName)
    }
  }
};
</script>

<style lang="css" scoped>
</style>
