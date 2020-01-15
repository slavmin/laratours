<template>
  <v-container grid-list-xs>
    <v-layout
      row
      wrap
    >
      <h2 class="text-center white--text">
        <v-btn
          dark
          flat
          @click="showFilters = !showFilters"
        >
          Фильтры
          <v-icon>
            expand_{{ showFilters ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
      </h2>
    </v-layout>
    <v-layout
      v-if="showFilters"
      row
      wrap
    >
      <v-flex>
        <v-text-field
          v-model="orderId"
          name="order_id"
          hint="Номер заявки"
          dark
          persistent-hint
          clearable
          @input="filter"
        />
      </v-flex>
      <v-flex>
        <v-select
          v-model.number="status"
          :items="statusesTranslated"
          item-value="id"
          dark
          label="Статус"
          clearable
          @input="filter"
        />
      </v-flex>
      <v-flex>
        id
      </v-flex>
      <v-flex>
        город
      </v-flex>
      <v-flex>
        даты
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import { mapActions } from 'vuex'
export default {
  name: 'OrderFilters',
  data() {
    return {
      showFilters: true,
      orderId: null,
      tourName: '',
      statusesTranslated: [
        { id: 0, text: 'Не подтвержден' },
        { id: 1, text: 'Подтвержден' },
        { id: 2, text: 'Оплачен' },
        { id: 3, text: 'Отменен' },
        { id: 4, text: 'Отклонен' },
        { id: 5, text: 'Завершен' },
      ],
      status: null,
    }
  },
  computed: {
    filterUrl: function() {
      let result = '/operator/order?'
      if (this.orderId != null) {
        result = result + `&id=${this.orderId}`
      }
      if (this.status != null) {
        result = result + `&status=${this.status}`
      }
      console.log(result)
      return result
    },
  },
  methods: {
    ...mapActions(['updateTours']),
    datePicked() {},
    fetch() {
      const url = `/operator/order?id=${this.orderId}`
      axios.get(this.filterUrl).then(response => {
        console.log(response.data.data)
        this.updateTours(response.data.data)
      })
    },
    filter() {
      this.fetch()
    },
  },
}
</script>