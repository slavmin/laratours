<template>
  <button @click="getPdf()">
    <img 
      src="/img/frontend/icons/pdf.png" 
      width="32"
    >
  </button>
</template>

<script>
import html2pdf from 'html2pdf.js'
export default {
  name: 'MakePDF',
  props: {
    document: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      labels: [],
      rawHrawHtml: '',
    }
  },
  mounted() {
      this.fill()
  },
  methods: {
    fill() {
      this.rawHtml = this.document.template
    },
    getPdf() {
      axios.get('/api/label-options')
        .then(response => {
          this.labels = response.data[0].labels
        })
        .then(response => {
          for (let key in this.labels) {
            if (this.rawHtml.includes(key)) {
              this.rawHtml = this.rawHtml.replace('{' + key + '}', this.labels[key])
            }
          }
          let opt = {
            margin:       2,
            filename:     `${this.document.name}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 1, width: 900 },
            jsPDF:        { canvas: 'body', unit: 'mm', format: 'a4', orientation: 'portrait' }
          }
          html2pdf().from(this.rawHtml).set(opt).save()
        })
    }
  }
}
</script>