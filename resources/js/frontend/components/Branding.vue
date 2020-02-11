<template>
  <div>
    <span>
      {{ branding.company_full_name }}
    </span>
    <br>
    <span>
      {{ branding.company_address }}
    </span>
    <br>
    <span>
      {{ branding.company_phone }}
      <a
        :href="`mailto:${branding.company_email}`"
        style="color: white;"
      >
        {{ branding.company_email }}
      </a>
    </span>
  </div>
</template>
<script>
export default {
  name: 'Branding',
  data() {
    return {
      branding: {},
    }
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      axios
        .get('/api/operator-info')
        .then(res => {
          this.branding = res.data[0].branding
        })
        .catch(e => console.log('branding error: ', e))
    },
  },
}
</script>