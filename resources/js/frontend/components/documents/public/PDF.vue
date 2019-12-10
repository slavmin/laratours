<template>
  <div>
    {{ document.name }}
    <button @click="getPdf()">
      <img 
        src="/img/frontend/icons/pdf.png" 
        width="32"
      >
    </button>
  </div>
</template>

<script>
import html2pdf from 'html2pdf.js'
export default {
  name: 'PublicPDF',
  props: {
    team: {
      type: Object,
      default: () => {
        return {}
      }
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
      labels: [],
      result: '',
    }
  },
  methods: {
    getPdf() {
      axios.get('/api/label-options')
        .then(response => {
          this.labels = response.data[0].labels
        })
        .then(response => {
          for (let key in this.labels) {
            if (this.document.template.includes(key)) {
              this.result = this.document.template.replace('{' + key + '}', this.labels[key])
            }
          }
          let opt = {
            margin:       1,
            filename:     `${this.document.name}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 1, width: 900 },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
          }
          html2pdf().from(this.result).set(opt).save()
        })
    }
  }
}
</script>