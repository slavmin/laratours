<template>
  <v-toolbar
    color="#66a5ae"
    dark
    height="70"
    style="z-index: 100;"
  >
    <v-toolbar-title>
      <a href="/dashboard">
        <img src="/img/frontend/logo_small.png">
      </a>
    </v-toolbar-title>
    <div
      v-if="branding != []"
      class="ml-5"
    >
      <span>
        {{ branding.company_full_name }}
      </span>
      <br>
      <span>
        {{ branding.company_address }}
      </span>
      <br>
      <span>
        {{ branding.company_phone }}
        <a
          :href="`mailto:${branding.company_email}`"
          style="color: white;"
        >
          {{ branding.company_email }}
        </a>
      </span>
    </div>
    <v-spacer />
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn
        v-if="auth"
        :href="dashboardUrl"
        flat
        class="no-border"
      >
        <v-icon class="mr-2">
          dashboard
        </v-icon>
        {{ dashboardText }}
      </v-btn>
      <v-btn
        v-if="status.guest"
        :href="loginUrl"
        flat
      >
        {{ loginText }}
      </v-btn>
      <v-btn
        v-if="status.guest"
        :href="regUrl"
        flat
      >
        {{ regText }}
      </v-btn>
      <v-menu v-if="!status.guest">
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <v-icon class="mr-2">
              work_outline
            </v-icon>
            {{ managementText }}
            <v-icon>
              expand_more
            </v-icon>
          </v-btn>
        </template>
        <v-list>
          <a
            v-for="item in management"
            :key="item.name"
            :href="item.url"
            class="menu-link"
          >
            <v-list-tile class="black--text menu-text">
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile>
          </a>
        </v-list>
      </v-menu>
      <v-menu v-if="!status.guest">
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <v-icon class="mr-2">
              account_circle
            </v-icon>
            <v-icon>
              expand_more
            </v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-tile
            style="background-color: #aa282a; margin-top: -8px; margin-bottom: -14px;"
          >
            <v-list-tile-avatar>
              <v-icon color="white">
                account_circle
              </v-icon>
            </v-list-tile-avatar>

            <v-list-tile-content>
              <v-list-tile-title style="color: white;">
                {{ status.userName }}
              </v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider />
          <a
            v-for="item in profile"
            :key="item.name"
            :href="item.url"
            class="menu-link"
          >
            <v-list-tile class="black--text menu-text">
              <v-list-tile-title>
                {{ item.text }}
              </v-list-tile-title>
            </v-list-tile>
          </a>
        </v-list>
      </v-menu>
      <v-menu>
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            <v-icon class="mr-2">
              help_outline
            </v-icon>
            <v-icon>
              expand_more
            </v-icon>
          </v-btn>
        </template>
        <v-list>
          <a
            :href="contactUrl"
            class="menu-link"
          >
            <v-list-tile class="black--text menu-text">
              <v-list-tile-title>
                {{ contactText }}
              </v-list-tile-title>
            </v-list-tile>
          </a>
          <ChangeLog />
        </v-list>
      </v-menu>
    </v-toolbar-items>
    <!-- <v-toolbar-side-icon /> -->
  </v-toolbar>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import ChangeLog from './ChangeLog'
