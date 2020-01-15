<template>
  <v-container grid-list-xs>
    <v-layout
      row
      wrap
    >
      <div
        id="map"
        style="width: 900px; height: 600px"
      />
    </v-layout>
  </v-container>
</template>
<script>
export default {
  name: 'YandexMap',
  props: {
    streets: {
      type: Array,
      default: () => [],
    },
  },
  mounted() {
    this.buildMap()
  },
  methods: {
    buildMap() {
      var myMap = new ymaps.Map('map', {
        center: [55.751574, 37.573856],
        zoom: 9,
        controls: [],
      })

      // Построение маршрута.
      // По умолчанию строится автомобильный маршрут.
      var multiRoute = new ymaps.multiRouter.MultiRoute(
        {
          // Точки маршрута. Точки могут быть заданы как координатами, так и адресом.
          referencePoints: this.streets,
        },
        {
          // Автоматически устанавливать границы карты так,
          // чтобы маршрут был виден целиком.
          boundsAutoApply: true,
        }
      )

      // Добавление маршрута на карту.
      myMap.geoObjects.add(multiRoute)
    },
  },
}
</script>