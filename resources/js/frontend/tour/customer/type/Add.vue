<template>
  <v-container>
    <v-layout 
      row 
      justify-end
    >
      <v-dialog 
        v-model="dialog" 
        persistent 
        max-width="600px"
      >
        <template v-slot:activator="{ on }">
          <v-btn 
            fab
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
              <form 
                id="form"
                @submit.prevent="save"
              >
                <v-layout wrap>
                  <v-flex 
                    xs12 
                    sm6 
                  >
                    <v-text-field 
                      v-model="name"
                      label="Название" 
                      color="green"
                      outline
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
                      outline
                      color="green"
                    />
                  </v-flex>
                </v-layout>
              </form>
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
              type="submit"
              form="form"
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

  name: 'AddCustomerType',
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
      axios.post('/operator/customer-type', result)
        .then(r => {
          this.name = ''
          this.description = ''
          this.dialog = false
        })
        .catch(e => console.log(e))  
    }
  }
};
</script>

<style lang="css" scoped>
</style>
