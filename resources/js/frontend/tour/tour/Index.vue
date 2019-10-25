<template>
  <v-container 
    fluid
    grid-list-md
    text-xs-center
    style="background-color: #66a5ae;"
  >
    <v-layout 
      row 
      wrap
      justify-center
    >  
      <v-flex> 
        <h1 class="text-center white--text mb-5">
          <v-icon
            dark
            large
          >
            view_list
          </v-icon>
          Туры
        </h1>
      </v-flex>
    </v-layout>
    <Add 
      :token="token"
      :tours="items.data"
    />
    <Table
      :token="token"
      :tours="items.data"
      :items="items"
    />
  </v-container>
</template>

<script>
import Add from './Add'
import Table from './Table'
export default {

  name: 'TourIndex',
  components: {
    Add,
    Table
  },
  props: {
    token: {
      type: String,
      default: ''
    },
    items: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {

    };
  },
  mounted() {
    console.log(this.items)
  }
};
</script>

<style lang="css" scoped>
</style>
