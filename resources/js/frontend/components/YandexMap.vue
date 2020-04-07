<template>
  <v-card style="margin-bottom: 24px;">
    <v-card-title
      class="white--text"
      style="background-color: #66a5ae;"
    >
      <h2>Маршрут</h2>
    </v-card-title>
    <v-card-text>
      <v-layout
        row
        wrap
        justify-center
      >
        <v-flex
          xs12
          md4
          xl4
        >
          <h3 class="grey--text">
            Адрес места начала перевозки:
          </h3>
          <v-radio-group v-model="info.address_start">
            <v-radio
              v-for="object in routes"
              :key="object"
              :label="object"
              :value="object"
            />
          </v-radio-group>
        </v-flex>
        <v-flex
          xs12
          md7
          xl4
        >
          <h3 class="grey--text">
            Адреса промежуточных остановочных пунктов и места окончания
            перевозки:
          </h3>
          <ul
            :id="`address-list--${mapId}`"
            :class="`address-list address-list--${mapId}`"
          >
            <li
              v-for="(address, i) in routes"
              :key="i"
            >
              <v-layout
                row
                wrap
              >
                <v-flex xs6>
                  <p class="grey-text">
                    {{ getObjectName(address) }}
                  </p>
                  <span class="address-text">
                    {{ address }}
                  </span>
                  <button
                    class="btn-remove"
                    @click="removeAddress(address)"
                  >
                    x
                  </button>
                </v-flex>
                <v-flex xs6>
                  <v-text-field
                    :id="`goal_${address}`"
                    label="Цель стоянки"
                    @input="goalChanged(address)"
                  />
                  <v-text-field
                    :id="`time_${address}`"
                    label="Планируемое время стоянки (ЧЧ:ММ)"
                    @input="timeChanged(address)"
                  />
                </v-flex>
              </v-layout>
            </li>
          </ul>
          <v-layout
            row
            wrap
          >
            <v-text-field
              v-model="newAddress"
              class="no-print"
              clearable
              label="Добавить адрес"
              @keyup.enter="addNewAddress"
            />
            <v-btn
              color="green"
              class="no-print"
              dark
              fab
              small
              @click="addNewAddress"
            >
              <v-icon>add</v-icon>
            </v-btn>
          </v-layout>
        </v-flex>
      </v-layout>
      <v-divider />
      <v-layout
        row
        wrap
        justify-center
      >
        <v-btn
          v-if="!showLoader"
          color="green"
          class="no-print"
          dark
          @click="buildMap"
        >
          Построить схему
        </v-btn>
        <div
          v-if="showLoader"
          class="loadingio-spinner-dual-ball-2lx0oq2r636"
        >
          <div class="ldio-z4c08nm4i3">
            <div />
            <div />
            <div />
          </div>
        </div>
      </v-layout>
      <v-layout
        row
        wrap
      >
        <div
          :id="mapId"
          style="width: 100%; height: 600px"
        />
      </v-layout>
    </v-card-text>
  </v-card>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import { Sortable } from '@shopify/draggable'
