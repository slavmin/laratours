<template>
  <v-dialog 
    v-model="dialog" 
    persistent 
    max-width="600px"
  >
    <template v-slot:activator="{ on }">
      <v-btn  
        small
        fab
        outline
        class="edit-btn"
        color="green"
        dark 
        v-on="on"
      >
        <i class="material-icons">
          edit
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
            :id="'form' + item.id"
            :action="'/operator/customer-type/' + item.id"
            method="POST"
          >
            <input 
              type="hidden"
              name="_method"
              value="PATCH"
            >
            <input 
              type="hidden"
              name="_token"
              :value="token"  
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
                  color="green"
                  outline
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
          :form="'form' + item.id"
          type="submit"
        >
          Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {

  name: 'EditCustomerType',
  props: {
    header: {
      type: String,
      default: () => {
        return 'Редактировать'
      }
    },
    token: {
      type: String,
      default: () => {
        return ''
      }
    },
    item: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {
      dialog: false,
      name: '',
      description: '',
      url: '/operator/customer-type/' + this.item.id,
    };
  },
  created() {
  },
  mounted() {
    this.fillValues()
  },
  methods: {
    save() {
      let result = {
        '_token': this.token,
        '_method': 'PATCH',
        name: this.name,
        description: this.description

      }
      console.log(result)
      axios.post(this.url, result)
        .then(r => console.log(r))
        .catch(e => console.log(e))
      this.dialog = false
    },
    fillValues() {
      this.name = this.item.name
      this.description = this.item.description
    }
  }
};
</script>

<style lang="css" scoped>
</style>
