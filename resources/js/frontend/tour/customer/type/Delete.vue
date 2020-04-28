<template>
  <form 
    :action="'/operator/customer-type/' + item.id"
    method="POST"
  >
    <input 
      type="hidden"
      name="_method"
      value="DELETE"
    >
    <input 
      type="hidden"
      name="_token"
      :value="token"
    >
    <v-btn  
      small
      fab
      outline
      color="red"
      dark
      ma-3
      type="submit"
    >
      <i class="material-icons">
        delete
      </i>
    </v-btn>
  </form>
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
};
</script>

<style lang="css" scoped>
</style>
