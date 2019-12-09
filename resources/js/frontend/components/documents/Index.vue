<template>
  <v-container 
    fluid
    grid-list-md
    text-xs-center
    style="background-color: #66a5ae;"
  >
    <v-layout 
      row 
      wrap
      justify-center
    >  
      <v-flex> 
        <h1 class="text-center white--text mb-5">
          <v-icon
            dark
            large
          >
            view_list
          </v-icon>
          Документы
        </h1>
        <v-btn 
          color="#aa282a" 
          fab
          dark 
          :href="createLink"
        >
          <i class="material-icons">
            add
          </i>         
        </v-btn>
      </v-flex>
    </v-layout>
    <v-layout
      row 
      wrap
      justify-center
    >
      <v-card>
        <table>
          <thead>
            <th>
              Название
            </th>
            <th>
              Описание
            </th>
            <th>
              Доступ
            </th>
            <th>
              Действия
            </th>
          </thead>
          <tbody>
            <tr
              v-for="document in documents"
              :key="document.id"
            >
              <td>
                {{ document.name }}
              </td>
              <td>
                {{ document.description }}
              </td>
              <td>
                {{ parseInt(document.pdfIsActive) ? 'PDF' : '' }}
                {{ parseInt(document.wordIsActive) ? 'Word' : '' }}
              </td>
              <td>
                <v-layout 
                  row 
                  wrap
                >
                  <Preview 
                    :document="document"
                  />
                  <MakePDF
                    :document="document"
                  />
                  <MakeWord
                    :document="document"
                  />
                  <v-btn 
                    color="yellow"
                    fab
                    small
                    :href="`/modules/document/${document.id}/edit`"
                  >
                    <v-icon>
                      edit
                    </v-icon>
                  </v-btn>
                  <form 
                    :action="`/modules/document/${document.id}`"
                    method="POST"
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
                      color="red"
                      fab
                      small
                      type="submit"
                    >
                      <v-icon>
                        close
                      </v-icon>
                    </v-btn>
                  </form>
                </v-layout>
              </td>
            </tr>
          </tbody>
        </table>
      </v-card>
    </v-layout>
  </v-container>
</template>
<script>
import Preview from './Preview'
import MakePDF from './MakePDF'
import MakeWord from './MakeWord'
export default {
  name: 'DocumentsIndex',
  components: {
    Preview,
    MakePDF,
    MakeWord,
  },
  props: {
    token: {
      type: String,
      default: '',
    },
    createLink: {
      type: String,
      default: '#',
    },
    editLink: {
      type: String,
      default: '#',
    }
  },
  data() {
      return {
        documents: [],
      }
  },
  mounted() {
    this.fetch()
  },
  methods: {
    fetch() {
      axios.get(`/modules/document`)
        .then((response) => {
          this.documents = response.data.data
          console.log(this.documents)
        })
    },
  }
}
</script>

<style lang="scss" scoped>
table {
  td,
  th {
    font-size: 16px;
    padding: 12px;
  }
  th {
    border-bottom: 2px solid #cac8c9;
    color: #cac8c9;;
    padding-top: 24px;
    padding-bottom: 36px;
    font-size: 16px;
    font-weight: normal;
  }
}
</style>