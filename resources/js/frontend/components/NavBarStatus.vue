<template>
  <div />
</template>
<script>
import { mapActions } from 'vuex'
export default {
  name: 'NavBarStatus',
  props: {
    status: {
      type: String,
      default: ''
    },
    flag: {
      type: Boolean,
      default: false,
    },
    name: {
      type: String,
      default: '',
    }
  },  
  mounted() {
    this.updateNavBarStatus({
      status: this.status,
      flag: this.flag
    })
    if (this.name != '') {
      this.updateUserName(this.name)
    }
  },
  methods: {
    ...mapActions([
      'updateNavBarStatus',
      'updateUserName',
    ])
  }
}
</script>