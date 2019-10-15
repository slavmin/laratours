<template>
  <form>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label 
          for="transportCompanySelect" 
          class="input-group-text"
        >
          Транспортная компания:
        </label>
      </div>
      <select 
        id="transportCompanySelect" 
        class="custom-select"
      >
        <option selected>
          Выберите...
        </option>
        <option
          v-for="company in allTransportCompanies"
          :key="company"
          :value="company"
        >
          {{ company }}
        </option>
      </select>
    </div>
  </form>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {

  name: 'TransportCompanyComponent',
  computed: mapGetters(['allTransportCompanies']),

};
</script>

<style lang="css" scoped>
</style>
