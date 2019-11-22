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
      <form
        method="POST" 
        :action="getEditMode ? `/operator/tour/${getTour.id}` :'/operator/tour'"
      >
        <input
          type="hidden"
          name="_method"
          :value="getEditMode ? 'PATCH' : 'POST'"
        >
        <input 
          type="hidden" 
          name="_token" 
          :value="token"
        >   
        <input 
          type="hidden" 
          name="name" 
          :value="getTour.options.name"
        > 
        <input 
          type="hidden" 
          name="tour_type_id" 
          :value="getTour.options.tourType"
        > 
        <input 
          type="hidden" 
          name="cities_list[]" 
          :value="getTour.options.cities"
        > 
        <input 
          type="hidden" 
          name="duration" 
          :value="getTour.options.days"
        > 
        <input 
          type="hidden"
          :value="JSON.stringify(tourExtra)"
          name="extra"
        > 
        <v-btn 
          dark
          color="#aa282a"
          type="submit"
        >
          Сохранить тур
        </v-btn>
      </form>
    </v-list>
  </v-bottom-sheet>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  name: 'BottomSheet',
  props: {
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      sheet: false,
      tiles: [
        { img: 'keep.png', title: 'Keep' },
        { img: 'inbox.png', title: 'Inbox' },
        { img: 'hangouts.png', title: 'Hangouts' },
        { img: 'messenger.png', title: 'Messenger' },
        { img: 'google.png', title: 'Google+' }
      ]
    }
  },
  computed: {
    ...mapGetters([
      'getEditMode',
      'getTour',
    ]),
    tourExtra: function() {
      return {
        ...this.getTour, 
        correctedPrice: this.getCorrectedPrice
      }
    },
  }
}
</script>