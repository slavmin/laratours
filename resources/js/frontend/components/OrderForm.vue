<template>
  <v-expansion-panels
    multiple
    :value="panel"
    popout
    focusable
    hover
  >
    <v-expansion-panel
      v-for="i in [0, 1, 2]"
      :key="i"
    >
      <v-expansion-panel-header>
        Турист {{ i + 1 }}
      </v-expansion-panel-header>
      <v-expansion-panel-content>
        <TouristForm
          :customer="customers[i]"
          :index="i"
        />
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>

<script>
import TouristForm from './TouristForm'
export default {
  name: 'OrderForm',
  components: { TouristForm },
  props: {
    old: {
      type: Object,
      default: () => [],
    },
  },
  data() {
    return {
      panel: [0],
      customers: [],
    }
  },
  mounted() {
    if (this.old.hasOwnProperty('customer')) {
      this.customers = this.old.customer
    }
  },
}
</script>