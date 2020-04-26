<template>
  <div>
    {{ document.name }}
    <form action="/operator/modules/get-pdf" method="GET">
      <input name="document_id" :value="document.id" type="hidden" />
      <div v-if="touristMode">
        <input name="tourist_mode" :value="touristMode" type="hidden" />
        <input name="order_id" :value="orderId" type="hidden" />
        <input name="tour_id" :value="tourId" type="hidden" />
      </div>
      <div v-if="teamMode">
        <input name="team_mode" :value="teamMode" type="hidden" />
        <input name="team_id" :value="document.team_id" type="hidden" />
      </div>

      <button type="submit">
        <img src="/img/frontend/icons/pdf.png" width="32" />
      </button>
    </form>
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
      },
    },
    document: {
      type: Object,
      default: () => {
        return {}
      },
    },
    teamMode: {
      type: Boolean,
      default: false,
    },
    touristMode: {
      type: Boolean,
      default: false,
    },
    orderId: {
      type: Number,
      default: NaN,
    },
    tourId: {
      type: Number,
      default: NaN,
    },
  },
  data() {
    return {
      labels: [],
      result: '',
    }
  },
  computed: {
    requestParameters: function() {
      let result = {}
      if (this.teamMode) {
        result = {
          team_mode: true,
          team_id: this.document.team_id,
        }
      }
      if (this.touristMode) {
        result = {
          tourist_mode: true,
          order_id: this.orderId,
          tour_id: this.tourId,
        }
      }
      return result
    },
  },
  mounted() {
    console.log(this.document)
  },
  methods: {
    // getPdf() {
    //   axios.get('/api/label-options', {
    //     params: this.requestParameters,
    //   })
    //     .then(response => {
    //       console.log(response)
    //       this.labels = response.data[0].labels
    //       console.log(this.labels)
    //     })
    //     .then(response => {
    //       this.result = this.document.template
    //       for (let key in this.labels) {
    //         while (this.result.includes('{' + key + '}')) {
    //           console.log(key)
    //           this.result = this.result.replace('{' + key + '}', this.labels[key])
    //         }
    //         while (this.result.includes('\n')) {
    //           this.result = this.result.replace('\n', '')
    //         }
    //         while (this.result.includes('\r')) {
    //           this.result = this.result.replace('\r', '')
    //         }
    //         while (this.result.includes('"')) {
    //           this.result = this.result.replace('"', '')
    //         }
    //       }
    //       const startHtml = "<html><head><title>Test html 2 pdf.</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><style>@page { margin: 24px;}* { font-family: Arial, \"DejaVu Sans\", monospace;}</style><body>"
    //       const endHtml = "</body></html>"
    //       let htmlString = `${startHtml}${this.result}${endHtml}`
    //       console.log(htmlString)
    //       window.location.replace(`/modules/get-pdf?string=${htmlString}`)
    //     //  let opt = {
    //     //    margin:       1,
    //     //    pagebreak:    { mode: 'avoid-all', before: '#page2el' },
    //     //    filename:     `${this.document.name}.pdf`,
    //     //    image:        { type: 'jpeg', quality: 0.98 },
    //     //    html2canvas:  { scale: 1, width: 900 },
    //     //    jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
    //     //  }
    //     //  html2pdf().from(this.result).set(opt).save()
    //     })
    // }
  },
}
</script>