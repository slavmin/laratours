<template>
  <v-row>
    <!-- Choose transport -->
    <v-col cols="12">
      <h2 class="text-xs-center grey--text">
        Выберите транспорт:
      </h2>
      <div
        v-for="transport in actualTransport"
        :key="transport.id"
        align-center
        mb-5
        class="text-center"
      >
        <div class="display-2">
          {{ transport.name }}
          <div class="title">
            {{ transport.city_name }}
          </div>
        </div>
        <v-row justify-center>
          <v-col
            v-for="item in transport.objectables"
            :key="item.id"
            xs3
            lg2
            ma-2
          >
            <Transport
              :transport="transport"
              :item="item"
              :days="days"
              :tour-date="tourDate"
              :tour-id="tourId"
            />
            <!-- :days="days" -->
          </v-col>
        </v-row>
      </div>
    </v-col>
    <!-- /Choose transport -->
    <v-btn
      dark
      fab
      class="done-btn"
      color="#aa282a"
    >
      <i class="material-icons">
        arrow_forward
      </i>
    </v-btn>
  </v-row>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Transport from './Transport'
export default {
  name: 'ChooseTransport',
  components: {
    Transport,
  },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      actualTransport: [],
      days: 0,
      tourDate: null,
    }
  },
  mounted() {
    this.fetchObjects()
  },
  methods: {
    fetchObjects() {
      axios
        .get('/api/get-detailed-tour-objects', {
          params: {
            tour_id: this.tourId,
            model_alias: 'transport',
          },
        })
        .then(r => {
          this.actualTransport = r.data.transport_options
          this.days = r.data.days
          this.tourDate = r.data.tour_date
        })
    },
  },
}
</script>

<style lang="css" scoped>
.transport-card {
  background-color: #e8f5e9;
}
.is-select {
  background-color: #ffab16;
  color: white;
  transform: scale(0.9);
}
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
