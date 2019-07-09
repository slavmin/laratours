<template>
  <div>
    <!-- Add button -->
    <button 
      title="Редактировать"
      class="btn btn-outline-success"
      data-toggle="modal" 
      data-target="#editTransportModal"
      data-backdrop="static"
    >
      <i 
        data-toggle="tooltip" 
        data-placement="top" 
        title="Редактировать" 
        class="fas fa-edit"
      />    
    </button>
    <!-- /Add button -->
    <!-- Modal -->
    <div 
      id="editTransportModal" 
      class="modal fade" 
      tabindex="-1" 
      role="dialog"
    >
      <div 
        class="modal-dialog modal-dialog-centered modal-dialog-scrollable" 
        role="document"
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5 
              id="exampleModalLabel"
              class="modal-title"
            >
              Редактирование транспорта
            </h5>
            <button 
              type="button" 
              class="close" 
              data-dismiss="modal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Edit transport form -->
            <form 
              @submit.prevent="edit" 
            >
              <div class="form-group">
                <label for="name">Название транспорта</label>
                <input 
                  id="name" 
                  v-model="name"
                  type="text" 
                  class="form-control" 
                  name="name" 
                  required 
                  autofocus
                >
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      Страна и город
                    </span>
                  </div>
                  <select 
                    id="country"
                    name="country" 
                    class="form-control"
                  >
                    <option value="1">
                      Россия
                    </option>
                  </select>
                  <select 
                    id="city_id" 
                    v-model="cityId"
                    name="city_id" 
                    class="form-control"
                    required
                  >
                    <option
                      v-for="(city, i) in cities.Россия"
                      :key="i" 
                      :value="i" 
                    >
                      {{ city }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="qnt">Вместимость</label>
                <input 
                  id="qnt"
                  v-model="qnt"
                  type="text" 
                  class="form-control" 
                  name="qnt" 
                  required="" 
                >
              </div>
              <div class="form-group">
                <label for="description">Описание</label>
                <input  
                  id="description"
                  v-model="description"
                  type="text" 
                  class="form-control" 
                  name="description"
                >
              </div>
              <div class="form-group">
                <label for="grade">Класс обслуживания</label>
                <select 
                  id="grade"
                  v-model="grade"
                  class="custom-select" 
                  name="grade" 
                  multiple
                  required="" 
                >
                  <option>Стандарт</option>
                  <option>C-class</option>
                  <option>VIP</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <div class="custom-file">
                  <input 
                    id="inputGroupFile04" 
                    type="file" 
                    class="custom-file-input" 
                  >
                  <label 
                    class="custom-file-label" 
                    for="inputGroupFile04"
                  >
                    Фото
                  </label>
                </div>
                <div class="input-group-append">
                  <button 
                    id="inputGroupFileAddon04"
                    class="btn btn-outline-secondary" 
                    type="button" 
                  >
                    Загрузить
                  </button>
                </div>
              </div>
              <div class="row container mb-4">
                <button 
                  type="button" 
                  class="btn btn-outline-primary" 
                  @click="showPrices = !showPrices"
                >
                  Цены
                </button>         
              </div>  
              <div 
                v-if="showForm.price"
                class="row container mb-4" 
              >
                Стоимость аренды, период действия цены, класс обслуживания 
                <br>Цена за 1 час 
                <br>Цена за 3 часа 
                <br>Цена за 8 часов 
                <br>Цена за сутки  (могут добавлять нужный параметр цены;
              </div>
              <button 
                type="submit" 
                class="btn btn-primary"
              >
                Сохранить
              </button>        
            </form>
            <!-- /Add transport form -->
          </div>
        </div>
        <!-- /Modal content -->
      </div>
    </div>
    <!-- /Modal -->
  </div>
</template>

<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
export default {

  name: 'EditTransportComponent',
  props: {
    type: {
      type: String,
      default: () => {
        return ''
      }
    },
    token: {
      type: String,
      default: () => {
        return ''
      }
    }, 
    cities: {
      type: Object,
      default: () => {
        return {}
      }
    },
    data: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },

  data() {
    return {
      name: '',
      qnt: '',
      grade: [],
      cityId: '',
      description: '',
      prices: [],
      selectedCountry: 'Россия',
      key: '',
      testObject: {
        '0': 'default',
        'Россия': {
          '1': 'Москва',
          '2': 'СПб'
        },
        'Чехия': {
          '3': 'Прага'
        }
      },
      showForm: {
        add: false,
        price: false,
        chooseTransportCompany: true,
        addTransportCompany: false,
        success: false
      },
      selectedTransportCompany: '',
      newTransportCompanyName: '',
      result: {
        name: '',
        qnt: '',
        grade: [],
        transportCompanyId: '',
        cityId: '',
        description: '',
        prices: []
      }
    }
  },
  created() {
    this.name = this.data.name
    this.qnt = this.data.qnt
    this.grade = this.data.grade
    this.cityId = this.data.cityId
    this.description = this.data.description
  },
  updated() {
  },
  mounted() {
  },
  methods: {
    ...mapMutations(['editTransport']),
    edit() {
      this.result.name = this.name
      this.result.qnt = this.qnt
      this.result.grade = this.grade
      this.result.cityId = this.cityId
      this.result.description = this.description
      this.result.prices = this.prices
      console.log(this.result)
      this.editTransport(this.result)
    },
    reset() {
      this.name = ''
      this.qnt = ''
      this.grade = []
      this.cityId = ''
      this.description = ''
      this.prices = []
      this.result = {
        name: '',
        qnt: '',
        grade: [],
        transportCompanyId: '',
        cityId: '',
        description: '',
        price: []
      }
      this.showForm = {
        add: false,
        price: false,
        chooseTransportCompany: false,
        addTransportCompany: false,
        success: true
      }
      setTimeout(() => {
        this.showForm = {
          add: false,
          price: false,
          chooseTransportCompany: true,
          addTransportCompany: false,
          success: false
        }
      }, 2000)    
    }
  }
};
</script>

<style lang="css" scoped>
</style>
