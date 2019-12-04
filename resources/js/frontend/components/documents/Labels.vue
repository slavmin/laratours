<template>
  <div>
    <h2>Метки</h2>
    <ul style="list-style: none;">
      <li
        v-for="(label, i) in labelNames"
        :key="i"
      >
        {{ label }}
      </li>
    </ul>
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
            console.log()
            this.labelNames.push(`{${key}}`)
          }
        })
    }
  }
}
</script>