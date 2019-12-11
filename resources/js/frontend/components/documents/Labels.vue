<template>
  <div>
    <h2 class="grey--text">
      Метки
    </h2>
    <ul style="list-style: none;">
      <li
        v-for="(label, i) in labelNames"
        :id="i+label"
        :key="i"
      >
        {{ label }}
      </li>
    </ul>
    <!-- <v-list>
      <v-list-tile
        v-for="(label, i) in labelNames"
        :id="i+label"
        :key="i"
        @click="copyToClipBoard(`${i}${label}`)"
      >
        <v-list-tile-action>
          <v-icon color="pink">
            star
          </v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title v-text="label" />
        </v-list-tile-content>
      </v-list-tile>
    </v-list> -->
  </div>
</template>

<script>
export default {
  name: 'DocumentLabels',
  data() {
    return {
      labelNames: [],
    }
  },
  mounted() {
    this.getLabels()
  },
  methods: {
    getLabels() {
      axios.get('/api/label-options')
        .then(response => {
          // console.log(response)
          for (let key in response.data[0].labels) {
            // console.log()
            this.labelNames.push(`{${response.data[0].labels[key]}}`)
          }
        })
    },
    copyToClipBoard(elementId) {
      console.log('copy ', elementId)
      // let copyText = document.getElementById(elementId).childNodes[0]
      // console.log(copyText, elementId)
      // copyText.select()
      // // window.getSelection().selectAllChildren(
      // //   document.getElementById(elementId)
      // // );
      // try {
      //   document.execCommand("copy")
      //   console.log('done')
      //   this.copied = true
      //   setTimeout(() => {
      //     this.copied = false
      //   }, 1500)
      // }
      // catch(e) {
      //   console.log('copy error: ', e)
      // }
      // window.getSelection().removeAllRanges();
    }
  }
}
</script>