import axios from 'axios'
export default {
  name: 'NavBar',
  components: {
    ChangeLog,
  },
  props: {
    loginUrl: {
      type: String,
      default: '/login',
    },
    loginText: {
      type: String,
      default: 'login!',
    },
    regUrl: {
      type: String,
      default: '/registration',
    },
    regText: {
      type: String,
      default: 'reg!',
    },
    dashboardUrl: {
      type: String,
      default: '/dashboard',
    },
    dashboardText: {
      type: String,
      default: 'tourclick!',
    },
    managementText: {
      type: String,
      default: 'tourclick!',
    },
    orderIndexUrl: {
      type: String,
      default: '#',
    },
    orderIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourIndexUrl: {
      type: String,
      default: '#',
    },
    tourIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourTypeIndexUrl: {
      type: String,
      default: '#',
    },
    tourTypeIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourCustomerIndexUrl: {
      type: String,
      default: '#',
    },
    tourCustomerIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourHotelCategoryIndexUrl: {
      type: String,
      default: '#',
    },
    tourHotelCategoryIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourCountryIndexUrl: {
      type: String,
      default: '#',
    },
    tourCountryIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourHotelIndexUrl: {
      type: String,
      default: '#',
    },
    tourHotelIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourMuseumIndexUrl: {
      type: String,
      default: '#',
    },
    tourMuseumIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourMealIndexUrl: {
      type: String,
      default: '#',
    },
    tourMealIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourTransportIndexUrl: {
      type: String,
      default: '#',
    },
    tourTransportIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourGuideIndexUrl: {
      type: String,
      default: '#',
    },
    tourGuideIndexText: {
      type: String,
      default: 'tourclick!',
    },
    tourAttendantIndexUrl: {
      type: String,
      default: '#',
    },
    tourAttendantIndexText: {
      type: String,
      default: 'tourclick!',
    },
    userTeamUrl: {
      type: String,
      default: '#',
    },
    userTeamText: {
      type: String,
      default: 'tourclick!',
    },
    userAccountUrl: {
      type: String,
      default: '#',
    },
    userAccountText: {
      type: String,
      default: 'tourclick!',
    },
    authLogoutUrl: {
      type: String,
      default: '#',
    },
    authLogoutText: {
      type: String,
      default: 'tourclick!',
    },
    contactUrl: {
      type: String,
      default: '#',
    },
    contactText: {
      type: String,
      default: 'tourclick!',
    },
    agencyTourListUrl: {
      type: String,
      default: '#',
    },
    agencyTourListText: {
      type: String,
      default: 'tourclick!',
    },
    agencyOrderIndexUrl: {
      type: String,
      default: '#',
    },
    agencyOrderIndexText: {
      type: String,
      default: 'tourclick!',
    },
    documentsIndexText: {
      type: String,
      default: '#',
    },
    documentsIndexUrl: {
      type: String,
      default: 'tourclick!',
    },
  },
  data() {
    return {
      items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' },
      ],
      branding: {},
    }
  },
  computed: {
    ...mapGetters({
      auth: 'getAuthStatus',
      guest: 'getGuestStatus',
      status: 'getNavBarStatus',
    }),
    management: function() {
      let result = []
      if (this.status.operator) {
        result.push({
          text: this.orderIndexText,
          url: this.orderIndexUrl,
          icon: 'check_circle_outline',
        })
        result.push({
          text: this.tourIndexText,
          url: this.tourIndexUrl,
          icon: 'flight_takeoff',
        })
        result.push({
          text: this.tourTypeIndexText,
          url: this.tourTypeIndexUrl,
          icon: 'commute',
        })
        result.push({
          text: this.tourCustomerIndexText,
          url: this.tourCustomerIndexUrl,
          icon: 'how_to_reg',
        })
        result.push({
          text: this.tourHotelCategoryIndexText,
          url: this.tourHotelCategoryIndexUrl,
          icon: 'grade',
        })
        result.push({
          text: this.tourCountryIndexText,
          url: this.tourCountryIndexUrl,
          icon: 'location_city',
        })
        result.push({
          text: this.tourHotelIndexText,
          url: this.tourHotelIndexUrl,
          icon: 'hotel',
        })
        result.push({
          text: this.tourMuseumIndexText,
          url: this.tourMuseumIndexUrl,
          icon: 'account_balance',
        })
        result.push({
          text: this.tourMealIndexText,
          url: this.tourMealIndexUrl,
          icon: 'fastfood',
        })
        result.push({
          text: this.tourTransportIndexText,
          url: this.tourTransportIndexUrl,
          icon: 'directions_bus',
        })
        result.push({
          text: this.tourGuideIndexText,
          url: this.tourGuideIndexUrl,
          icon: 'nature_people',
        })
        result.push({
          text: this.tourAttendantIndexText,
          url: this.tourAttendantIndexUrl,
          icon: 'nature_people',
        })
      }
      if (this.status.agency) {
        result = []
        result.push({
          text: this.agencyTourListText,
          url: this.agencyTourListUrl,
          icon: 'flight_takeoff',
        })
        result.push({
          text: this.agencyOrderIndexText,
          url: this.agencyOrderIndexUrl,
          icon: 'check_circle_outline',
        })
      }
      this.updateActualLinks(result)
      return result
    },
    profile: function() {
      let result = []
      result.push({
        text: this.userTeamText,
        url: this.userTeamUrl,
      })
      result.push({
        text: this.userAccountText,
        url: this.userAccountUrl,
      })
      result.push({
        text: this.documentsIndexText,
        url: this.documentsIndexUrl,
      })
      result.push({
        text: this.authLogoutText,
        url: this.authLogoutUrl,
      })
      return result
    },
    // branding: function() {
    //   let result = []

    //   return result
    // }
  },
  mounted() {
    axios
      .get('/api/operator-info')
      .then(res => {
        this.branding = res.data[0].branding
        // console.log(res)
      })
      .catch(e => console.log('branding error: ', e))
  },
  methods: {
    ...mapActions(['updateActualLinks']),
  },
}
</script>
<style lang="scss" scoped>
.no-border {
  &:hover {
    text-decoration: none;
  }
}
.menu-link {
  &:hover {
    text-decoration: none;
  }
}
.menu-text {
  &:hover {
    background-color: #66a5ae;
    color: white !important;
  }
}
</style>