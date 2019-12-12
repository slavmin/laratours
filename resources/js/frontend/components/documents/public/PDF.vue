<template>
  <div>
    {{ document.name }}
    <button @click="getPdf()">
      <img 
        src="/img/frontend/icons/pdf.png" 
        width="32"
      >
    </button>
    <!-- <div
      id="document"
      v-html="document.template"
    /> -->
  </div>
</template>

<script>
import html2pdf from 'html2pdf-fix-jspdf'
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
      axios.get('/api/label-options', {
        params: { team_id: this.document.team_id }
      })
        .then(response => {
          console.log(response)
          this.labels = response.data[0].labels
        })
        .then(response => {
          this.result = this.document.template
          for (let key in this.labels) {
            while (this.result.includes(key)) {
              this.result = this.result.replace('{' + key + '}', this.labels[key])
            }
          }
          let opt = {
            margin:       1,
            pagebreak:    { mode: 'avoid-all', before: '#page2el' },
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