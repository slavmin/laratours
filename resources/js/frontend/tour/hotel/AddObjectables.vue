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
                :action="'/operator/hotel/' + hotel.id"
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
                  type="hidden" 
                  :name="attribute + '[id]'" 
                  value="0"
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
                  v-model="customerName"
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
                      label="Тип туриста:"
                      outline
                    />
                    <v-select
                      v-model="roomType"
                      :items="roomTypes"
                      item-text="name"
                      item-value="id"
                      label="Тип номера:"
                      outline
                    />
                    <v-text-field 
                      :name="attribute + '[description]'" 
                      label="Описание" 
                      outline
                      color="green"
                      class="mb-3"
                    />
                    <v-text-field 
                      :name="attribute + '[price]'"
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
      roomTypes: [
        { count: 1, name: 'Одноместный номер' },
        { count: 2, name: 'Двухместный номер' },
        { count: 3, name: 'Трёхместный номер' },
        { count: 4, name: 'Четырёхместный номер' },
      ],
      customerId: 15,
      roomType: 0
    };
  },
  computed: {
    attribute: function() {
      return 'attribute[' + this.hotel.id + ']'
    },
    customerName: function() {
      return this.customerTypes.find(customer => customer.id == this.customerId).name
    },
    extra: function() {
      return JSON.stringify({
        roomType: this.roomType
      })
    }
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