import html2canvas from 'html2canvas'
import axios from 'axios'
export default {
  name: 'YandexMap',
  props: {
    dayData: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      routes: [],
      newAddress: '',
      objectsAtDay: [],
      routesForMap: [],
      showLoader: false,
      goals: [],
    }
  },
  computed: {
    ...mapGetters({
      info: 'getForm6',
    }),
    mapId: function() {
      return `map`
    },
  },
  watch: {
    objectsAtDay: {
      handler: function(val) {
        this.updateStopPoints(val)
      },
      deep: true,
    },
    routesForMap: {
      handler: function(val) {
        let result = []
        val.forEach(address => {
          let object = this.objectsAtDay.find(object => {
            return object.address == address
          })
          result.push(object)
        })
        this.objectsAtDay = result
      },
      deep: true,
    },
  },
  mounted() {
    console.log(this.dayData)
    this.makeRoutesArray()
    setTimeout(() => {
      this.buildMap()
    }, 2000)
    this.addSortable()
    // this.buildMap()
  },
  methods: {
    ...mapActions(['updateStopPoints']),
    makeRoutesArray() {
      this.dayData.points.forEach(point => {
        if (point.address != 'Адрес не указан') {
          this.routes.push(point.address)
        }
        this.objectsAtDay.push({
          name: point.name,
          event: point.event,
          address: point.address,
          goal: '',
          time: '',
        })
      })
      this.routesForMap = this.routes
    },
    resetMap() {
      let div = document.getElementById(this.mapId)
      div.innerHTML = ''
    },
    buildMap() {
      this.resetMap()
      var myMap = new ymaps.Map(this.mapId, {
        center: [55.751574, 37.573856],
        zoom: 9,
        controls: [],
        // controls: ['largeMapDefaultSet'],
      })

      // Построение маршрута.
      // По умолчанию строится автомобильный маршрут.
      var multiRoute = new ymaps.multiRouter.MultiRoute(
        {
          // Точки маршрута. Точки могут быть заданы как координатами, так и адресом.
          referencePoints: this.routesForMap,
        },
        {
          // Автоматически устанавливать границы карты так,
          // чтобы маршрут был виден целиком.
          boundsAutoApply: true,
          // Опция editorDrawOver запрещает ставить точки поверх объектов карты
          // (в режиме добавления новых точек). Это нужно для того,
          // чтобы пользователи могли создавать промежуточные
          // точки по линии маршрута.
          editorDrawOver: false,
          // Опция editorMidPointsType задает тип промежуточных точек,
          // которые будут создаваться на маршруте.
          // "via" - будут создаваться транзитные точки;
          // "way" - путевые точки.
          editorMidPointsType: 'via',
        }
      )
      multiRoute.editor.start({
        // При включении опции addWayPoints пользователи смогут создавать
        // путевые точки по клику на карте.
        addWayPoints: true,
        // При включении опции removeWayPoints пользователи смогут удалять
        // путевые точки.
        // Для удаления точки нужно дважды кликнуть по ней.
        removeWayPoints: true,
        // При включении опции addMidPoints пользователи смогут создавать
        // новые промежуточные точки.
        // Чтобы создать промежуточную точку, нужно кликнуть по линии маршрута и,
        // удерживая кнопку, переместить точку в нужную позицию на карте.
        // Тип промежуточной точки (путевая или транзитная) задается в опции
        // editorMidPointsType.
        addMidPoints: true,
      })
      // Добавление маршрута на карту.
      myMap.geoObjects.add(multiRoute)
    },
    addSortable() {
      const sortable = new Sortable(
        document.getElementById(`address-list--${this.mapId}`),
        {
          draggable: 'li',
        }
      )

      sortable.on('sortable:start', () => (this.showLoader = true))
      // sortable.on('sortable:sort', () => console.log('sortable:sort'))
      // sortable.on('sortable:sorted', () => console.log('sortable:sorted'))
      sortable.on('sortable:stop', () => this.rebuildRoutesArray())
    },
    addNewAddress() {
      this.routes.push(this.newAddress)
      this.objectsAtDay.push({
        name: 'Адрес добавлен вручную',
        event: '',
        address: this.newAddress,
        goal: '',
        time: '',
      })
      this.newAddress = ''
      this.rebuildRoutesArray()
    },
    removeAddress(address) {
      this.routes = this.routes.filter(item => item != address)
      this.objectsAtDay = this.objectsAtDay.filter(
        object => object.address != address
      )
      this.rebuildRoutesArray()
    },
    rebuildRoutesArray() {
      setTimeout(() => {
        const list = document.getElementById(`address-list--${this.mapId}`)
        const listItems = list.querySelectorAll('li')
        let newRoutes = []
        listItems.forEach(item => {
          const address = item.querySelector('span')
          newRoutes.push(address.innerText.trim())
        })
        this.routesForMap = newRoutes
        this.showLoader = false
      }, 1000)
    },
    getObjectName(address) {
      const object = this.objectsAtDay.find(object => object.address == address)
      const result = `${object.name}`
      return result
    },
    goalChanged(address) {
      const goal = document.getElementById(`goal_${address}`).value
      let object = this.objectsAtDay.find(object => {
        return object.address == address
      })
      object.goal = goal
    },
    timeChanged(address) {
      const time = document.getElementById(`time_${address}`).value
      let object = this.objectsAtDay.find(object => {
        return object.address == address
      })
      object.time = time
    },
    saveMap() {
      const map = document.getElementById('map')
      const options = {
        // foreignObjectRendering: true,
        imageTimeout: 30000,
        onclone: function(doc) {
          console.log('onclone: ', doc)
        },
      }
      html2canvas(map, options).then(function(canvas) {
        let result = document.getElementById('result')
        console.log(result)
        result.appendChild(canvas)
      })
    },
  },
}
</script>
<style lang="scss" scoped>
.address-list {
  padding: 10px;
  list-style-type: none;
  li {
    position: relative;
    padding: 8px;
    border: 2px solid grey;
    margin-top: -2px;
  }
  li:after {
    position: absolute;
    right: -30px;
    top: 40%;
    content: '';
    display: block;
    width: 20px;
    height: 20px;
    background-image: url('/img/frontend/icons/format-line-spacing.svg');
    cursor: grab;
  }
}
.btn-remove {
  margin: 2px;
  padding: 6px;
  color: red;
  &:hover {
    background-color: yellow;
  }
}
@keyframes ldio-z4c08nm4i3-o {
  0% {
    opacity: 1;
    transform: translate(0 0);
  }
  49.99% {
    opacity: 1;
    transform: translate(40px, 0);
  }
  50% {
    opacity: 0;
    transform: translate(40px, 0);
  }
  100% {
    opacity: 0;
    transform: translate(0, 0);
  }
}
@keyframes ldio-z4c08nm4i3 {
  0% {
    transform: translate(0, 0);
  }
  50% {
    transform: translate(40px, 0);
  }
  100% {
    transform: translate(0, 0);
  }
}
.ldio-z4c08nm4i3 div {
  position: absolute;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  top: 30px;
  left: 10px;
}
.ldio-z4c08nm4i3 div:nth-child(1) {
  background: #aa282a;
  animation: ldio-z4c08nm4i3 1s linear infinite;
  animation-delay: -0.5s;
}
.ldio-z4c08nm4i3 div:nth-child(2) {
  background: #66a5ae;
  animation: ldio-z4c08nm4i3 1s linear infinite;
  animation-delay: 0s;
}
.ldio-z4c08nm4i3 div:nth-child(3) {
  background: #aa282a;
  animation: ldio-z4c08nm4i3-o 1s linear infinite;
  animation-delay: -0.5s;
}
.loadingio-spinner-dual-ball-2lx0oq2r636 {
  width: 64px;
  height: 64px;
  display: inline-block;
  overflow: hidden;
  background: transparent;
}
.ldio-z4c08nm4i3 {
  width: 100%;
  height: 100%;
  position: relative;
  transform: translateZ(0) scale(0.64);
  backface-visibility: hidden;
  transform-origin: 0 0; /* see note above */
}
.ldio-z4c08nm4i3 div {
  box-sizing: content-box;
}
/* generated by https://loading.io/ */
</style>