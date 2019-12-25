<template>
  <v-container>
    <h3 class="text-xs-center grey--text">
      Программа тура
    </h3>
    <Editor 
      id="editor"
      v-model="editor"
      :api-key="tiny.apiKey"
      :init="tiny.init"
    />
  </v-container>
</template>
<script>
import Editor from '@tinymce/tinymce-vue'
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'PartnerTourEditor',
  components: {
    Editor,
  },
  data() {
    return {
      tiny: {
        apiKey: 'x7zbaypkm5jwplpkson0mxhq5w59oxtrrudgxphqx8llayfd',
        init: {
          min_width: '600',
          branding: false, 
          language: 'ru',
          language_url: '/fonts/vendor/tinymce/ru.js',
          height: 500,
          plugins: "table",
        }
      },
      editor: '',
    }
  },
  computed: {
    ...mapGetters([
      'getEditMode',
      'getPartnerTour',
    ])
  },
  watch: {
    editor: function() {
      this.getPartnerTour.editor = this.editor
      this.updateEditorsContent([this.editor])
    }
  },
  mounted() {
    if (this.getEditMode) {
      this.editor = this.getPartnerTour.editor
    }
  },
  methods: {
    ...mapActions(['updateEditorsContent']),
  }
}
</script>