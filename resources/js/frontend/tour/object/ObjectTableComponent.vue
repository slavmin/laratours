<template>
  <div>
    <!-- <h5>hi from table!</h5> -->
    <!-- <button class="btn btn-primary" v-on:click="showMe">Show me value at console</button> -->
    <!-- <bus-scheme-component /> -->
    <!-- <example-component></example-component> -->
    <transport-price-component />
    <table class="table table-hover mt-2">
      <!-- Table header -->
      <thead>
        <th>Название</th>
        <th class="text-center">
          Компания, 
          <br>
          Город
        </th>
        <th class="text-center">
          Количество
        </th>
        <th>
          Описание
        </th>
        <th class="text-right">
          Действия
        </th>
      </thead>
      <!-- /Table header -->
      <!-- Table body -->
      <tbody>
        <tr 
          v-for="item in allTransports"
          :key="item.id"
        >
          <!-- Object name and price -->
          <td>
            <div class="object-name">
              {{ item.name }}
            </div>
            <div 
              v-for="price in item.prices"
              :key="price.id"
              class="object-prices"
            >
              <div class="d-flex flex-row justify-content-between">
                <div>{{ price.duration }}: </div>
                <div>{{ price.price }}₽</div>
              </div>
            </div>
          </td>
          <!-- /Object name and price -->
          <!-- City -->
          <td class="align-middle text-center">
            {{ getTransportCompanyName(item.transportCompanyId) }}
            <br>
            {{ getCityName(item.cityId) }}
          </td>
          <!-- /City -->
          <!-- Quantity -->
          <td class="align-middle text-center">
            <div>{{ item.qnt }}</div>
            <div>
              <!-- <a href="#">Схема салона</a> -->
              <bus-scheme-component 
                :id="item.id" 
                :scheme="item.scheme" 
              />
            </div>
          </td>
          <!-- /Quantity -->
          <!-- Description -->
          <td class="align-middle">
            {{ item.description }}
          </td>
          <!-- /Description -->
          <!-- Actions -->
          <td class="align-middle">
            <!-- Edit button -->
            <div 
              role="toolbar" 
              class="float-right"
            >
              <div class="ml-1 d-flex flex-row">
                <!-- Edit button -->
                <edit-transport-component 
                  :data="item" 
                  :cities="cities"
                />
                <!-- /Edit button -->
                <!-- Delete button -->
                <button 
                  title="Удалить" 
                  class="btn btn-outline-danger ml-1"
                  @click="del(item.id)"
                >
                  <i class="far fa-trash-alt" />
                </button>
                <!-- </form> -->
                <!-- /Delete button -->
              </div>
            </div>
          </td>
          <!-- /Actions -->
        </tr>
      </tbody>
      <!-- /Table body -->
    </table>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
export default {

  name: 'TableComponent',
  props: {
    type: {
      type: String,
      default:() => {
        return ''
      }
    },
    tableItems: {
      type: Object,
      default:() => {
        return {}
      }
    },
    token: {
      type: String,
      default:() => {
        return ''
      }
    },
    cities: {
      type: Object,
      default:() => {
        return {}
      }
    }
  },
  data() {
    return {
      path: this.tableItems.path,
      examplePrice: [
        { name: '1 час', price: '1000'},
        { name: '2 часа', price: '1900'},
        { name: '3 часа', price: '2500'},
        { name: '8 часов', price: '6000'},
        { name: '24 часа', price: ''}
      ],
      companies: []
    };
  },
  computed: mapGetters(['allTransports', 'allTransportCompanies']),
  created() {
      // console.log(this.tableItems)
      // this.objects.push(this.tableItems)
  },
  methods: {
    ...mapMutations(['deleteTransport']),
    showMe() {
      console.log(this.tableItems)    
    },
    getEditLink(item) {
      return this.type + '/' + item.id + '/edit'
    },
    getDeleteLink(item) {
      return this.path + '/' +item.id
    },
    getCityName(cityId) {
      return this.cities.Россия[cityId]
    },
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

<style lang="scss" scoped>
.object-name {
  font-size: 16px;
}
.object-prices {
  font-size: 12px;
  color: #515151;
}
.price-table {
    th {
        border: none;
        padding: 6px;
        font-weight: initial;
    }
    td {
        padding: 6px;
        font-size: 12px;
        color: #515151;
    }
}
.price-table__link {
    text-decoration: underline;
    font-weight: initial;
    cursor: pointer;
}
</style>
