<template>
  <v-card>
    <v-card-title>
      <v-text-field v-model="name" name="name" label="Название документа" />
    </v-card-title>
    <v-card-text>
      <v-text-field v-model="description" name="description" label="Описание" />
      <input v-model="content" type="hidden" name="template" />
      <Editor v-model="content" :api-key="tiny.apiKey" :init="tiny.init" />
    </v-card-text>
  </v-card>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'
export default {
  name: 'DocumentForm',
  components: {
    Editor,
  },
  props: {
    editMode: {
      type: Boolean,
      default: false,
    },
    document: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
  data() {
    return {
      name: '',
      description: '',
      content: '',
      tiny: {
        apiKey: 'x7zbaypkm5jwplpkson0mxhq5w59oxtrrudgxphqx8llayfd',
        init: {
          min_width: '600',
          branding: false,
          language: 'ru',
          language_url: '/fonts/vendor/tinymce/ru.js',
          height: 500,
          plugins: 'table link print',
          default_link_target: '_blank',
        },
      },
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
    },
  },
}
</script>