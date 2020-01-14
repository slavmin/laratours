<template>
  <v-card>
    <v-card-title>
      <span class="headline">
        Схема салона: {{ object.name }}
      </span>
    </v-card-title>
    <v-card-text>
      <v-layout
        row
        justify-space-between
      >
        <v-flex xs2>
          <v-spacer />
          <!-- Bus scheme -->
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
                  |__|
                </div>
              </div>
            </div>
          </div>
          <!-- /Bus scheme -->
          <!-- Passengers seats count -->
          <div
            class="container-fluid d-flex justify-content-between align-items-center mb-1"
            style="height: 38px;"
          >
            <p class="mb-0">
              Пассажирских мест: {{ bus.totalPassengersCount }}
            </p>
          </div>
          <!-- /Passengers seats count -->
          <!-- Unavailable seats count -->
          <div
            v-if="bus.unavailable.length > 0"
            class="container-fluid d-flex justify-content-between align-items-center mb-1"
            style="height: 38px;"
          >
            <p class="mb-0">
              Недоступных мест: {{ bus.unavailable.length }}
            </p>
          </div>
          <!-- /Unavailable seats count -->
        </v-flex>
        <v-spacer />
        <v-flex xs3>
          <!-- Controls -->
          <div class="controls d-flex flex-column">
            <!-- Add/remove rows -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <!-- Add button -->
              <button
                class="btn btn-primary rounded mr-2"
                :disabled="bus.rows == 50"
                @click="addRow"
              >
                <i class="fas fa-plus" />
              </button>
              <!-- /Add button -->
              <p class="mb-0">
                Строк: {{ bus.rows }}
              </p> <!-- Show rows count -->
              <!-- Remove button -->
              <button
                class="btn btn-primary rounded ml-2"
                :disabled="bus.rows == 1"
                @click="removeRow"
              >
                <i class="fas fa-minus" />
              </button>
              <!-- /Remove button -->
            </div>
            <!-- /Add/remove rows -->
            <!-- Add/remove cols -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <!-- Add button -->
              <button
                class="btn btn-primary rounded mr-2"
                :disabled="bus.cols == 40"
                @click="addCol"
              >
                <i class="fas fa-plus" />
              </button>
              <!-- /Add button -->
              <p class="mb-0">
                Мест: {{ bus.cols }}
              </p> <!-- Show rows count -->
              <!-- Remove button -->
              <button
                class="btn btn-primary rounded ml-2"
                :disabled="bus.cols == 1"
                @click="removeCol"
              >
                <i class="fas fa-minus" />
              </button>
              <!-- /Remove button -->
            </div>
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 12px;"
            >
              <p
                class="mb-0 text-align-right"
                style="font-size: 10px;"
              >
                Мест в ряду, включая проходы.
              </p>
            </div>
            <!-- /Add/remove cols -->
            <!-- Selected seats -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <p class="mb-0">
                Выделено мест: {{ choosenSeats.length }}
              </p>
            </div>
            <!-- /Selected seats -->
            <!-- Set driver seats button -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <button
                class="btn btn-primary pass control"
                @click="setPass"
              >
                Проход
              </button>
            </div>
            <!-- /Set driver seats button -->
            <!-- Set doors button -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <button
                class="btn btn-primary door control"
                @click="setDoors"
              >
                Двери
              </button>
            </div>
            <!-- /Set doors button -->
            <!-- Set guide seats button -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <button
                class="btn btn-primary guide-seat control"
                @click="setGuideSeats"
              >
                Место гида
              </button>
            </div>
            <!-- /Set guide seats button -->
            <!-- Set common seats button -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <button
                class="btn btn-primary common-seat-btn control"
                @click="setCommonSeats"
              >
                Место пассажира
              </button>
            </div>
            <!-- /Set common seats button -->
            <!-- Set driver seats button -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <button
                class="btn btn-primary driver-seat control"
                @click="setDriverSeats"
              >
                Место водителя
              </button>
            </div>
            <!-- /Set driver seats button -->
            <!-- Set unavailable seats button -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center mb-1"
              style="height: 38px;"
            >
              <button
                class="btn btn-primary unavailable-seat control"
                @click="setUnavailableSeats"
              >
                Недоступно
              </button>
            </div>
            <!-- /Set unavailable seats button -->
            <!-- Make all seats common button -->
            <div
              class="container-fluid d-flex justify-content-between align-items-center"
              style="height: 38px;"
            >
              <button
                class="btn btn-primary reset-btn control"
                @click="reset"
              >
                Сбросить
              </button>
            </div>
            <!-- /Make all seats common button -->
          </div>
          <!-- /Controls -->
        </v-flex>
      </v-layout>
    </v-card-text>
    <!-- <v-card-actions>
      <v-spacer />
      <v-btn 
        color="green darken-1" 
        flat 
        @click="close"
      >
        Закрыть
      </v-btn>
      <form 
        method="POST"
        :action="'/operator/transport/' + companyId" 
      >
        <input 
          id="_method" 
          type="hidden" 
          name="_method" 
          value="PATCH"
        >
        <input 
          type="hidden" 
          name="_token" 
          :value="token"
        > 
        <input 
          :id="attribute + '[id]'" 
          type="hidden" 
          :name="attribute + '[id]'" 
          :value="object.id"
        > 
        <input 
          :id="attribute + '[name]'" 
          type="hidden" 
          :name="attribute + '[name]'" 
          :value="object.name"
        >
        <input 
          :id="attribute + '[description]'" 
          type="hidden" 
          :name="attribute + '[description]'" 
          :value="object.description"
        >
        <input 
          :id="attribute + '[qnt]'" 
          type="hidden" 
          :name="attribute + '[qnt]'" 
          :value="object.qnt"
        >
        <input 
          type="hidden" 
          :value="JSON.stringify(extra)"
          :name="attribute + '[extra]'"
        > 
        <input 
          :id="attribute + '[customer_type_id]'" 
          type="hidden" 
          :name="attribute + '[customer_type_id]'" 
          value="1"
        > 
        <input
          type="hidden" 
          value="1"
          :name="attribute + '[price]'"
        >
        <v-btn 
          color="green darken-1" 
          flat 
          type="submit"
          @click="save"
        >
          Сохранить
        </v-btn>
      </form>
    </v-card-actions> -->
  </v-card>
