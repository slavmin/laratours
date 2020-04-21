<template>
  <v-card>
    <v-card-text>
      <v-container grid-list-md>
        <v-text-field
          v-model="name"
          label="Название"
          outline
          color="#aa282a"
          class="mb-3"
          @keyup.enter="submitForm"
        />
        <v-textarea
          v-model="description"
          name="description"
          label="Описание"
          rows="1"
          outline
          color="#aa282a"
          class="mb-3"
        />
        <v-form
          :id="'form' + tourObject.id"
          ref="form"
          lazy-validation
          :action="
            editMode
              ? `/operator/attribute/${objectAttribute.id}`
              : '/operator/attribute'
          "
          method="POST"
        >
          <input v-if="editMode" type="hidden" name="_method" value="PATCH" />
          <input type="hidden" name="_token" :value="token" />
          <input type="hidden" name="parent_model_id" :value="tourObject.id" />
          <input type="hidden" name="parent_model_alias" value="hotel" />
          <input v-model="name" type="hidden" name="name" />
          <input v-model="description" type="hidden" name="description" />
        </v-form>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn color="#aa282a" dark type="submit" :form="'form' + tourObject.id">
        Сохранить
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
export default {
  name: 'HotelObjectable',
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
    }
  },
  mounted() {
    if (this.editMode) this.parseInfo()
  },
  methods: {
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
      const form = document.getElementById(`form${this.tourObject.id}`)
      form.submit()
    },
  },
}
</script>