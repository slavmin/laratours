<template>
  <v-toolbar
    color="#66a5ae"
    dark
    style="z-index: 100;"
  >
    <v-toolbar-title>
      <a href="http://promo.tour-click.ru">
        <img src="/img/frontend/logo.png">
      </a>
    </v-toolbar-title>
    <v-spacer />
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn 
        :href="dashboardUrl"
        flat
      >
        {{ dashboardText }}
      </v-btn>
      <v-menu>
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            {{ managementText }}
            <v-icon>
              expand_more
            </v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-tile
            v-for="item in management"
            :key="item.name"
          >
            <v-list-tile-title>
              <a
                class="black--text" 
                :href="item.url"
              >
                {{ item.text }}
              </a>
            </v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-menu>
        <template v-slot:activator="{ on }">
          <v-btn
            flat
            v-on="on"
          >
            Operator Member
            <v-icon>
              expand_more
            </v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-tile
            v-for="item in profile"
            :key="item.name"
          >
            <v-list-tile-title>
              <a
                class="black--text" 
                :href="item.url"
              >
                {{ item.text }}
              </a>
            </v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>
      <v-btn 
        :href="contactUrl"
        flat
      >
        {{ contactText }}
      </v-btn>
    </v-toolbar-items>
    <!-- <v-toolbar-side-icon /> -->
  </v-toolbar>
</template>
<script>
export default {
  name: 'NavBar',
  props: {
    dashboardUrl: {
      type: String,
      default: '/dashboard'
    },
    dashboardText: {
      type: String,
      default: 'tourclick!'
    },
    managementText: {
      type: String,
      default: 'tourclick!'
    },
    orderIndexUrl: {
      type: String,
      default: '#'
    },
    orderIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourIndexUrl: {
      type: String,
      default: '#'
    },
    tourIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourTypeIndexUrl: {
      type: String,
      default: '#'
    },
    tourTypeIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourCustomerIndexUrl: {
      type: String,
      default: '#'
    },
    tourCustomerIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourHotelCategoryIndexUrl: {
      type: String,
      default: '#'
    },
    tourHotelCategoryIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourCountryIndexUrl: {
      type: String,
      default: '#'
    },
    tourCountryIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourHotelIndexUrl: {
      type: String,
      default: '#'
    },
    tourHotelIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourMealIndexUrl: {
      type: String,
      default: '#'
    },
    tourMealIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourTransportIndexUrl: {
      type: String,
      default: '#'
    },
    tourTransportIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourGuideIndexUrl: {
      type: String,
      default: '#'
    },
    tourGuideIndexText: {
      type: String,
      default: 'tourclick!'
    },
    tourAttendantIndexUrl: {
      type: String,
      default: '#'
    },
    tourAttendantIndexText: {
      type: String,
      default: 'tourclick!'
    },
    userTeamUrl: {
      type: String,
      default: '#'
    },
    userTeamText: {
      type: String,
      default: 'tourclick!'
    },
    userAccountUrl: {
      type: String,
      default: '#'
    },
    userAccountText: {
      type: String,
      default: 'tourclick!'
    },
    authLogoutUrl: {
      type: String,
      default: '#'
    },
    authLogoutText: {
      type: String,
      default: 'tourclick!'
    },
    contactUrl: {
      type: String,
      default: '#'
    },
    contactText: {
      type: String,
      default: 'tourclick!'
    },
  },
  data() {
    return {
      items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' }
      ],
    }
  },
  computed: {
    management: function() {
      let result = []
      result.push({
        text: this.orderIndexText,
        url: this.orderIndexUrl
      })
      result.push({
        text: this.tourIndexText,
        url: this.tourIndexUrl
      })
      result.push({
        text: this.tourTypeIndexText,
        url: this.tourTypeIndexUrl
      })
      result.push({
        text: this.tourCustomerIndexText,
        url: this.tourCustomerIndexUrl
      })
      result.push({
        text: this.tourHotelCategoryIndexText,
        url: this.tourHotelCategoryIndexUrl
      })
      result.push({
        text: this.tourCountryIndexText,
        url: this.tourCountryIndexUrl
      })
      result.push({
        text: this.tourHotelIndexText,
        url: this.tourHotelIndexUrl
      })
      result.push({
        text: this.tourMealIndexText,
        url: this.tourMealIndexUrl
      })
      result.push({
        text: this.tourTransportIndexText,
        url: this.tourTransportIndexUrl
      })
      result.push({
        text: this.tourGuideIndexText,
        url: this.tourGuideIndexUrl
      })
      result.push({
        text: this.tourAttendantIndexText,
        url: this.tourAttendantIndexUrl
      })
      return result
    },
    profile: function() {
      let result = []
      result.push({
        text: this.userTeamText,
        url: this.userTeamUrl
      })
      result.push({
        text: this.userAccountText,
        url: this.userAccountUrl
      })
      result.push({
        text: this.authLogoutText,
        url: this.authLogoutUrl
      })
      return result
    }
  }
}
</script>