<template>
  <v-layout 
    row 
    wrap
    justify-center
    align-center
    class="nodata-wrap"
  >
    <v-flex 
      xs8
      class="text-xs-center nodata-text"
    >
      <p
        class="display-3 white--text "
      >
        {{ title }}
      </p>
      <h1
        class="display-3"
      >
        Здесь пока ничего нет.
      </h1>
      <p
        class="display-2"
      >
        Начните заполнять!
      </p>
    </v-flex>
  </v-layout>
</template>
<script>
export default {
  name: 'NoData',
  props: {
    title: {
      type: String,
      default: 'Раздел',
    },
  },
}
</script>
<style lang="scss" scoped>
.nodata-wrap {
  background-color: #66a5ae;
  height: 100vh;
}
.nodata-text {
  margin-top: -70px;
}
</style>