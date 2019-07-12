<template>
  <v-container>
    <v-layout 
      row 
      justify-center
    >
      <v-dialog 
        v-model="dialog" 
        persistent 
        max-width="600px"
      >
        <template v-slot:activator="{ on }">
          <v-btn 
            color="green" 
            dark 
            v-on="on"
          >
            <i class="material-icons">
              add
            </i>
          </v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">
              {{ header }}
            </span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex 
                  xs12 
                  sm6 
                >
                  <v-text-field 
                    v-model="name"
                    label="Название" 
                    color="green"
                    required
                  />
                </v-flex>
                <v-flex 
                  xs12 
                  sm6
                >
                  <v-text-field 
                    v-model="description"
                    label="Описание" 
                    color="green"
                  />
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn 
              color="green" 
              flat 
              @click="dialog = false"
            >
              Закрыть
            </v-btn>
            <v-btn 
              color="green" 
              flat 
              @click="save"
            >
              Сохранить
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>

<script>
export default {

  name: 'IndexCustomerType',
  props: {
    header: {
      type: String,
      default: () => {
        return 'Создать'
      }
    },
    token: {
      type: String,
      default: () => {
        return ''
      }
    }
  },
  data() {
    return {
      dialog: false,
      name: '',
      description: '',
    };
  },
  methods: {
    save() {
      let result = {
        '_token': this.token,
        name: this.name,
        description: this.description

      }
      console.log(result)
      axios.post('http://127.0.0.1:8000/operator/customer-type', result)
        .then(r => console.log(r))
        .catch(e => console.log(e))
      this.dialog = false
    }
  }
};
</script>

<style lang="css" scoped>
</style>
