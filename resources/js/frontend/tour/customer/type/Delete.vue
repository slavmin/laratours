<template>
  <v-btn  
    small
    fab
    outline
    color="red"
    dark
    ma-3
    @click="del"
  >
    <i class="material-icons">
      delete
    </i>
  </v-btn>
</template>

<script>
export default {

  name: 'DeleteCustomerType',
  props: {
    token: {
      type: String,
      default: () => {
        return ''
      }
    },
    item: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },

  data() {
    return {
      url: '/operator/customer-type/' + this.item.id,
    };
  },
  methods: {
    del() {
      let result = {
        '_token': this.token,
        '_method': 'DELETE'
      }
      axios.post(this.url, result)
        .then(r => console.log(r))
        .catch(e => console.log(e))
    }
  } 
};
</script>

<style lang="css" scoped>
</style>
