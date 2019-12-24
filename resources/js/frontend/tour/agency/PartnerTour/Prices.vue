<template>
  <v-container grid-list-xs>
    <h3 class="text-xs-center grey--text">
      Цены
    </h3> 
    <v-layout 
      row 
      wrap
    > 
      <v-select
        v-model="profilePrice"
        :items="getPartnerPrices"
        :item-text="getPriceName"
        item-value="value"
      />
    </v-layout>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'PartnerTourPrices',
  props: {
    profileId: {
      type: Number,
      default: 0
    },
  },
  data() {
    return {
      profilePrice: 0
    }
  },
  computed: {
    ...mapGetters([
      'getPartnerPrices',
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
        console.log('orderedit', this.profile)
        this.profilePrice = parseInt(this.profile.price)
      }
    }, 1000)
  },
  methods: {
    ...mapActions([
      'updateProfilePartnerPrice',
      'updateOrderPrice',
      'updateOrderCommission',
    ]),
    getPriceName: (item) => {
      return `${item.name} - ${item.value}`
    }
  }
}
</script>