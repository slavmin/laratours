<template>
  <v-container grid-list-xs>
    <v-layout 
      row 
      wrap
      justify-center
    > 
      <v-flex xs2>
        <v-select
          v-model="count"
          :items="items"
          label="Туристов"
        />
      </v-flex>
    </v-layout>
    
    <v-card>
      <v-card-title
        class="headline green white--text"
        primary-title
      >
        {{ headerText }}.
        Тур: "{{ tour.name }}"
      </v-card-title>
      <v-card-text>
        <form 
          id="form"
          method="POST"
          action="/agency/order/store"
        >
          <div
            v-for="i in count" 
            :key="`order-form-` + i"
          >
            <v-divider />
            <p class="subheading grey--text text-xs-right">
              Турист {{ i }}
            </p>
            <OrderForm
              :tour="tour"
              :profile-id="i - 1"
            />
          </div>
          <input 
            type="hidden"
            name="_token"  
            :value="token"
          >
          <input 
            type="hidden"
            name="tour_id"
            :value="tour.id"
          >
          <input 
            type="hidden"
            name="operator_id"
            :value="tour.team_id"
          >
        </form>
      </v-card-text>

      <v-divider />

      <v-card-actions>
        <v-spacer />
        <v-btn 
          color="green"
          type="submit"
          dark
          form="form"
        >
          Заказать
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>
<script>
import OrderForm from './OrderForm'
export default {
  name: 'OrderTour',
  components: {
    OrderForm,
  },
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
    token: {
      type: String,
      default: ''
    },
    headerText: {
      type: String,
      default: 'Создать'
    }
  },
  data () {
    return {
      items: [1, 2, 3, 4],
      choosenSeat: [],
      count: 1,
    }
  },
  mounted() {
    console.log(this.tour)
  },
  methods: {
    close() {
      this.dialog = false
      this.order = {}
    },
  }
}
</script>