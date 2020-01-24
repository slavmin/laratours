<template>
  <v-container grid-list-xs>
    <v-btn
      color="green"
      class="no-print"
      dark
      @click="saveMap"
    >
      Сохранить схему
    </v-btn>
    <v-layout
      row
      wrap
    >
      <div id="result" />
      <div
        id="map"
        style="width: 900px; height: 600px"
      />
    </v-layout>
    <v-layout
      row
      wrap
    >
      <v-flex>
        {{ routes }}
        <ul
          id="street-list--day-1"
          class="street-list street-list--day-1"
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
            color="green"
            class="no-print"
            dark
            @click="buildMap"
          >
            Построить схему
          </v-btn>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import { Sortable } from '@shopify/draggable'
import html2canvas from 'html2canvas'

export default {
  name: 'YandexMap',
  props: {
    streets: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      routes: [],
      newAddress: '',
    }
  },
  mounted() {
    this.routes = this.streets
    setTimeout(() => {
      this.buildMap()
    }, 2000)
    this.addSortable()
    // this.buildMap()
  },
  methods: {
    resetMap() {
      let div = document.getElementById('map')
      div.innerHTML = ''
    },
    buildMap() {
      this.resetMap()
      console.log(this.routes)
      var myMap = new ymaps.Map('map', {
        center: [55.751574, 37.573856],
        zoom: 9,
        controls: ['largeMapDefaultSet'],
      })

      // Построение маршрута.
      // По умолчанию строится автомобильный маршрут.
      var multiRoute = new ymaps.multiRouter.MultiRoute(
        {
          // Точки маршрута. Точки могут быть заданы как координатами, так и адресом.
          referencePoints: this.routes,
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
        document.getElementById('street-list--day-1'),
        {
          draggable: 'li',
        }
      )

      //sortable.on('sortable:start', () => console.log('sortable:start'))
      //sortable.on('sortable:sort', () => console.log('sortable:sort'))
      //sortable.on('sortable:sorted', () => this.rebuildRoutesArray())
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
        const list = document.getElementById('street-list--day-1')
        const listItems = list.querySelectorAll('li')
        console.log('TCL: rebuildRoutesArray -> listItems', listItems)
        let newRoutes = []
        listItems.forEach(item => {
          const address = item.querySelector('span')
          newRoutes.push(address.innerText)
        })
        this.routes = newRoutes
        console.log(this.routes)
      }, 500)
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
.street-list {
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
</style>