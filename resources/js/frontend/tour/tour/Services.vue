<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
    >
      <v-flex xs12>
        <FreeAdl />
      </v-flex>
      <v-flex xs12>
        <v-layout
          row
          wrap
          justify-center
          mt-5
        >
          <h3 class="grey--text">
            Доп. услуги: ({{ getCustomPrice.length }})
            <v-btn
              color="#aa282a"
              fab
              small
              dark
              @click="showCustomPrice = !showCustomPrice"
            >
              <v-icon>
                expand_{{ showCustomPrice ? 'less' : 'more' }}
              </v-icon>
            </v-btn>
          </h3>
        </v-layout>
        <v-layout
          v-show="showCustomPrice"
          row
          wrap
          justify-center
        >
          <v-flex
            v-if="showTable"
            xs12
          >
            <table class="custom-price-table">
              <thead>
                <th>
                  Услуга
                </th>
                <th>
                  Стоимость
                </th>
                <th>
                  Действия
                </th>
              </thead>
              <tbody>
                <tr
                  v-for="price in getCustomPrice"
                  :key="price.name"
                >
                  <td>
                    {{ price.name }}
                  </td>
                  <td>
                    {{ price.value }}
                  </td>
                  <td>
                    <v-btn
                      color="red"
                      fab
                      small
                      dark
                      @click="removeCustomPrice(price.id)"
                    >
                      <i class="material-icons">
                        delete
                      </i>
                    </v-btn>
                  </td>
                </tr>
              </tbody>
            </table>
          </v-flex>
        </v-layout>
        <v-layout
          v-show="showCustomPrice"
          row
          wrap
          mt-5
          justify-center
        >
          <v-flex
            xs3
            mr-5
          >
            <v-text-field
              v-model="customPrice.name"
              label="Название"
              placeholder="доп. услуга"
              outline
            />
          </v-flex>
          <v-flex
            xs2
            mr-5
          >
            <v-text-field
              v-model="customPrice.value"
              label="Цена"
              mask="########"
              outline
            />
          </v-flex>
          <v-btn
            fab
            small
            title="Добавить"
            color="#aa282a"
            dark
            @click="addCustomService"
          >
            <i class="material-icons">
              add
            </i>
          </v-btn>
        </v-layout>
        <v-divider />
        <ExtraEvents />
        <v-divider />
        <h3 class="grey--text mt-5">
          Редакторы:
        </h3>
        <v-layout
          row
          justify-center
        >
          <v-btn
            v-if="!dialogFillEditors"
            color="#aa282a"
            dark
            @click="dialogFillEditors = true"
          >
            Заполнить
          </v-btn>
          <v-card v-if="dialogFillEditors">
            <v-card-title
              class="headline white--text"
              style="background-color: #66a5ae;"
            >
              Автоматическое заполнение редакторов
            </v-card-title>
            <v-card-text class="body-1">
              <p>
                Редакторы будут очищены и заново заполнены информацией по туру.
              </p>
              <p>
                Введённая вручную информация не сохранится
              </p>
              <p class="body-2">
                Вы уверены, что хотите продолжить?
              </p>
            </v-card-text>
            <v-card-actions>
              <v-btn
                color="#aa282a"
                dark
                @click="dialogFillEditors = false"
              >
                Нет
              </v-btn>
              <v-spacer />
              <v-btn
                color="#aa282a"
                dark
                @click="fillEditorsContent"
              >
                Да, заполнить редакторы
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-layout>
        <v-layout
          row
          wrap
          justify-center
        >
          <v-flex xs10>
            <div
              v-for="(item,i) in editorsControl.length"
              :key="parseInt(i)"
              class="mb-5"
            >
              <h3>День {{ i + 1 }}</h3>
              <Editor
                :id="'editor-day-' + i"
                v-model="getTour.editorsContent[i]"
                :api-key="tiny.apiKey"
                :init="tiny.init"
                class="editor"
              />
            </div>
          </v-flex>
        </v-layout>
      </v-flex>
      <v-btn
        dark
        fab
        class="done-btn"
        color="#aa282a"
        @click="done"
      >
        <i class="material-icons">
          arrow_forward
        </i>
      </v-btn>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Editor from '@tinymce/tinymce-vue'
