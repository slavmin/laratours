<template>
  <v-layout column> 
    <v-layout 
      row
      wrap
    >
      <v-flex
        v-for="hotel in allHotel"
        :key="hotel.id"
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
              {{ hotel.name }}
            </h3>
            <div class="text-xs-left subheading mb-3">
              {{ getCityName(hotel.city_id) }}
            </div>
          </div>
          <Edit 
            :hotel="hotel" 
            :token="token"
          />
          <form 
            :action="'/operator/hotel/' + hotel.id"
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
              :title="`Удалить '` + hotel.name + `'`"
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
            hotel
          </i>
          <div 
            v-for="(type, i) in JSON.parse(hotel.extra).hotelType"
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
              :href="JSON.parse(hotel.extra).contacts.site"
              target="_blank"
            >
              {{ JSON.parse(hotel.extra).contacts.site }}
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
              :href="'mailto:' + JSON.parse(hotel.extra).contacts.email"
            >
              {{ JSON.parse(hotel.extra).contacts.email }}
            </a>
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ JSON.parse(hotel.extra).contacts.phone }}
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
            {{ JSON.parse(hotel.extra).staff.name }}
          </div>
          <div>
            <i 
              class="material-icons"
              style="font-size: 12px;"
            >
              phone
            </i>
            {{ JSON.parse(hotel.extra).staff.phone }}
          </div>
        </v-layout>
        <div class="heading text-xs-left mb-3">
          {{ JSON.parse(hotel.extra).about }}
        </div> 
        <v-data-table
          :headers="headers"
          :items="hotel.objectables"
          class="elevation-1"
          rows-per-page-text="На странице:"
        >
          <template v-slot:items="props">
            <td class="text-xs-left">
              {{ props.item.name }}
            </td>
            <td class="text-xs-center">
              <v-layout 
                row 
                wrap
                justify-space-between
                my-2
              >
                <div
                  d-flex
                  class="grey--text"
                >
                  Обычное размещение:
                </div>
                <div
                  d-flex
                >
                  {{ JSON.parse(props.item.extra).priceList.standard }}
                </div>
              </v-layout>
              <v-layout 
                row 
                wrap
                justify-space-between
                my-2
              >
                <div
                  d-flex
                  class="grey--text"
                >
                  Single размещение:
                </div>
                <div
                  d-flex
                >
                  {{ JSON.parse(props.item.extra).priceList.single }}
                </div>
              </v-layout>
              <div v-if="JSON.parse(props.item.extra).priceList.additionalPrices.length > 0">
                <h6 class="grey--text body-1">
                  Доп. места:
                </h6>
                <v-layout
                  v-for="price in JSON.parse(props.item.extra).priceList.additionalPrices"
                  :key="price.name"
                  row
                  wrap
                  justify-space-between
                  my-2
                >
                  <div 
                    d-flex
                    class="grey--text"  
                  >
                    {{ price[0].name }}
                  </div>
                  <div d-flex>
                    {{ price[0].price }}
                  </div>
                  <br>
                  <div 
                    d-flex
                    class="grey--text"  
                  >
                    {{ price[1].name }}
                  </div>
                  <div d-flex>
                    {{ price[1].price }}
                  </div>
                </v-layout>
              </div>
            </td>
            <td class="text-xs-center">
              {{ props.item.qnt }}
            </td>
            <td>
              <EditObjectables
                :hotel="hotel" 
                :customers="customers"
                :room="props.item"
                :token="token"
              />
              <form 
                :action="'/operator/attribute/' + props.item.id"
                method="POST"
              >
                <input 
                  id="_method" 
                  type="hidden" 
                  name="_method" 
                  value="DELETE"
                >
                <input 
                  type="hidden" 
                  name="_token" 
                  :value="token"
                > 
                <input 
                  type="hidden" 
                  name="parent_model_id" 
                  :value="hotel.id"
                >
                <input 
                  type="hidden" 
                  name="parent_model_alias" 
                  value="hotel"
                >  
                <v-btn 
                  fab
                  small
                  outline
                  color="red"
                  type="submit"
                >
                  <i class="material-icons">
                    delete
                  </i>
                </v-btn>
              </form>
            </td>
          </template>
        </v-data-table>
        <AddObjectables
          :hotel="hotel" 
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

  name: 'ObjectHotelTable',
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
          text: 'Название номера',
          align: 'left',
          value: 'name'
        },
        {
          text: 'Цена',
          align: 'center',
          value: 'price',
          width: '250px'
        },
        {
          text: 'Кол-во номеров',
          align: 'center',
          value: 'qnt'
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
      'allHotel',
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
