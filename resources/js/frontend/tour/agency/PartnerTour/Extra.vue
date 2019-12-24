<template>
  <v-container grid-list-xs>
    <h3 class="text-xs-center grey--text">
      Допы
    </h3> 
    <v-layout 
      row 
      wrap
    > 
      <!-- <v-select
        v-model="profilePrice"
        :items="getPartnerExtra"
        :item-text="getPriceName"
        item-value="value"
      /> -->
      <v-layout
        row
        wrap
        justify-space-around
      >
        <ul
          style="list-style: none;"
        >
          <li
            v-for="(event, i) in getPartnerExtra"
            :key="i"
          >
            <v-layout
              row
              wrap
              justify-start
              class="text-xs-left"
            >
              <v-switch 
                v-model="choosenExtraEvents"
                :value="event"
                color="#aa282a"
                @change="choose(event)"
              >
                <template v-slot:label>
                  <div style="color: black; font-size: 14px;">
                    {{ event.name }}
                  </div>
                  <div style="color: green; font-size: 12px;">
                    +{{ event.value }} руб.
                  </div>
                </template>
              </v-switch>
            </v-layout>
          </li>
        </ul> 
      </v-layout>
    </v-layout>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'PartnerTourExtra',
  props: {
    profileId: {
      type: Number,
      default: 0
    },
  },
  data() {
    return {
      profilePrice: 0,
      choosenExtraEvents: [],
    }
  },
  computed: {
    ...mapGetters([
      'getPartnerExtra',
      'getOrderEditMode',
    ]),
    profile: function() {
      return this.$store.getters.getProfile(this.profileId)
    },
  },
  watch: {
    profilePrice: function(val) {
      console.log(val, this.profile)
      this.updateProfilePartnerPrice({
        profileId: this.profileId,
        price: val,
      })
      this.updateOrderPrice()
      this.updateOrderCommission()
    }
  },
  mounted() {
    setTimeout(() => {
      if (this.getOrderEditMode) {
        this.choosenExtraEvents = this.profile.choosenExtraEvents
      }
    }, 500)
  },
  methods: {
    ...mapActions([
      'updateProfilePartnerPrice',
      'updateOrderPrice',
      'updateOrderCommission',
      'updateProfilePartnerExtra',
    ]),
    getPriceName: (item) => {
      return `${item.name} - ${item.value}`
    },
    choose(event) {
      console.log(event, this.choosenExtraEvents)
      this.updateProfilePartnerExtra({
        profileId: this.profileId,
        choosenExtraEvents: this.choosenExtraEvents,
      })
      this.updateOrderPrice()
      this.updateOrderCommission()
    }
  }
}
</script>