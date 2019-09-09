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
                action="/operator/customer-type"
                method="POST"
              >
                <input 
                  type="hidden"
                  name="_token"
                  :value="token"
                >
                <input 
                  type="hidden"
                  name="description"
                  :value="description"
                >
                <v-text-field 
                  v-model="name"
                  name="name"
                  label="Название" 
                  color="green"
                  outline
                  required
                />
                <h4>Возраст</h4>
                <v-layout 
                  row 
                  wrap
                >
                  <v-flex xs6>
                    <v-text-field 
                      v-model="ageFrom"
                      label="От" 
                      mask="##"
                      outline
                      color="green"
                    />
                  </v-flex>
                  <v-flex xs6>
                    <v-text-field 
                      v-model="ageTo"
                      label="До" 
                      mask="##" 
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
              @click="close"
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
      ageFrom: 0,
      ageTo: 0,
    };
  },
  computed: {
    description: function() {
      let result = {
        ageFrom: parseInt(this.ageFrom),
        ageTo: parseInt(this.ageTo)
      }
      if (this.ageFrom == 0 && this.ageTo == 0) {
        return null
      }
      return JSON.stringify(result)
    }
  },
  methods: {
    close() {
      this.name = ''
      this.ageFrom = 0 
      this.ageTo = 0
      this.dialog = false
    },
  }
};
</script>

<style lang="css" scoped>
</style>
