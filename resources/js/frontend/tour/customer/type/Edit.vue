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
      <v-card-title style="background-color: #66a5ae;">
        <span class="headline white--text">
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
              v-if="!isPens"
              row
              wrap
            >
              <v-flex xs6>
                <v-text-field
                  v-model="ageFrom"
                  label="От"
                  mask="##"
                  outline
                  color="#aa282a"
                />
              </v-flex>
              <v-flex xs6>
                <v-text-field
                  v-model="ageTo"
                  label="До"
                  mask="##"
                  outline
                  color="#aa282a"
                />
              </v-flex>
            </v-layout>
            <v-layout
              v-if="isPens"
              row
              wrap
            >
              <v-flex xs6>
                <h5>Мужчины</h5>
                <v-text-field
                  v-model="agePensMale"
                  label="От"
                  mask="##"
                  outline
                  color="#aa282a"
                />
              </v-flex>
              <v-flex xs6>
                <h5>Женщины</h5>
                <v-text-field
                  v-model="agePensFemale"
                  label="От"
                  mask="##"
                  outline
                  color="#aa282a"
                />
              </v-flex>
            </v-layout>
            <v-layout
              row
              wrap
            >
              <v-flex xs12>
                <v-checkbox
                  v-model="isPens"
                  color="#aa282a"
                  label="Пенсионер"
                />
              </v-flex>
            </v-layout>
          </form>
        </v-container>
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn
          color="#aa282a"
          dark
          @click="close"
        >
          Закрыть
        </v-btn>
        <v-btn
          color="#aa282a"
          dark
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
      },
    },
    token: {
      type: String,
      default: () => {
        return ''
      },
    },
    item: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
  data() {
    return {
      dialog: false,
      name: '',
      ageFrom: 0,
      ageTo: 0,
      isPens: false,
      agePensMale: 0,
      agePensFemale: 0,
    }
  },
  computed: {
    customerAgeRange: function() {
      let result = {}
      if (!this.isPens) {
        return {
          ageFrom: parseInt(this.ageFrom),
          ageTo: parseInt(this.ageTo),
          isPens: this.isPens,
        }
      }
      if (this.isPens) {
        return {
          isPens: true,
          agePensMale: parseInt(this.agePensMale),
          agePensFemale: parseInt(this.agePensFemale),
        }
      }
      return result
    },
    description: function() {
      if (this.ageFrom == 0 && this.ageTo == 0 && !this.isPens) {
        return null
      }
      return JSON.stringify(this.customerAgeRange)
    },
  },
  mounted() {
    this.fillValues()
  },
  methods: {
    fillValues() {
      this.name = this.item.name
      let description
      if (this.item.description) {
        description = JSON.parse(this.item.description)
      }
      if (description) {
        if (!description.isPens) {
          this.ageFrom = description.ageFrom
          this.ageTo = description.ageTo
        }
        if (description.isPens) {
          this.isPens = description.isPens
          this.agePensMale = description.agePensMale
          this.agePensFemale = description.agePensFemale
        }
      } else {
        this.ageFrom = 0
        this.ageTo = 0
        this.isPens = false
        this.agePensMale = 0
        this.agePensFemale = 0
      }
    },
    close() {
      this.fillValues()
      this.dialog = false
    },
  },
}
</script>

<style lang="css" scoped>
</style>
