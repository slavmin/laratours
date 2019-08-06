<template>
  <div>
    <v-layout 
      row 
      wrap
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
        <v-layout 
          row 
          wrap
          justify-end
        >
          <v-flex xs2> 
            <v-btn 
              dark
              color="green"
              @click="done"
            >
              OK
            </v-btn>
          </v-flex>
        </v-layout>
      </v-flex>
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
      editorsContent: [], 
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
  },
  created() {
  },
  updated() {
    this.getCustomPrice
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
      this.updateEditorsContent(this.editorsContent)
      console.log(this.getTour)
      this.updateConstructorCurrentStage('Show summary')
    }
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
</style>
