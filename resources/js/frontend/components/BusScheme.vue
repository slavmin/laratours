<template>
  <div>
    <v-row>
      <v-col>
        <h4 class="grey--text">
          Место в автобусе:
          <v-chip
            v-if="choosenSeats[0]"
            class="ma-2"
            color="pink"
            label
            text-color="white"
            close
            @click:close="clearSeat"
          >
            {{ choosenSeats[0] }}
          </v-chip>
          <input
            type="hidden"
            :name="`customer[${profileId}][busSeatId]`"
            :value="choosenSeats[0]"
          >
        </h4>
      </v-col>
    </v-row>
    <v-btn
      color="#aa282a"
      title="Схема салона"
      dark
      small
      @click="showScheme = true"
    >
      Выбрать
    </v-btn>
    <v-dialog
      v-if="showScheme"
      v-model="showScheme"
      max-width="800"
      hide-overlay
    >
      <v-card>
        <v-card-title>
          <span
            style="color: #868080;"
            class="headline"
          >
            Схема салона:
            {{ transport.name ? transport.name : 'Default bus' }}
          </span>
        </v-card-title>
        <v-card-text>
          <v-container
            fluid
            grid-list-md
          >
            <v-layout
              row
              justify-center
            >
              <v-flex>
                <v-spacer />
                <!-- Bus scheme -->
                {{ profileBusSeatId }}
                <div class="bus">
                  <div
                    v-for="row in bus.rows"
                    :key="row"
                    class="d-flex flex-row mb-1"
                  >
                    <div
                      v-for="col in bus.cols"
                      :key="col"
                    >
                      <div
                        :id="[row + '-' + col]"
                        class="seat"
                        @click="chooseSeat(row + '-' + col)"
                      >
                        {{ row }} - {{ col }}
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /Bus scheme -->
              </v-flex>
              <v-flex>
                <p class="headline text-xs-right">
                  <span class="grey--text">
                    Всего пассажирских мест:
                  </span>
                  {{ bus.totalPassengersCount }}
                </p>
                <p class="headline text-xs-right">
                  <span class="orange--text">
                    Свободно:
                  </span>
                  {{ freePassengersCount }}
                </p>
                <v-alert
                  :value="showServiceError"
                  color="red"
                  type="error"
                >
                  Это не пассажирское место.
                </v-alert>
                <v-alert
                  :value="showOrderedError"
                  color="red"
                  type="error"
                >
                  Это место занято.
                </v-alert>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="#aa282a"
            dark
            @click="close"
          >
            Закрыть
          </v-btn>
          <v-btn
            color="#aa282a"
            dark
            class="ml-2"
            @click="save"
          >
            Выбрать
          </v-btn>
        </v-card-actions>
        <v-snackbar
          v-model="snackbar"
          multi-line
          bottom
          vertical
          color="pink"
        >
          {{ fakeText }}
          <v-btn
            color="white"
            text
            @click="snackbar = false"
          >
            <v-icon>close</v-icon>
          </v-btn>
        </v-snackbar>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'BusScheme',
  props: {
    profileId: {
      type: Number,
      default: () => {
        return 0
      },
    },
    transport: {
      type: Object,
      default: () => {
        return {}
      },
    },
    companyId: {
      type: Number,
      default: () => {
        return 0
      },
    },
    token: {
      type: String,
      default: '',
    },
    editMode: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      showScheme: false,
      showServiceError: false,
      showOrderedError: false,
      bus: {
        rows: 10,
        cols: 4,
        driver: ['1-1', '1-2'],
        doors: ['1-4'],
        guide: ['2-4'],
        pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
        unavailable: [],
        ordered: [],
        current: [],
        seatsInCurrentOrder: [],
      },
      defaultClasses: 'seat btn mr-1 ',
      commonSeatClass: 'common-seat',
      driverSeatClass: 'driver-seat',
      guideSeatClass: 'guide-seat',
      passClass: 'pass',
      doorClass: 'door',
      choosenSeatClass: 'choosen-seat',
      choosenSeats: [],
      unavailableSeatClass: 'unavailable-seat',
      orderedSeatClass: 'ordered-seat',
      currentSeatClass: 'current-seat',
      extra: {},
      attribute: '',
      initialScheme: {},
      orderedSeats: [],
      selectedInThisFormSeat: '',
      snackbar: false,
      text: 'За последний час этот тур заказали 5 человек!',
    }
  },
  computed: {
    ...mapGetters(['getOrderedSeats', 'getSeatsInCurrentOrder']),
    fakeOrderedSeats() {
      return 10
    },
    fakeFreeSeats() {
      return this.bus.totalPassengersCount - this.fakeOrderedSeats
    },
    fakeText: function() {
      let orderedCount = 0
      if (this.bus.ordered) {
        this.bus.ordered.forEach(orderedSeatId => {
          if (orderedSeatId != null) {
            orderedCount += 1
          }
        })
      }
      if (orderedCount > 0)
        return `Этот тур уже заказали ${orderedCount} чел.! Смотрят сейчас: ${orderedCount +
          3}`
      return `4 человека смотрят этот тур прямо сейчас!`
    },
    freePassengersCount: function() {
      let result =
        this.bus.totalPassengersCount -
        this.bus.ordered.length -
        this.choosenSeats.length
      if (this.getSeatsInCurrentOrder) {
        result -= this.getSeatsInCurrentOrder.length
      }
      return result
    },
    profileBusSeatId: function() {
      return this.$store.getters.getProfileBusSeatId(this.profileId)
    },
  },
  watch: {
    choosenSeats: function() {
      this.drawScheme()
    },
    getOrderedSeats: function() {
      this.bus.ordered = this.getOrderedSeats
    },
    getSeatsInCurrentOrder: function() {
      this.bus.current = this.getSeatsInCurrentOrder
    },
    profileBusSeatId: function() {
      this.choosenSeats[0] = this.profileBusSeatId
    },
  },
  created() {
    this.attribute = 'attribute[' + this.transport.id + ']'
  },
  mounted() {
    if (this.transport.extra !== null && this.transport.extra !== undefined) {
      this.extra = JSON.parse(this.transport.extra)
      this.initialScheme = Object.assign({}, this.extra.scheme)
      this.bus = Object.assign({}, this.extra.scheme)
    } else {
      this.initialScheme = this.bus
    }
    this.drawScheme()
    this.setServiceSeats()
    this.bus.ordered = this.getOrderedSeats
    this.bus.current = this.getSeatsInCurrentOrder
    this.snackbar = true
  },
  updated() {
    this.drawScheme()
    this.extra.scheme = this.bus
  },
  methods: {
    ...mapActions([
      'updateSeatsInCurrentOrder',
      'removeSeatFromCurrent',
      'updateProfileBusSeatId',
    ]),
    addRow() {
      this.bus.rows++
    },
    removeRow() {
      const indicator = String(this.bus.rows + '-')
      this.removeExtraSeats(indicator)
      this.bus.rows--
    },
    addCol() {
      this.bus.cols++
    },
    removeCol() {
      const indicator = String('-' + this.bus.cols)
      this.removeExtraSeats(indicator)
      this.bus.cols--
    },
    removeExtraSeats(indicator) {
      this.bus.driver = this.bus.driver.filter(
        seat => !seat.includes(indicator)
      )
      this.bus.doors = this.bus.doors.filter(seat => !seat.includes(indicator))
      this.bus.guide = this.bus.guide.filter(seat => !seat.includes(indicator))
      this.bus.pass = this.bus.pass.filter(seat => !seat.includes(indicator))
      this.bus.unavailable = this.bus.unavailable.filter(
        seat => !seat.includes(indicator)
      )
      this.choosenSeats = this.choosenSeats.filter(
        seat => !seat.includes(indicator)
      )
    },
    removeSeatsFromAllTypes(indicator) {
      this.bus.driver = this.bus.driver.filter(
        seat => !seat.includes(indicator)
      )
      this.bus.doors = this.bus.doors.filter(seat => !seat.includes(indicator))
      this.bus.guide = this.bus.guide.filter(seat => !seat.includes(indicator))
      this.bus.pass = this.bus.pass.filter(seat => !seat.includes(indicator))
      this.bus.unavailable = this.bus.unavailable.filter(
        seat => !seat.includes(indicator)
      )
    },
    reset() {
      this.bus.driver = []
      this.bus.doors = []
      this.bus.pass = []
      this.bus.guide = []
      this.bus.unavailable = []
      this.choosenSeats = []
      this.drawScheme()
    },
    setAllSeatsCommon() {
      if (this.showScheme) {
        let seats = document.getElementsByClassName('seat')
        Array.from(seats).forEach(seat => {
          seat.className = this.defaultClasses + this.commonSeatClass
        })
      }
    },
    setSeatClass(seatId, className) {
      if (this.showScheme) {
        let seat = document.getElementById(seatId)
        if (seat) seat.className = this.defaultClasses + className
      }
    },
    drawScheme() {
      this.setAllSeatsCommon()
      // Driver seats
      this.bus.driver.forEach(driverSeatId => {
        this.setSeatClass(driverSeatId, this.driverSeatClass)
      })
      // Guide seats
      this.bus.guide.forEach(guideSeatId => {
        this.setSeatClass(guideSeatId, this.guideSeatClass)
      })
      // Pass
      this.bus.pass.forEach(passId => {
        this.setSeatClass(passId, this.passClass)
      })
      // Doors
      this.bus.doors.forEach(doorId => {
        this.setSeatClass(doorId, this.doorClass)
      })
      // Unavailable seats
      this.bus.unavailable.forEach(unavailableSeatId => {
        this.setSeatClass(unavailableSeatId, this.unavailableSeatClass)
      })
      // Choosen
      this.choosenSeats.forEach(choosenSeatId => {
        if (choosenSeatId != null) {
          this.setSeatClass(choosenSeatId, this.choosenSeatClass)
        }
      })
      // Ordered
      if (this.bus.ordered) {
        this.bus.ordered.forEach(orderedSeatId => {
          if (orderedSeatId != null) {
            this.setSeatClass(orderedSeatId, this.orderedSeatClass)
          }
        })
      }
      // Current order seats
      if (this.bus.current) {
        this.bus.current.forEach(currentSeatId => {
          if (currentSeatId != null) {
            this.setSeatClass(currentSeatId, this.currentSeatClass)
          }
        })
      }
    },
    chooseSeat(seatId) {
      if (
        this.bus.service.find(serviceSeat => {
          return serviceSeat === seatId
        }) !== undefined
      ) {
        this.showServiceError = true
        setTimeout(() => {
          this.showServiceError = false
        }, 2000)
      } else if (
        this.bus.ordered.find(orderedSeat => {
          return orderedSeat === seatId
        }) !== undefined
      ) {
        this.showOrderedError = true
        setTimeout(() => {
          this.showOrderedError = false
        }, 2000)
      } else {
        this.showError = false
        if (
          this.choosenSeats.find(choosenSeat => {
            return choosenSeat === seatId
          }) === undefined
        ) {
          this.choosenSeats = []
          this.choosenSeats.push(seatId)
          this.removeSeatFromCurrent(this.selectedInThisFormSeat)
        } else {
          this.choosenSeats = this.choosenSeats.filter(seat => seat != seatId)
        }
      }
      if (this.editMode) {
        this.removeSeatFromCurrent(this.profileBusSeatId)
      }
    },
    setDriverSeats() {
      // Change previous driver seats to common seats
      this.bus.driver.forEach(driverSeatId => {
        this.setSeatClass(driverSeatId, this.commonSeatClass)
      })
      // Set new driver seats
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.driverSeatClass)
      })
      this.bus.driver = this.choosenSeats
      this.choosenSeats = []
    },
    setGuideSeats() {
      // Change previous guide seats to common seats
      this.bus.guide.forEach(guideSeatId => {
        this.setSeatClass(guideSeatId, this.commonSeatClass)
      })
      // Set new guide seats
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.guideSeatClass)
      })
      this.bus.guide = this.choosenSeats
      this.choosenSeats = []
    },
    setCommonSeats() {
      this.choosenSeats.forEach(seatId => {
        this.removeSeatsFromAllTypes(seatId)
      })
      this.choosenSeats = []
      this.drawScheme()
    },
    setPass() {
      // Change previous pass to common seats
      this.bus.pass.forEach(passId => {
        this.setSeatClass(passId, this.commonSeatClass)
      })
      // Set new pass
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.passClass)
      })
      this.bus.pass = this.choosenSeats
      this.choosenSeats = []
    },
    setDoors() {
      // Change previous doors to common seats
      this.bus.doors.forEach(doorId => {
        this.setSeatClass(doorId, this.commonSeatClass)
      })
      // Set new doors
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.doorClass)
      })
      this.bus.doors = this.choosenSeats
      this.choosenSeats = []
    },
    setUnavailableSeats() {
      // Change previous unavailable seats to common seats
      this.bus.unavailable.forEach(unavailableSeatId => {
        this.setSeatClass(unavailableSeatId, this.commonSeatClass)
      })
      // Set new unavailable seats
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.unavailableSeatClass)
      })
      this.bus.unavailable = this.choosenSeats
      this.choosenSeats = []
    },
    setServiceSeats() {
      // Unavailable seats for order
      this.bus.service = _.concat(
        this.bus.doors,
        this.bus.driver,
        this.bus.guide,
        this.bus.pass,
        this.bus.unavailable
      )
    },
    close() {
      //this.choosenSeats = []
      if (this.profileBusSeatId) {
        this.choosenSeats[0] = this.profileBusSeatId
        this.updateProfileBusSeatId({
          profileId: this.profileId,
          busSeatId: this.choosenSeats[0],
        })
        this.updateSeatsInCurrentOrder(this.profileBusSeatId)
      }
      this.bus = Object.assign({}, this.initialScheme)
      this.setServiceSeats()
      this.bus.ordered = this.getOrderedSeats
      this.bus.current = this.getSeatsInCurrentOrder
      this.showScheme = false
    },
    save() {
      this.updateProfileBusSeatId({
        profileId: this.profileId,
        busSeatId: this.choosenSeats[0],
      })
      this.selectedInThisFormSeat = this.choosenSeats[0]
      this.updateSeatsInCurrentOrder(this.choosenSeats[0])
      this.showScheme = false
    },
    clearSeat() {
      this.removeSeatFromCurrent(this.choosenSeats[0])
      this.choosenSeats = []
    },
  },
}
</script>

