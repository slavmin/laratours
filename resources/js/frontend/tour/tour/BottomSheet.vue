<template>
  <v-bottom-sheet v-model="sheet">
    <template v-slot:activator>
      <v-btn
        color="grey"
        flat
        fab
        dark
      >
        <i class="material-icons">
          keyboard_arrow_up
        </i>
      </v-btn>
    </template>
    <v-list>
      <v-subheader>Итоги</v-subheader>
      <SaveTourForm
        :token="token"
      />
    </v-list>
  </v-bottom-sheet>
</template>
<script>
import { mapGetters } from 'vuex'
import SaveTourForm from './SaveTourForm'
export default {
  name: 'BottomSheet',
  components: {
    SaveTourForm,
  },
  props: {
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      sheet: false,
    }
  },
}
</script>