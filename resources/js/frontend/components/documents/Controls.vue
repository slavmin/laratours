<template>
  <div>
    <h2 class="grey--text mb-4">
      Доступ
    </h2>
    <h3 class="grey--text mb-0">
      Агент
    </h3>
    <v-layout
      row
      wrap
      justify-center
    >
      <v-flex xs4>
        <v-switch 
          v-model="AgentPdfIsActive"
          color="#aa282a"
          label="PDF"  
        >
          <template v-slot:label>
            <img 
              src="/img/frontend/icons/pdf.png" 
              width="32"
            >
          </template>
        </v-switch>
        <input
          type="hidden"
          name="pdf_for_agent"
          :value="AgentPdfIsActiveParsed"
        >
      </v-flex>
      <v-flex xs4>
        <v-switch 
          v-model="AgentWordIsActive"
          color="#aa282a"
        >
          <template v-slot:label>
            <img 
              src="/img/frontend/icons/word.png" 
              width="32"
            >
          </template>
        </v-switch>
        <input
          type="hidden"
          name="word_for_agent"
          :value="AgentWordIsActiveParsed"
        >
      </v-flex>
    </v-layout>
    <h3 class="grey--text mb-0">
      Турист
    </h3>
    <v-layout
      row
      wrap
      justify-center
    >
      <v-flex xs4>
        <v-switch 
          v-model="TouristPdfIsActive"
          color="#aa282a"
          label="PDF"  
        >
          <template v-slot:label>
            <img 
              src="/img/frontend/icons/pdf.png" 
              width="32"
            >
          </template>
        </v-switch>
        <input
          type="hidden"
          name="pdf_for_tourist"
          :value="TouristPdfIsActiveParsed"
        >
      </v-flex>
      <v-flex xs4>
        <v-switch 
          v-model="TouristWordIsActive"
          color="#aa282a"
        >
          <template v-slot:label>
            <img 
              src="/img/frontend/icons/word.png" 
              width="32"
            >
          </template>
        </v-switch>
        <input
          type="hidden"
          name="word_for_tourist"
          :value="TouristWordIsActiveParsed"
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
      AgentPdfIsActive: false,
      AgentWordIsActive: false,
      TouristPdfIsActive: false,
      TouristWordIsActive: false,
    }
  },
  computed: {
    AgentPdfIsActiveParsed: function() {
      if (this.AgentPdfIsActive) {
        return 1
      }
      return 0
    },
    AgentWordIsActiveParsed: function() {
      if (this.AgentWordIsActive) {
        return 1
      }
      return 0
    },
    TouristPdfIsActiveParsed: function() {
      if (this.TouristPdfIsActive) {
        return 1
      }
      return 0
    },
    TouristWordIsActiveParsed: function() {
      if (this.TouristWordIsActive) {
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
      this.AgentPdfIsActive = parseInt(this.document.pdf_for_agent)
      this.AgentWordIsActive = parseInt(this.document.word_for_agent)
      this.TouristPdfIsActive = parseInt(this.document.pdf_for_tourist)
      this.TouristWordIsActive = parseInt(this.document.word_for_tourist)
    }
  }
}
</script>