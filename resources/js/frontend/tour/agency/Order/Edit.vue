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
          <h4>Редактирование заказ:</h4>
        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-container grid-list-md>
          В работе
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
        >
          <!-- type="submit"
          :form="'form' + meal.id + event.id"
        > -->
          Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {

  name: 'OrderEdit',
  props: {
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

  },
  mounted() {

  },
  methods: {
    log() {
    }
  }
};
</script>

<style lang="css" scoped>
</style>
