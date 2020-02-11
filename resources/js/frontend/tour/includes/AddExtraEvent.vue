<template>
  <v-layout
    row
    wrap
    justify-space-around
  >
    <ul
      style="list-style: none;"
    >
      <li
        v-for="event in extraEventsArray"
        :key="event.id"
      >
        <v-layout
          row
          wrap
          justify-start
          class="text-xs-left"
        >
          <v-switch 
            v-model="choosenExtraEvents"
            :value="event.id"
            color="#aa282a"
            @change="choose(event)"
          >
            <template v-slot:label>
              <div>
                {{ event.museum.name }}
                <div style="color: black; font-size: 14px;">
                  {{ event.obj. name }}
                </div>
                <div style="color: green; font-size: 12px;">
                  +{{ event.commissionPrice }} руб.
                </div>
              </div>
            </template>
          </v-switch>
        </v-layout>
      </li>
    </ul> 
    <!-- <v-btn
      color="red"
      dark
      flat
      @click="showDetails = !showDetails"
    >
      {{ showDetails ? 'Скрыть' : 'Дебаг' }}
      <v-icon right>
        expand_{{ showDetails ? 'less' : 'more' }}
      </v-icon>
    </v-btn>
    <div v-if="showDetails">
      {{ `customer type: ${customerType}` }}
      <br>
      {{ `customer age: ${customerAge}` }}
      <v-btn 
        color="red"
        @click="logPrice"
      >
        Price to console
      </v-btn>
    </div> -->
  </v-layout>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'AddExtraEvent',
  props: {
    // tour: {
    //   type: Object,
    //   default: () => {
    //     return {}
    //   }
    // },
    profileId: {
      type: Number,
      default: 0
    },
    customerType: {
      type: String,
      default: '',
    },
    customerAge: {
      type: Number,
      default: 0
    },
    profilePlace: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    profileExtraEventsIdArray: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  data() {
    return {
      choosenExtraEvents: [],
      showDetails: false,
    }
  },
  computed: {
    extraEventsArray: function() {
      return this.$store.getters.getExtraEvents({
        profileCustomerType: this.customerType,
        profileId: this.profileId,
        age: this.customerAge,
      })
    },
    resetProfileFlag: function() {
      return this.$store.getters.getResetProfileFlag(this.profileId)
    },
  },
  watch: {
    resetProfileFlag(val) {
      if (val) {
        console.log('clear')
        this.choosenExtraEvents = []
        this.updateResetProfileFlag(this.profileId)
      }
    }
  },
  mounted() {
    setTimeout(() => {
      this.choosenExtraEvents = this.profileExtraEventsIdArray
    }, 500)
  },
  methods: {
    ...mapActions([
      'updateProfileExtraEvents',
      'updateProfilePrice',
      'updateResetProfileFlag',
      'updateOrderPrice',
      'updateOrderCommission'
    ]),
    choose(event) {
      this.updateProfileExtraEvents({
        profileId: this.profileId,
        profileChoosenExtraEvents: this.choosenExtraEvents,
        event: event,
      })
      this.updateProfilePrice({
        profileId: this.profileId,
        profileCustomerType: this.customerType,
        age: this.customerAge,
        profilePlace: this.profilePlace,
        name: this.name,
      })
      this.updateOrderPrice()
      this.updateOrderCommission()
    },
    logPrice() {
      console.log(this.extraEventsArray)
    }
  }
}
</script>