<template>
  <div class="ml-1">
    <button @click="getWord()">
      <img 
        src="/img/frontend/icons/word.png" 
        width="32"
        style="margin-top: 10px;"
      >
    </button>
    <!-- <div
      class="document-render"
      style="display: none;"
      v-html="rawHtml"
    /> -->
  </div>
</template>

<script>
export default {
  name: 'MakeWord',
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
      rawHtml: '',
    }
  },
  mounted() {
      this.fill()
  },
  methods: {
    fill() {
      this.rawHtml = this.document.template
    },
    getLabels() {
      axios.get('/api/label-options')
        .then(response => {
          this.labels = response.data[0].labels
        })
        .then(response => {
          for (let key in this.labels) {
            if (this.rawHtml.includes(key)) {
              console.log("TCL: getLabels -> key", key)
              this.rawHtml = this.rawHtml.replace('{' + key + '}', this.labels[key])
            }
          }
        })
    },
    getWord(){
      axios.get('/api/label-options')
        .then(response => {
          this.labels = response.data[0].labels
        })
        .then(response => {
          for (let key in this.labels) {
            if (this.rawHtml.includes(key)) {
              // console.log("TCL: getLabels -> key", key)
              this.rawHtml = this.rawHtml.replace('{' + key + '}', this.labels[key])
            }
          }
        
        let preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
        let postHtml = "</body></html>";
        let html = preHtml + this.rawHtml + postHtml;
        let blob = new Blob(['\ufeff', html], {
            type: 'application/msword'
        });
        
        // Specify link url
        let url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
        
        // Specify file name
        let filename = this.document.name + '.doc';
        
        // Create download link element
        let downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob ){
            navigator.msSaveOrOpenBlob(blob, filename);
        } else{
            // Create a link to the file
            downloadLink.href = url;
            
            // Setting the file name
            downloadLink.download = filename;
            
            //triggering the function
            downloadLink.click();
        }
        
        document.body.removeChild(downloadLink);
      })
    } 
  }
}
</script>