</template>

<script>
import { mapActions, mapMutations } from 'vuex'
export default {
  name: 'Scheme',
  props: {
    id: {
      type: Number,
      default: () => {
        return 0
      },
    },
    object: {
      type: Object,
      default: () => {
        return {}
      },
    },
    currentScheme: {
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
    new: Boolean,
  },
  data() {
    return {
      showScheme: true,
      bus: {
        rows: 10,
        cols: 4,
        driver: ['1-1', '1-2'],
        doors: ['1-4'],
        guide: ['2-4'],
        pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
        unavailable: [],
        service: [],
        totalPassengersCount: 0,
      },
      defaultScheme: {
        rows: 10,
        cols: 4,
        driver: ['1-1', '1-2'],
        doors: ['1-4'],
        guide: ['2-4'],
        pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
        unavailable: [],
        service: [],
        totalPassengersCount: 0,
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
      extra: {},
      attribute: '',
      initialScheme: {},
    }
  },
  created() {},
  mounted() {
    console.log(this.new)
    if (!this.new) {
      this.extra = JSON.parse(this.object.extra)
      this.initialScheme = Object.assign({}, this.extra.scheme)
      this.bus = Object.assign({}, this.extra.scheme)
    }
    if (this.new) {
      this.bus = this.currentScheme
    }
    this.attribute = 'attribute[' + this.object.id + ']'
    this.drawScheme()
    this.totalPassengersCount = 0
    this.setTotalPassengersCount()
  },
  updated() {
    this.drawScheme()
    this.totalPassengersCount = 0
    this.setTotalPassengersCount()
    // this.setServiceSeats()
    this.extra.scheme = this.bus
    this.$emit('update', this.bus)
  },
  methods: {
    ...mapMutations(['assignNewScheme']),
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
      this.bus.service = []
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
        seat.className = this.defaultClasses + className
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
        this.setSeatClass(choosenSeatId, this.choosenSeatClass)
      })
    },
    chooseSeat(seatId) {
      if (
        this.choosenSeats.find(choosenSeat => {
          return choosenSeat === seatId
        }) === undefined
      ) {
        this.choosenSeats.push(seatId)
      } else {
        this.choosenSeats = this.choosenSeats.filter(seat => seat != seatId)
      }
    },
    setDriverSeats() {
      // Change previous driver seats to common seats
      // this.bus.driver.forEach(driverSeatId => {
      //   this.setSeatClass(driverSeatId, this.commonSeatClass)
      // })
      // Set new driver seats
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.driverSeatClass)
      })
      this.bus.driver = _.concat(this.bus.driver, this.choosenSeats)
      this.choosenSeats = []
    },
    setGuideSeats() {
      // Change previous guide seats to common seats
      // this.bus.guide.forEach(guideSeatId => {
      //   this.setSeatClass(guideSeatId, this.commonSeatClass)
      // })
      // Set new guide seats
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.guideSeatClass)
      })
      this.bus.guide = _.concat(this.bus.guide, this.choosenSeats)
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
      // this.bus.pass.forEach(passId => {
      //   this.setSeatClass(passId, this.commonSeatClass)
      // })
      // Set new pass
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.passClass)
      })
      this.bus.pass = _.concat(this.bus.pass, this.choosenSeats)
      this.choosenSeats = []
    },
    setDoors() {
      // Change previous doors to common seats
      // this.bus.doors.forEach(doorId => {
      //   this.setSeatClass(doorId, this.commonSeatClass)
      // })
      // Set new doors
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.doorClass)
      })
      this.bus.doors = _.concat(this.bus.doors, this.choosenSeats)
      this.choosenSeats = []
    },
    setUnavailableSeats() {
      // Change previous unavailable seats to common seats
      // this.bus.unavailable.forEach(unavailableSeatId => {
      //   this.setSeatClass(unavailableSeatId, this.commonSeatClass)
      // })
      // Set new unavailable seats
      this.choosenSeats.forEach(choosenSeatId => {
        this.removeSeatsFromAllTypes(choosenSeatId)
        this.setSeatClass(choosenSeatId, this.unavailableSeatClass)
      })
      this.bus.unavailable = _.concat(this.bus.unavailable, this.choosenSeats)
      this.choosenSeats = []
    },
    exportBusScheme() {
      this.assignNewScheme({
        id: this.id,
        scheme: this.bus,
      })
    },
    setTotalPassengersCount() {
      let commonSeats = document.getElementsByClassName('common-seat')
      this.bus.totalPassengersCount = commonSeats.length
    },
    close() {
      this.choosenSeats = []
      this.bus = Object.assign({}, this.initialScheme)
      this.showScheme = false
      this.bus.totalPassengersCount = 0
      this.setTotalPassengersCount()
    },
    save() {
      // this.assignNewScheme({
      //   id: this.id,
      //   scheme: this.bus
      // })
      this.scheme = this.bus
      // console.log(this.bus)
      setTimeout(() => {
        this.showScheme = false
      }, 2000)
    },
  },
}
</script>

<style lang="css" scoped>
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
}
.common-seat,
.common-seat-btn,
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
.controls {
  max-width: 300px;
}
.control {
  width: 100%;
}
</style>
