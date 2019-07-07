<template>
  <div>
    <!-- <h5>hi from table!</h5> -->
    <!-- <button class="btn btn-primary" v-on:click="showMe">Show me value at console</button> -->
    <bus-scheme-component />
    <!-- <example-component></example-component> -->
    <table class="table table-hover mt-2">
      <!-- Table header -->
      <thead>
        <th>Название</th>
        <th class="text-center">
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
          v-for="item in tableItems.data"
          :key="item.id"
        >
          <!-- Object name and price -->
          <td>
            <div>
              {{ item.name }}
            </div>
            <table class="price-table ml-5">
              <thead>
                <th />
                <th>
                  <transport-price-component />
                </th>
              </thead>
              <tbody>
                <tr 
                  v-for="price in examplePrice"
                  :key="price.id"
                >
                  <td>
                    {{ price.name }}
                  </td>
                  <td class="text-right">
                    {{ price.price }}₽
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <!-- /Object name and price -->
          <!-- City -->
          <td class="align-middle text-center">
            {{ getCityName(item.city_id) }}
          </td>
          <!-- /City -->
          <!-- Quantity -->
          <td class="align-middle text-center">
            <div>{{ item.qnt }}</div>
            <div>
              <a href="#">Схема салона</a>
              <!-- <bus-scheme-component></bus-scheme-component> -->
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
              <div class="ml-1">
                <!-- Edit button -->
                <a 
                  :href="getEditLink(item)"
                  class="btn btn-outline-success"
                >
                  <i 
                    data-toggle="tooltip" 
                    data-placement="top" 
                    title="Редактировать" 
                    class="fas fa-edit"
                  />    
                </a>
                <!-- /Edit button -->
                <!-- Delete button -->
                <form 
                  :action="getDeleteLink(item)" 
                  method="post" 
                  style="display: inline-block;"
                >
                  <input 
                    type="hidden" 
                    name="_token" 
                    :value="token"
                  >
                  <input 
                    type="hidden" 
                    name="_method" 
                    value="DELETE"
                  >
                  <button 
                    title="Удалить" 
                    class="btn btn-outline-danger"
                  >
                    <i class="far fa-trash-alt" />
                  </button>
                </form>
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
      ]
    };
  },
  created() {
      // console.log(this.tableItems)
      // this.objects.push(this.tableItems)
  },
  methods: {
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
    }
  }
};
</script>

<style lang="scss" scoped>
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
