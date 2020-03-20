<template>
  <div>
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
      <template v-slot:activator="{ on }">
        <v-btn
          :icon="editMode"
          :fab="!editMode"
          small
          :color="editMode ? 'yellow' : '#aa282a'"
          :title="(editMode ? 'Редактировать' :'Добавить') + ' питание'"
          dark
          v-on="on"
        >
          <i class="material-icons">
            {{ editMode ? 'edit' : 'add' }}
          </i>
        </v-btn>
      </template>
      <v-card>
        <v-card-title style="background-color: #66a5ae;">
          <v-layout
            column
            wrap
            class="white--text"
          >
            <h3 class="mb-4">
              <svg
                style="width:24px;height:24px"
                viewBox="0 0 24 24"
              >
                <path
                  fill="white"
                  d="M19,7H11V14H3V5H1V20H3V17H21V20H23V11A4,4 0 0,0 19,7M7,13A3,3 0 0,0 10,10A3,3 0 0,0 7,7A3,3 0 0,0 4,10A3,3 0 0,0 7,13Z"
                />
              </svg>
              {{ tourObject.name }}
            </h3>
            <h4>{{ editMode ? 'Редактировать' :'Добавить' + ' питание' }}</h4>
          </v-layout>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-form
              :id="'form' + tourObject.id"
              ref="form"
              v-model="valid"
              :action="editMode ? `/operator/attribute/${objectAttribute.id}` : '/operator/attribute'"
              method="POST"
            >
              <input
                v-if="editMode"
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
                name="parent_model_id"
                :value="tourObject.id"
              >
              <input
                type="hidden"
                name="parent_model_alias"
                value="meal"
              >
              <v-text-field
                v-model="name"
                name="name"
                label="Название"
                outline
                color="#aa282a"
                class="mb-3"
                :rules="[v => !!v || 'Заполните']"
                required
              />
              <v-text-field
                v-model="description"
                name="description"
                label="Описание"
                outline
                color="#aa282a"
                class="mb-3"
              />
            </v-form>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-btn
            color="#aa282a"
            text
            dark
            @click="close"
          >
            Закрыть
          </v-btn>
          <v-spacer />
          <v-btn
            color="#aa282a"
            dark
            @click="submitForm"
          >
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: 'MealObjectable',
  props: {
    tourObject: {
      type: Object,
      required: true,
      default: null,
    },
    objectAttribute: {
      type: Object,
      default: null,
    },
    objectAttributePrices: {
      type: Array,
      default: null,
    },
    token: {
      type: String,
      required: true,
      default: null,
    },
    customers: {
      type: Object,
      default: () => {
        return {}
      },
    },
    editMode: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      dialog: false,
      name: '',
      description: '',
      valid: false,
    }
  },
  mounted() {
    if (this.editMode) this.parseInfo()
  },
  methods: {
    validate() {
      this.$refs.form.validate()
    },
    close() {
      if (this.editMode) {
        this.parseInfo()
        this.dialog = false
      }
      if (!this.editMode) {
        this.name = ''
      }
      this.dialog = false
    },
    parseInfo() {
      this.name = this.objectAttribute.name
      this.description = this.objectAttribute.description
    },
    submitForm() {
      this.validate()
      if (this.valid) {
        const form = document.getElementById(`form${this.tourObject.id}`)
        form.submit()
      }
    },
  },
}
</script>