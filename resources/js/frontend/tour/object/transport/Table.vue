<template>
  <v-layout column>
    <v-layout
      row
      wrap
      class="white--text"
    >
      <v-flex
        v-for="transport in items.data"
        :key="transport.id"
        mb-5
        xs12
        md12
        lg12
        xl6
      >
        <v-card>
          <v-card-title
            class="white--text"
            style="background-color: #66a5ae;"
          >
            <h3 class="display-1">
              {{ transport.name }}
            </h3>
            <Edit
              :transport="transport"
              :token="token"
            />
            <form
              :action="'/operator/transport/' + transport.id"
              method="POST"
            >
              <input
                type="hidden"
                name="_token"
                :value="token"
              >
              <input
                type="hidden"
                name="_method"
                value="DELETE"
              >
              <v-btn
                color="red"
                fab
                small
                dark
                type="submit"
              >
                <i class="material-icons">
                  delete
                </i>
              </v-btn>
            </form>
          </v-card-title>
          <v-card-text style="color: #979694;">
            <div class="subheading mb-3">
              <i class="material-icons mr-2">
                location_city
              </i>
              {{ getCityName(transport.city_id) }}
              {{ JSON.parse(transport.description).address }}
            </div>
            <v-layout
              row
              wrap
              mb-2
              justify-center
            >
              <div class="mr-3">
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  web
                </i>
                <a
                  :href="JSON.parse(transport.description).contacts.site"
                  target="_blank"
                >
                  {{ JSON.parse(transport.description).contacts.site }}
                </a>
              </div>
              <div class="mr-3">
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  email
                </i>
                <a
                  class=""
                  :href="`mailto: ${JSON.parse(transport.description).contacts.email}`"
                >
                  {{ JSON.parse(transport.description).contacts.email }}
                </a>
              </div>
              <div class="mr-5">
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  phone
                </i>
                {{ JSON.parse(transport.description).contacts.phone }}
              </div>
              <div class="mr-3">
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  person
                </i>
                {{ JSON.parse(transport.description).staff.name }}
              </div>
              <div>
                <i
                  class="material-icons"
                  style="font-size: 12px;"
                >
                  phone
                </i>
                {{ JSON.parse(transport.description).staff.phone }}
              </div>
            </v-layout>
            <AttributesTable
              :transport-attributes="transport.objectables"
              :company-id="transport.id"
              :token="token"
            />
          </v-card-text>
          <v-card-actions>
            <AddObjectables
              :token="token"
              :company-id="transport.id"
            />
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-layout>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from 'vuex'
import AttributesTable from './AttributesTable'
import AddObjectables from './AddObjectables'
import Edit from './Edit'
export default {
  name: 'ObjectTransportTable',
  components: {
    Edit,
    AttributesTable,
    AddObjectables,
  },
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      },
    },
    token: {
      type: String,
      default: '',
    },
  },
  data() {
    return {}
  },
  computed: mapGetters(['allCities']),

  updated() {},
  methods: {
    ...mapMutations(['deleteTransport']),
    ...mapActions(['fetchTransport', 'fetchCities']),
    getTransportCompanyName(id) {
      let company = this.allTransportCompanies.find(item => item.id == id)
      return company.name
    },
    getCityName(id) {
      let cityName = ''
      this.allCities.forEach(city => {
        if (city.id == id) {
          cityName = city.name
        }
      })
      return cityName
    },
    del(id) {
      // this.deleteTransport(id)
    },
  },
}
</script>

<style lang="css" scoped>
</style>