<style lang="css" scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.bus {
  /*border: 1px solid black;*/
  padding: 6px;
  max-width: 225px;
  position: relative;
  z-index: 10;
}
.spaces {
  position: relative;
  z-index: 1;
}
.seat {
  cursor: pointer;
  color: white;
  padding: 3px !important;
  padding-bottom: 0px !important;
  background-color: black;
  width: 50px;
  height: 50px;
}
.common-seat,
.reset-btn {
  background-color: green;
  border-color: green;
}
.driver-seat {
  background-color: gray;
  border-color: gray;
}
.pass {
  background-color: #f3f3f3;
  border-color: #f3f3f3;
  color: #f3f3f3;
}
.pass.control {
  color: gray;
}
.door {
  background-color: white;
  border-color: white;
}
.door.control {
  border-color: black;
  color: gray;
}
.choosen-seat {
  background-color: #ffc107;
  border-color: #ffc107;
}
.guide-seat {
  background-color: #a1a1a1;
  border-color: #a1a1a1;
}
.unavailable-seat {
  background-color: #212121;
  border-color: #212121;
  color: #212121;
}
.unavailable-seat.control {
  color: white;
}
.ordered-seat {
  background-color: #fa0000;
  border-color: #fa0000;
}
.current-seat {
  background-color: #00fa60;
}
.controls {
  max-width: 300px;
}
.control {
  width: 100%;
}
</style>