import FreeAdl from './FreeAdl'
import ExtraEvents from './ExtraEvents'
export default {
  name: 'Services',
  components: {
    Editor,
    FreeAdl,
    ExtraEvents,
  },
  data() {
    return {
      customPrice: {
        name: '',
        value: NaN,
      },
      tiny: {
        apiKey: 'x7zbaypkm5jwplpkson0mxhq5w59oxtrrudgxphqx8llayfd',
        init: {
          min_width: '600',
          branding: false,
          language: 'ru',
          language_url: '/fonts/vendor/tinymce/ru.js',
          height: 500,
          plugins: 'table link print',
          default_link_target: '_blank',
        },
      },
      dialog: false,
      dialogFillEditors: false,
      editorsContent: [],
      showCustomPrice: false,
    }
  },
  computed: {
    ...mapGetters(['getTour', 'getCustomPrice']),
    showTable: function() {
      return this.getCustomPrice.length == 0 ? false : true
    },
    editorsControl: function() {
      let result = []
      for (let i = 0; i < parseInt(this.getTour.options.days); i++) {
        result.push({
          dialog: false,
        })
      }
      return result
    },
  },
  watch: {
    editorsContent: {
      handler(value) {
        this.updateEditorsContent(value)
      },
    },
  },
  created() {},
  updated() {
    this.getCustomPrice
  },
  mounted() {
    console.log('services mounted')
    // this.fillEditorsContent()
    console.log(this.editorsContent)
  },
  methods: {
    ...mapActions([
      'updateConstructorCurrentStage',
      'updateCustomPrice',
      'updateConstructorCurrentStage',
      'updateEditorsContent',
      'removeCustomPrice',
    ]),
    addMoreGuide() {
      this.updateConstructorCurrentStage('Hotel is set')
    },
    addMoreAttendant() {
      this.updateConstructorCurrentStage('Show attendant')
    },
    addCustomService() {
      if (this.customPrice.name != '' && this.customPrice.value != NaN) {
        this.updateCustomPrice(this.customPrice)
        this.customPrice = {
          name: '',
          value: NaN,
        }
      }
    },
    done() {
      this.$emit('scrollme')
      this.updateConstructorCurrentStage('Show summary')
    },
    fillEditorsContent() {
      this.dialogFillEditors = false
      this.updateEditorsContent([])
      let result = []
      let days = []
      let string = ''
      for (let i = 0; i < this.editorsControl.length; i++) {
        string = `<h2>День ${i + 1}:<h2>`
        if (this.getTour.transport.length > 0) {
          string += '<h3>Транспорт:</h3><p>'
          this.getTour.transport.forEach(transport => {
            transport.obj.daysArray.forEach(day => {
              if (day == i + 1) {
                string += transport.obj.name
              }
            })
          })
          string += '</p>'
        }
        if (this.getTour.museum.length > 0) {
          string += '<h3>Экскурсии:</h3><p>'
          this.getTour.museum.forEach(museum => {
            if (museum.obj.day == i + 1) {
              string += `${museum.museum.name}: ${museum.obj.name}<br>`
            }
          })
          string += '</p>'
        }
        if (this.getTour.hotel.length > 0) {
          string += '<h3>Проживание:</h3><p>'
          this.getTour.hotel.forEach(hotel => {
            hotel.obj.daysArray.forEach(day => {
              if (day == i + 1) {
                string += `${hotel.hotel.name}: ${hotel.obj.name}<br>`
              }
            })
          })
          string += '</p>'
        }
        if (this.getTour.meal.length > 0) {
          string += '<h3>Питание:</h3><p>'
          this.getTour.meal.forEach(meal => {
            meal.obj.daysArray.forEach(day => {
              if (day == i + 1) {
                string += `${meal.meal.name}: ${meal.obj.name}<br>`
              }
            })
          })
          string += '</p>'
        }
        if (this.getTour.guide.length > 0) {
          string += '<h3>Гид:</h3><p>'
          this.getTour.guide.forEach(guide => {
            string += `${guide.guide.name} `
          })
          string += '</p>'
        }
        string += '<hr>'
        if (this.getTour.attendant.length > 0) {
          string += '<h3>Сопроводжающий:</h3><p>'
          this.getTour.attendant.forEach(attendant => {
            string += `${attendant.attendant.name} `
          })
          string += '</p>'
        }
        if (this.getTour.customPrice.length > 0) {
          string += '<h3>Допы:</h3><p>'
          this.getTour.customPrice.forEach(customPrice => {
            string += `${customPrice.name} `
          })
          string += '</p>'
        }
        string += '<hr>'
        result.push(string)
      }
      this.updateEditorsContent(result)
    },
  },
}
</script>

<style lang="scss" scoped>
.custom-price-table {
  margin: 0 auto;
  td,
  th {
    border: 1px solid gray;
    padding: 16px;
    font-size: 24px;
  }
  td {
    background-color: #ffab16;
    color: white;
  }
}
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
