<template>
  <v-card style="margin-bottom: 24px;">
    <v-card-title
      class="white--text"
      style="background-color: #66a5ae;"
    >
      <h2>День {{ dayData.day }}</h2>
    </v-card-title>
    <v-card-text>
      <v-layout
        row
        wrap
      >
        <v-flex>
          <h3>Объекты выбранные в туре:</h3>
          <ul>
            <li
              v-for="object in objectsAtDay"
              :key="object"
            >
              {{ object }}
            </li>
          </ul>
        </v-flex>
        <v-flex>
          <h3>Распознанные адреса объектов:</h3>
          <ul
            :id="`address-list--${mapId}`"
            :class="`address-list address-list--${mapId}`"
          >
            <li
              v-for="(address, i) in routes"
              :key="i"
            >
              <span class="address-text">{{ address }}</span>
              <button
                class="btn-remove"
                @click="removeAddress(address)"
              >
                x
              </button>
            </li>
          </ul>
        </v-flex>
        <v-flex>
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
          <v-layout
            row
            wrap
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
        </v-flex>
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
import { Sortable } from '@shopify/draggable'
import html2canvas from 'html2canvas'

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
    }
  },
  computed: {
    mapId: function() {
      return `map-${this.dayData.day}`
    },
  },
  mounted() {
    this.makeRoutesArray()
    setTimeout(() => {
      this.buildMap()
    }, 2000)
    this.addSortable()
    // this.buildMap()
  },
  methods: {
    makeRoutesArray() {
      this.dayData.points.forEach(point => {
        if (point.address != 'Адрес не указан') {
          this.routes.push(point.address)
        }
        this.objectsAtDay.push(
          `${point.name}: ${point.event}. ${point.address}`
        )
      })
      this.routesForMap = this.routes
      console.log(this.objectsAtDay)
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
      this.newAddress = ''
      this.rebuildRoutesArray()
    },
    removeAddress(address) {
      this.routes = this.routes.filter(item => item != address)
      this.rebuildRoutesArray()
    },
    rebuildRoutesArray() {
      setTimeout(() => {
        const list = document.getElementById(`address-list--${this.mapId}`)
        const listItems = list.querySelectorAll('li')
        console.log(
          'TCL: rebuildRoutesArray -> listItems',
          listItems,
          this.mapId
        )
        let newRoutes = []
        listItems.forEach(item => {
          const address = item.querySelector('span')
          newRoutes.push(address.innerText)
        })
        this.routesForMap = newRoutes
        this.showLoader = false
      }, 1000)
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
    padding: 8px;
    border: 2px solid grey;
    margin-top: -2px;
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