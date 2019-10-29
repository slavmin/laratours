<template>
  <div
    v-if="show"
  >
    <v-badge color="red">
      <template v-slot:badge>
        <span>!</span>
      </template>
      <v-icon
        large
        color="grey"
      >
        mail
      </v-icon>
    </v-badge>
  </div>
</template>
<script>
export default {
  name: 'HasNewMessage',
  props: {
    chat: {
      type: Object,
      default: () => {
        return {}
      }
    },
    recipient: {
      type: String,
      default: '',
    }
  },
  data() {
    return {
      
    }
  },
  computed: {
    show: function() {
      let result = false
      for (let key in this.chat) {
        if (!this.chat[key].isReaded && this.chat[key].sender != this.recipient) {
          result = true
        }
      }
      return result
    }
  }
}
</script>