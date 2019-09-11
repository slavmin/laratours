<template>
  <div>
    meal
  </div>
</template>

<script>
export default {
  name: 'ChangeMeal',
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {}
  },
  mounted() {
    console.log(JSON.parse(this.tour.extra))
  }
}
</script>