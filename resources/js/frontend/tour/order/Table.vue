<template>
  <v-expansion-panel>
    <v-expansion-panel-content
      v-for="tour in getTours"
      :key="tour.tourId"
    >
      <template v-slot:header>
        <div class="headline grey--text">
          {{ tourNames[tour.tourId] }}
        </div>
      </template>
      <v-card>
        <v-card-text>
          <v-layout 
            row 
            wrap
            justify-center
          >
            <Profiles 
              :tour="tour"
              :token="token"
              :agencies="agencies"
              :statuses="statuses"
              :tour-names="tourNames"
            />
          </v-layout>
        </v-card-text>
      </v-card>
    </v-expansion-panel-content>
  </v-expansion-panel>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Profiles from './Profiles'
export default {
  name: 'OrdersTable',
  components: {
    Profiles,
  },
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      }
    },
    agencies: {
      type: Object,
      default: () => {
        return {}
      }
    },
    statuses: {
      type: Array,
      default: () => {
        return []
      }
    },
    tourNames: {
      type: Object,
      default: () => {
        return []
      }
    },
    token: {
      type: String,
      default: ''
    }
  },
  computed: {
    ...mapGetters([
      'getTours'
    ]),
  },
  mounted() {
    this.updateTours(this.items.data)
  },
  methods: {
    ...mapActions([
      'updateTours'
    ]),  
    touristsCount(content) {
      let count = 0
      for (let key in content) {
        count += 1
      }
      return count
    },
  }
}
</script>
