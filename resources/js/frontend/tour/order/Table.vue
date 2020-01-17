<template>
  <v-expansion-panel>
    <v-expansion-panel-content
      v-for="tour in getTours"
      :key="tour.tourId"
    >
      <template v-slot:header>
        <v-container fluid>
          <v-layout
            row
            wrap
            justify-space-between
            align-baseline
          >
            <v-flex xs6>
              <div class="headline">
                «{{ tourInfos[tour.tourId].name }}»
                <span
                  v-if="tourInfos[tour.tourId].deleted_at"
                  right
                  class="text-xs-center subheading"
                  style="color: red;"
                >
                  Тур удалён
                </span>
              </div>
              <div class="grey--text subheading">
                {{ getCitiesNames(tourInfos[tour.tourId].cities_list) }}
              </div>
            </v-flex>
            <v-flex xs4>
              <span class="grey--text">
                Дата отъезда:
              </span>
              <span class="subheading">
                {{ getTourInfo(tour.tourId).dateStart }}
              </span>
            </v-flex>
          </v-layout>
          <v-divider />
          <v-layout
            row
            wrap
            justify-center
          >
            <v-flex>
              Мест всего:
              <span class="qnt qnt-total">
                {{ getTourInfo(tour.tourId).qnt }}
              </span>
              Забронировано:
              <span class="qnt qnt-ordered">
                {{ tourInfos[tour.tourId].ordered_qnt }}
              </span>
              Свободных:
              <span class="qnt qnt-free">
                {{ getTourInfo(tour.tourId).qnt - tourInfos[tour.tourId].ordered_qnt }}
              </span>
            </v-flex>
          </v-layout>
        </v-container>
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
import moment from 'moment'
export default {
  name: 'OrdersTable',
  components: {
    Profiles,
  },
  props: {
    agencies: {
      type: Object,
      default: () => {
        return {}
      },
    },
    statuses: {
      type: Array,
      default: () => {
        return []
      },
    },
    tourNames: {
      type: Object,
      default: () => {
        return []
      },
    },
    tourInfos: {
      type: Object,
      default: () => {
        return {}
      },
    },
    cities: {
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
  computed: {
    ...mapGetters(['getTours']),
  },
  mounted() {
    console.log(this.cities)
  },
  methods: {
    touristsCount(content) {
      let count = 0
      for (let key in content) {
        count += 1
      }
      return count
    },
    getCitiesNames(cities) {
      let cityName = ''
      cities.forEach(cityId => {
        _.toArray(this.cities).forEach((city, i) => {
          if (i == cityId) {
            cityName += this.cities[i] + '. '
          }
        })
      })
      return cityName
    },
    getTourInfo(tourId) {
      const tourExtra = JSON.parse(this.tourInfos[tourId].extra)
      const result = {
        qnt: tourExtra.qnt,
        dateStart: moment(tourExtra.options.dateStart).format('LL'),
        cities: this.getCitiesNames(tourExtra.options.cities),
      }
      return result
    },
  },
}
</script>
<style lang="scss">
.qnt {
  display: inline-block;
  width: 26px;
  height: 26px;
  text-align: center;
  border-radius: 50%;
  line-height: 24px;
  color: white;
  margin-left: 6px;
  margin-right: 12px;
}
.qnt-total {
  background: #a6a6ff;
}
.qnt-ordered {
  background: #40be1c;
}
.qnt-free {
  background: #f98b8b;
}
</style>