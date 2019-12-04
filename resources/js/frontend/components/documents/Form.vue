<template>
  <v-card>
    <v-card-title>
      <v-text-field
        v-model="name"
        name="name"
        label="Название документа"
      />
    </v-card-title>
    <v-card-text>
      <v-text-field
        v-model="description"
        name="description"
        label="Описание"
      />
      <v-textarea
        v-model="content"
        outline
        name="template"
      />
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'DocumentForm',
  props: {
    editMode: {
      type: Boolean,
      default: false,
    },
    document: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {
        name: '',
        description: '',
        content: '',
    }
  },
  mounted() {
    if (this.editMode) this.fill()
  },
  methods: {
    fill() {
      this.name = this.document.name
      this.description = this.document.description
      this.content = this.document.template
    }
  }
}
</script>