<template>
  <div>
    <h2>Доступ</h2>
    <v-layout
      row
      wrap
    >
      <v-flex>
        <v-switch 
          v-model="pdfIsActive"
          color="#aa282a"
          label="PDF"  
        />
        <input
          type="hidden"
          name="pdfIsActive"
          :value="pdfIsActiveParsed"
        >
      </v-flex>
      <v-flex>
        <v-switch 
          v-model="wordIsActive"
          color="#aa282a"
          label="word"  
        />
        <input
          type="hidden"
          name="wordIsActive"
          :value="wordIsActiveParsed"
        >
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
export default {
  name: 'DocumentControls',
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
      pdfIsActive: false,
      wordIsActive: false,
    }
  },
  computed: {
    pdfIsActiveParsed: function() {
      if (this.pdfIsActive) {
        return 1
      }
      return 0
    },
    wordIsActiveParsed: function() {
      if (this.wordIsActive) {
        return 1
      }
      return 0
    }
  },
  mounted() {
    if (this.editMode) this.fill()
  },
  methods: {
    fill() {
      this.pdfIsActive = parseInt(this.document.pdfIsActive)
      this.wordIsActive = parseInt(this.document.wordIsActive)
    }
  }
}
</script>