<template>
  <v-layout 
    column
  >
    <v-flex>
      <h2 class="grey--text text-xs-center">
        Данные для связи по заказу:
      </h2>
    </v-flex>
    <v-layout 
      row 
      wrap
      justify-space-around
    >
      <v-flex>
        <v-text-field
          v-model="getOrderContacts.email"
          label="Email"
          type="email"
          :rules="[v => !!v || 'Укажите email']"
          required
          color="green lighten-3"
        />
      </v-flex>  
      <v-flex>
        <v-text-field
          v-model="getOrderContacts.phone"
          label="Телефон"
          :rules="[v => !!v || 'Укажите телефон']"
          required
          color="green lighten-3"
        />
      </v-flex>  
      <v-flex>
        <v-text-field
          v-model="getOrderContacts.name"
          label="Имя"
          color="green lighten-3"
        />
      </v-flex>  
    </v-layout>
  </v-layout>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  name: 'OrderContacts',
  data() {
    return {
      email: '',
      phone: '',
      name: '',
    }
  },
  computed: {
    ...mapGetters([
      'getOrderContacts',
    ])
  },
}
</script>