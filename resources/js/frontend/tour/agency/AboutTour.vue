<template>
  <div class="text-xs-center">
    <v-dialog
      v-if="show"
      v-model="dialog"
      width="500"
      lazy
    >
      <template v-slot:activator="{ on }">
        <v-btn
          color="#aa282a"
          dark
          small
          flat
          v-on="on"
        >
          Программа
        </v-btn>
      </template>

      <v-card>
        <v-card-title
          class="headline white--text"
          primary-title
          style="background-color: #66a5ae;"
        >
          Программа тура
        </v-card-title>

        <v-card-text 
          v-html="contentString" 
        />

        <v-divider />

        <v-card-actions>
          <v-spacer />
          <v-btn
            color="#aa282a"
            dark
            @click="dialog = false"
          >
            Закрыть
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import { mapActions } from 'vuex';
export default {
  name: 'AboutTour',
  props: {
    content: {
      type: Array,
      default: () => {
        return []
      }
    },
  },
  data () {
    return {
      dialog: false,
      show: true,
    }
  },
  computed: {
    contentString: function() {
      if (this.content.length > 0) {
        let result = ''
         this.content.forEach((item) => {
           result += item
         })
        return result
      } else {
        return 'Программа не заполнена'
      }
    }
  }
}
</script>