<template>
  <v-flex xs12>
    <h2>Транспорт:</h2>
    <p>
      {{ transport.company.name }}
    </p>
  </v-flex>
</template>

<script>
export default {

  name: 'DisplayTransport',
  props: {
    transport: {
      type: Object,
      default: function() {
        return {}
      }
    }
  },
  data() {
    return {

    };
  },
};
</script>

<style lang="css" scoped>
</style>
