<template>
  
</template>
<script>
export default {
  name: 'DriverDetails',
  props: {
    transport: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      show: false,
      hotel: false,
      meal: false,
      driversCount: 1,
    }
  },
  computed: {
    drivers: function() {
      let result = []
      for (let i = 0; i < this.driversCount; i++) {
        result.push({
          hotel: false,
          meal: false,
        })
      }
      return result
    }
  },
  methods: {
    increment() {
      this.driversCount += 1
    },
    decrement() {
      this.driversCount -= 1
    },
  },
}
</script>