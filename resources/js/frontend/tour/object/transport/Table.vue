<template>
  <v-data-table
    :headers="headers"
    :items="allTransports"
    class="elevation-1"
    rows-per-page-text="На странице:"
  >
    <template v-slot:items="props">
      <td class="text-xs-left">
        {{ props.item.name }}
      </td>
      <td class="text-xs-center">
        {{ getTransportCompanyName(props.item.transportCompanyId) }}
      </td>
      <td class="text-xs-center">
        {{ props.item.qnt }}
      </td>
      <td class="text-xs-center">
        {{ props.item.grade }}
      </td>
      <td class="text-xs-center">
        {{ props.item.prices[1] }}
      </td>
      <td>
        {{ props.item.description }}
      </td>
      <td class="text-xs-center">
        <Scheme
          :id="props.item.id" 
          :scheme="props.item.scheme" 
        />
        <v-btn
          color="red"
          flat
          dark
          @click="del(props.item.id)"
        >
          <i class="far fa-trash-alt" />
        </v-btn>
      </td>
    </template>
  </v-data-table>
</template>

<script>
import Scheme from './Scheme'
import { mapGetters, mapMutations } from 'vuex'
export default {

  name: 'Table',
  components: {
    Scheme
  },
  data() {
    return {
      headers: [
        {
          text: 'Название',
          align: 'left',
          value: 'name'
        },
        {
          text: 'Компания',
          align: 'center',
          value: 'company'
        },
        {
          text: 'Вместимость',
          align: 'center',
          value: 'qnt'
        },
        {
          text: 'Класс',
          align: 'center',
          value: 'grade'
        },
        {
          text: '3 часа',
          align: 'center',
          value: '1hour'
        },
        {
          text: 'Описание',
          align: 'center',
          value: 'description'
        },
        {
          text: 'Действия',
          align: 'center',
          value: 'description'
        },
      ],
    };
  },
  computed: mapGetters(['allTransports', 'allTransportCompanies']),
  methods: {
    ...mapMutations(['deleteTransport']),
    getTransportCompanyName(id) {
      let company = this.allTransportCompanies.find(item => item.id == id)
      return company.name
    },
    del(id) {
      this.deleteTransport(id)
    }
  }
};
</script>

<style lang="css" scoped>
</style>
