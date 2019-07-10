<template>
  <v-layout 
    row 
    justify-center
  >
    <v-dialog
      v-model="showScheme"
      lazy
      persistent
    >
      <template v-slot:activator="{ on }">
        <v-btn 
          color="green" 
          dark
          flat
          small 
          v-on="on"
        >
          Схема
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Схема салона</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout 
              row
              justify-space-between
            >
              <v-flex
                xs2
              >
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
              </v-flex>
              <v-flex
                xs3
              >
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
                      @click="addRow"
                    >
                      <i class="fas fa-plus" />
                    </button>
                    <!-- /Add button -->
                    <p class="mb-0">
                      Рядов: {{ bus.rows }}
                    </p> <!-- Show rows count -->
                    <!-- Remove button -->
                    <button 
                      class="btn btn-primary rounded ml-2"
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
                  <!-- Reset button -->
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
                  <!-- /Reset button -->
                </div>
                <!-- /Controls -->
              </v-flex>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn 
            color="green darken-1" 
            flat 
            @click="close"
          >
            Закрыть
          </v-btn>
          <v-btn 
            color="green darken-1" 
            flat 
            @click="save"
          >
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
import { mapMutations } from 'vuex'
export default {

  name: 'Scheme',
  props: {
    scheme: {
      type: Object,
      default: () => {
        return {
          rows: 10,
          cols: 4,
          driver: ['1-1', '1-2'],
          doors: ['1-4'],
          guide: ['2-4'],
          pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
          unavailable: [],
          totalPassengersCount: 0
        }
      }
    },
    id: {
      type: Number,
      default: () => {
        return 0
      }
    }
  },
  data() {
    return {
      showScheme: false,
      bus: {
          rows: 10,
          cols: 4,
          driver: ['1-1', '1-2'],
          doors: ['1-4'],
          guide: ['2-4'],
          pass: ['1-3', '2-3', '3-3', '4-3', '5-3', '6-3', '7-3', '8-3', '9-3'],
          unavailable: [],
          totalPassengersCount: 0
        },
      defaultClasses: 'seat btn mr-1 ',
      commonSeatClass: 'common-seat',
      driverSeatClass: 'driver-seat',
      guideSeatClass: 'guide-seat',
      passClass: 'pass',
      doorClass: 'door',
      choosenSeatClass: 'choosen-seat',
      choosenSeats: [],
      unavailableSeatClass: 'unavailable-seat'
    };
  },
  created() {
    this.bus = Object.assign({}, this.scheme)
    console.log('hi')
  },
  mounted() {
    this.drawScheme()
    this.totalPassengersCount = 0
    this.setTotalPassengersCount()
  },
  updated() {
    this.drawScheme()
    this.totalPassengersCount = 0
    this.setTotalPassengersCount()
  },
  methods: {
    ...mapMutations(['assignNewScheme']),
    addRow() {
      this.bus.rows++
    },
    removeRow() {
      this.bus.rows--
    },
    addCol() {
      this.bus.cols++
    },
    removeCol() {
      this.bus.cols--
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
      if (this.choosenSeats.find(choosenSeat => { return choosenSeat === seatId }) === undefined) {
      this.choosenSeats.push(seatId)
      }
    },
    setDriverSeats() {
      // Change previous driver seats to common seats
      this.bus.driver.forEach(driverSeatId => {
        this.setSeatClass(driverSeatId, this.commonSeatClass)
      })
      // Set new driver seats
      this.choosenSeats.forEach(choosenSeatId => {
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
        this.setSeatClass(choosenSeatId, this.guideSeatClass)
      })
      this.bus.guide = this.choosenSeats
      this.choosenSeats = []
    },
    setPass() {
      // Change previous pass to common seats
      this.bus.pass.forEach(passId => {
        this.setSeatClass(passId, this.commonSeatClass)
      })
      // Set new pass
      this.choosenSeats.forEach(choosenSeatId => {
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
        this.setSeatClass(choosenSeatId, this.unavailableSeatClass)
      })
      this.bus.unavailable = this.choosenSeats
      this.choosenSeats = []
    },
    exportBusScheme() {
      this.assignNewScheme({
        id: this.id,
        scheme: this.bus
      })
    },
    setTotalPassengersCount() {
      let commonSeats = document.getElementsByClassName('common-seat')
      this.bus.totalPassengersCount = commonSeats.length
    },
    close () {
      console.log(this.bus)
      console.log(this.scheme)
      this.bus = Object.assign({}, this.scheme)
      this.showScheme = false
    },
    save() {
      this.assignNewScheme({
        id: this.id,
        scheme: this.bus
      })
      this.scheme = this.bus
      console.log(this.bus)
      console.log(this.scheme)
    }
  }
};
</script>

<style lang="css" scoped>
.bus {
  /*border: 1px solid black;*/
  padding: 6px;
}
.seat {
  cursor: pointer;
  color: white;
  padding: 3px !important;
  padding-bottom: 0px !important;
  background-color: black;
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
  background-color: #F3F3F3;
  border-color: #F3F3F3;
  color: #F3F3F3;
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
  background-color: #A1A1A1;
  border-color: #A1A1A1;
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
  max-width: 250px;
}
.control {
  width: 100%;
}
</style>
