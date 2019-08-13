<template>
  <v-layout column> 
    <v-layout 
      row
      wrap
    >
      <v-flex
        v-for="museum in allMuseum"
        :key="museum.id"
        mb-5
        xs12
        md12
        lg6
        xl4
      >
        <v-layout 
          row 
          wrap
          justify-start
        >
          <div>
            <h3 class="display-1">
              {{ museum.name }}
            </h3>
            <div class="text-xs-left subheading mb-3">
              {{ getCityName(museum.city_id) }}
            </div>
          </div>
          <Edit 
            :museum="museum" 
            :token="token"
            :cities-select="cities"
          />
          <form 
            :action="'/operator/museum/' + museum.id"
            method="post"
          >
            <input
              type="hidden"
              name="_method"
              value="DELETE"
            >
            <input
              type="hidden"
              name="_token"
              :value="token"
            >
            <v-btn 
              small
              fab
              outline
              :title="`Удалить '` + museum.name + `'`"
              color="red"
              dark 
              type="submit"
            >
              <i class="material-icons">
                delete
              </i>
            </v-btn>
          </form>
        </v-layout>
        <v-layout 
          row 
          wrap
          mb-3
          align-center
        >
          <i class="material-icons mr-2">
            account_balance
          </i>
          <div 
            v-for="(type, i) in JSON.parse(museum.extra).museumType"
            :key="i"
            class="mr-2"
          >
            {{ type }}
          </div>
        </v-layout>
        <v-layout 
          row 
          wrap
          mb-2
        >
          <div class="mr-3">
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              web
            </i>
            <a 
              :href="museum.extra.contacts.site"
              target="_blank"
            >
              {{ museum.extra.contacts.site }}
            </a>
          </div>
          <div class="mr-3">
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              email
            </i>
            <a 
              :href="'mailto:' + museum.extra.contacts.email"
            >
              {{ museum.extra.contacts.email }}
            </a>
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ museum.extra.contacts.phone }}
          </div>
        </v-layout>
        <v-layout 
          row 
          wrap
          mb-2
        >
          <div class="mr-3">
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              person
            </i>
            {{ museum.extra.staff.name }}
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ museum.extra.staff.phone }}
          </div>
        </v-layout>
        <div class="heading text-xs-left mb-3">
          {{ museum.extra.about }}
        </div> 
        <v-data-table
          :headers="headers"
          :items="museum.objectables"
          class="elevation-1"
          rows-per-page-text="На странице:"
        >
          <template v-slot:items="props">
            <td class="text-xs-left">
              {{ props.item.name }}
            </td>
            <td class="text-xs-center">
              {{ JSON.parse(props.item.extra).duration }} ч.
            </td>
            <td>
              <v-layout
                v-for="price in JSON.parse(props.item.extra).priceList "
                :key="price.customerId"
                row
                wrap
                justify-space-between
                my-2
              >
                <div 
                  d-flex
                  class="grey--text"  
                >
                  {{ price.customerName }}
                </div>
                <div d-flex>
                  {{ price.price }}
                </div>
              </v-layout>
            </td>
            <td class="text-xs-right">
              <EditObjectables
                :museum="museum" 
                :customers="customers"
                :event="props.item"
                :token="token"
              />
              <v-btn 
                fab
                small
                outline
                color="red"
                dark 
              >
                <i class="material-icons">
                  delete
                </i>
              </v-btn>
            </td>
          </template>
        </v-data-table>
        <AddObjectables
          :museum="museum" 
          :customers="customers"
          :token="token"
        />
      </v-flex>
    </v-layout>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
import Edit from './Edit'
import AddObjectables from './AddObjectables'
import EditObjectables from './EditObjectables'
export default {

  name: 'ObjectMuseumTable',
  components: {
    Edit,
    AddObjectables,
    EditObjectables,
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    cities: {
      type: Object,
      default: () => {
        return {}
      }
    },
    customers: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {
      headers: [
        {
          text: 'Экскурсия',
          align: 'left',
          value: 'description'
        },
        {
          text: 'Время',
          align: 'center',
          value: 'duration'
        },
        {
          text: 'Расценки',
          align: 'center',
          value: 'name'
        },
        {
          text: 'Действия',
          align: 'center',
          value: 'actions'
        }
      ]
    };
  },
  computed: {
    ...mapGetters([
      'allMuseum',
      'allCities'
    ]),
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
    this.fetchMuseum()
    this.fetchCities()
  },
  methods: {
    ...mapActions([
      'fetchMuseum',
      'fetchCities'
    ]),
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
    getCustomerName(id) {
      return this.customerTypes.find(c => c.id == id).name
    }
  },

};
</script>

<style lang="css" scoped>
</style>
