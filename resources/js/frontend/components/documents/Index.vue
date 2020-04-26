<template>
  <v-container fluid grid-list-md text-xs-center>
    <h1 class="text-center white--text mb-5">
      <v-icon dark large>
        view_list
      </v-icon>
      Документы
    </h1>
    <v-row justify="center" class="mb-5">
      <v-btn color="#aa282a" fab dark :href="createLink">
        <i class="material-icons">
          add
        </i>
      </v-btn>
    </v-row>
    <v-row justify="center">
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
              Действия
            </th>
          </thead>
          <tbody>
            <tr v-for="document in documents" :key="document.id">
              <td>
                {{ document.name }}
              </td>
              <td>
                {{ document.description }}
              </td>
              <td>
                <v-row row wrap>
                  <v-btn
                    color="yellow"
                    icon
                    :href="`/operator/modules/document/${document.id}/edit`"
                  >
                    <v-icon>
                      edit
                    </v-icon>
                  </v-btn>
                  <form
                    :action="`/operator/modules/document/${document.id}`"
                    method="POST"
                  >
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="_token" :value="token" />
                    <v-btn color="red" icon type="submit">
                      <v-icon>
                        close
                      </v-icon>
                    </v-btn>
                  </form>
                </v-row>
              </td>
            </tr>
          </tbody>
        </table>
      </v-card>
    </v-row>
  </v-container>
</template>
<script>
// import Preview from './Preview'
export default {
  name: 'DocumentsIndex',
  components: {
    // Preview,
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
    },
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
      axios.get(`document`).then(response => {
        this.documents = response.data.data
      })
    },
  },
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
    color: #cac8c9;
    padding-top: 24px;
    padding-bottom: 36px;
    font-size: 16px;
    font-weight: normal;
  }
}
</style>