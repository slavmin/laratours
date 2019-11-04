<template>
  <div>
    <v-alert
      v-model="alert"
      dismissible
      :color="color"
      transition="scale-transition"
      class="alert"
    >
      <ul
        v-for="(message, i) in messagesArray"
        :key="i"
      >
        <li
          v-for="(string, k) in message"
          :key="`string-${k}`"
        >
          {{ formatString(string) }}
        </li>
      </ul>
    </v-alert>
  </div>
</template>
<script>
export default {
  name: 'Messages',
  props: {
    messages: {
      type: String,
      default: ''
    },
    messageType: {
      type: String,
      default: ''
    }
  },
  data () {
    return {
      alert: true,
      colors: {
        error: 'red',
        success: 'green',
        warning: 'orange',
        info: '#1bbedd',
      },
      messagesArray: [],
    }
  },
  computed: {
    // messagesArray: function() {
    //   let result = []
      
      // switch (typeof this.messages) {
      //   case 'object':
      //     const messagesObject = JSON.parse(this.messages)
      //     for (let key in messagesObject) {
      //       result.push(messagesObject[key])
      //     }
      //     break
      //   case 'array':
      //     result = this.messages
      //     break
      //   case 'string':
      //     result.push([this.messages])
      //   default:
      //     break
      // }

      // if (typeof this.messages == 'object') {
      //   const messagesObject = JSON.parse(this.messages)
      //   for (let key in messagesObject) {
      //     result.push(messagesObject[key])
      //   }
      // }
      // if (typeof this.messages == 'string') {
      //   result.push([this.messages])
      // }
    //   return result
    // },
    color: function() {
      switch(this.messageType) {
        case 'error': 
          return this.colors.error
          break
        case 'success':
          return this.colors.success
          break
        case 'warning':
          return this.colors.warning
          break
        case 'info':
          return this.colors.info
          break
      }
      return this.colors.error
    }
  },
  mounted() {
    console.log(this.messages, typeof this.messages)
    console.log(this.messagesArray)
    let promise = new Promise((resolve, reject) => {
        resolve(JSON.parse(this.messages))
        reject("error")
      })
    promise
      .then(
        (result) => {
          this.messagesArray = []
          console.log(result)
          for (let key in result) {
            this.messagesArray.push(result[key])
          }
        },
        error => {
          this.messagesArray = []
          console.log(typeof this.messages)
          this.messagesArray.push([this.messages])
        } 
      )
  },
  methods: {
    formatString(message) {
      if (typeof message == "object") {
        return JSON.parse(message)
      }
      return message
    }
  }
}
</script>
<style lang="scss" scoped>
.alert {
  position: fixed;
  bottom: 0;
  right: 6px;
  z-index: 200;
  min-width: 300px;
  border-radius: 6px;
  opacity: 0.8;
}
</style>