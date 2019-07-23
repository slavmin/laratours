<template>
  <v-container
    fluid
    grid-list-md
    text-xs-center
  >
    <h1 class="display-3 mb-5">
      <i 
        class="material-icons mr-2"
        style="font-size: 42px;"
      >
        nature_people
      </i>
      Гиды
      <Add 
        :token="token" 
      />
    </h1>
    <Table 
      :token="token" 
    />
  </v-container>
</template>

<script>
import Add from './Add'
import Table from './Table'
export default {

  name: 'ObjectGuideIndex',
  components: {
    Add,
    Table
  },
  props: {
    token: {
      type: String,
      default: ''
    },
  },
  data() {
    return {

    };
  }
};
</script>

<style lang="css" scoped>
</style>
