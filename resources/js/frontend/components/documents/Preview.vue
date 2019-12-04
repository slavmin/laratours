<template>
  <v-dialog
    v-model="dialog"
    width="1000"
  >
    <template v-slot:activator="{ on }">
      <v-btn
        color="green lighten-2"
        dark
        v-on="on"
      >
        preview
      </v-btn>
    </template>

    <v-card>
      <v-card-title
        class="headline grey lighten-2"
        primary-title
      >
        {{ document.name }}
      </v-card-title>

      <v-card-text>
        <div v-html="rawHtml" />
      </v-card-text>

      <v-divider />

      <v-card-actions>
        <v-spacer />
        <v-btn
          color="primary"
          flat
          @click="dialog = false"
        >
          Закрыть
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'DocumentPreview',
  props: {
    document: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data () {
    return {
      dialog: false,
      rawHtml: '<h1>Test</h1><br>',
      labels: {},
    }
  },
  mounted() {
    console.log(this.document)
    this.fill()
    this.getLabels()
  },
  methods: {
    fill() {
      this.rawHtml = this.document.template
    },
    getLabels() {
      axios.get('/api/label-options')
        .then(response => {
          this.labels = response.data[0].labels
          console.log(this.labels)
        })
        .then(response => {
          for (let key in this.labels) {
            if (this.rawHtml.includes(key)) {
              console.log('{' + key + '}', this.labels[key])
              this.rawHtml = this.rawHtml.replace('{' + key + '}', this.labels[key])
            }
          }
        })
    }
  }
}
</script>