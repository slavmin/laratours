<template>

</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'PartnerTourEditor',
  components: {
    Editor,
  },
  data() {
    return {}
  },
  computed: {
    ...mapGetters(['getEditMode', 'getPartnerTour']),
  },

  mounted() {
    if (this.getEditMode) {
      this.editor = this.getPartnerTour.editor
    }
  },
  methods: {
    ...mapActions(['updateEditorContent']),
  },
}
</script>