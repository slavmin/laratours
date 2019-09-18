<template>
  <div>
    <v-layout 
      row 
      wrap
      class="wrap"
    >
      <v-flex xs12>
        <v-layout 
          row 
          wrap
          justify-content-center
        >
          <v-btn 
            dark 
            color="green"
            @click="addMoreGuide"
          >
            Добавить гида
          </v-btn>
          <v-btn 
            dark 
            color="green"
            @click="addMoreAttendant"
          >
            Добавить сопровождающего
          </v-btn>
        </v-layout>
      </v-flex>
      <v-flex xs12>
        <v-layout 
          row 
          wrap
          justify-center
          mt-5
        >
          <h3 class="grey--text">
            Доп. услуги:
          </h3>
        </v-layout>
        <v-layout 
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
            color="green"
            dark 
            @click="addCustomService"
          >
            <i class="material-icons">
              add
            </i>
          </v-btn>
        </v-layout>
        <v-layout 
          row 
          wrap
          justify-center
        >
          <v-flex 
            v-if="showTable"
            xs12
          >
            <table class="summary">
              <thead>
                <th>
                  Услуга
                </th>
                <th>
                  Стоимость
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
                </tr>
              </tbody>
            </table>
          </v-flex>
        </v-layout>
        <h3 
          class="grey--text"
          mt-5
        >
          Редакторы:
        </h3>
        <v-layout 
          row 
          wrap
          justify-center
        >
          <v-flex xs8>
            <v-expansion-panel popout>
              <v-expansion-panel-content
                v-for="(item,i) in editorsCount"
                :key="parseInt(i)"
              >
                <template v-slot:header>
                  <h5 class="subheading">
                    Программа на день: {{ i + 1 }}
                  </h5>
                </template>
                <v-card>
                  <v-card-text>
                    <Editor 
                      :id="'editor-day-' + i"
                      v-model="editorsContent[i]"
                      :api-key="tiny.apiKey"
                      :init="tiny.init"
                      class="editor"
                    />
                  </v-card-text>
                </v-card>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-flex>
        </v-layout>
      </v-flex>
      <v-btn 
        dark
        fab
        class="done-btn"
        color="green"
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
export default {

  name: 'Services',
  components: {
    Editor,
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
          // plugins: 'wordcount', 
          min_width: '500px',
          branding: false, 
        }
      },
    };
  },
  computed: {
    ...mapGetters([
      'getTour',
      'getCustomPrice',
    ]),
    showTable: function() {
      return this.getCustomPrice.length == 0 ? false : true
    },
    editorsCount: function() {
      return parseInt(this.getTour.options.days)
    },
    editorsContent: function() {
      let result = []
      let days = []
      let string = ''
      for (let i = 0; i < this.editorsCount; i++) {
        string = `<h2>День ${i + 1}:<h2>`
        if (this.getTour.transport.length > 0) {
          string += '<h3>Транспорт:</h3><p>'
          this.getTour.transport.forEach((transport) => {
            if (transport.obj.day == (i + 1)) {
              string += transport.obj.name
            }
          })
          string += '</p>'
        }
        if (this.getTour.museum.length > 0) {
          string += '<h3>Экскурсии:</h3><p>'
          this.getTour.museum.forEach((museum) => {
            if (museum.obj.day == (i + 1)) {
              string += `${museum.museum.name}: ${museum.obj.name}`
            }
          })
          string += '</p>'
        }
        if (this.getTour.hotel.length > 0) {
          string += '<h3>Проживание:</h3><p>'
          this.getTour.hotel.forEach((hotel) => {
            if (hotel.obj.day == (i + 1)) {
              string += `${hotel.hotel.name}: ${hotel.obj.name}`
            }
          })
          string += '</p>'
        }
        if (this.getTour.meal.length > 0) {
          string += '<h3>Питание:</h3><p>'
          this.getTour.meal.forEach((meal) => {
            if (meal.obj.day == (i + 1)) {
              string += `${meal.meal.name}: ${meal.obj.name}`
            }
          })
          string += '</p>'
        }
        if (this.getTour.guide.length > 0) {
          string += '<h3>Гид:</h3><p>'
          this.getTour.guide.forEach((guide) => {
            string += `${guide.guide.name} `
          })
          string += '</p>'
        }
        string += '<hr>'
        result.push(string)
      }
      console.log('editors content: ', result)
      return result
    },
  },
  created() {
  },
  updated() {
    this.getCustomPrice
    console.log(this.editorsContent)
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
      this.updateEditorsContent(this.editorsContent)
      console.log(this.getTour)
      this.updateConstructorCurrentStage('Show summary')
    },
    // fillEditorsContent() {
    //   for (let i = 0; i < 2; i++) {
    //     this.editorsContent[i] = 'test' + i
    //   }
    // },
  },
};
</script>

<style lang="scss" scoped>
.summary {
  margin: 0 auto;
  td,
  th {
    border: 1px solid gray;
    padding: 16px;
    font-size: 24px;
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
