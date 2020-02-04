<template>
  <v-container grid-list-xs>
    <h1 class="text-xs-center">
      Маршруты
    </h1>
    <Form1 />
    <Form2 />
    <Form3 />
    <Form4 />
    <Form5 />
    <Form6 />
    <v-layout
      row
      wrap
      justify-center
    >
      <v-flex
        xs12
        md8
      >
        <ol class="subheading">
          <li>
            Схема формируется на основе адресов, указанных в справочниках
            объектов.
          </li>
          <li>
            Если вам не хватает объекта, вы можете его добавить в графе
            "Добавить
            адрес"
            <a
              href="/img/frontend/gibdd/hint1.png"
              target="_blank"
            >
              ссылка
            </a>
          </li>
          <li>
            Установите пункты посещения объектов в нужном вам порядке путем
            перетаскивания строк с адресами в нужной вам последовательности.
            После этого нажмите на кнопку "Построить схему"
            <a
              href="/img/frontend/gibdd/hint2.png"
              target="_blank"
            >
              ссылка
            </a>
          </li>
          <li>
            Для того, чтобы сохранить, или распечатать схему нажмите на
            заголовок
            "Открыть маршрут"
            <a
              href="/img/frontend/gibdd/hint3.png"
              target="_blank"
            >
              ссылка
            </a>
          </li>
          <li>
            В открывшемся окне нажмите на значок печати и следуйте подказкам
            системы
            <a
              href="/img/frontend/gibdd/hint4.png"
              target="_blank"
            >
              ссылка
            </a>
          </li>
        </ol>
      </v-flex>
    </v-layout>
    <YandexMap
      v-for="(dayData, i) in streetsByDays"
      :key="i"
      :day-data="dayData"
    />
  </v-container>
</template>
<script>
import YandexMap from './YandexMap'
import Form1 from './gibdd/Form1'
import Form2 from './gibdd/Form2'
import Form3 from './gibdd/Form3'
import Form4 from './gibdd/Form4'
import Form5 from './gibdd/Form5'
import Form6 from './gibdd/Form6'
export default {
  name: 'TourRoutes',
  components: {
    YandexMap,
    Form1,
    Form2,
    Form3,
    Form4,
    Form5,
    Form6,
  },
  props: {
    data: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      streetsByDays: [],
    }
  },
  created() {
    this.parseData()
  },
  methods: {
    parseData() {
      for (const [key, value] of Object.entries(this.data)) {
        if (key != 0) {
          const dayInfo = {
            day: key,
            points: value,
          }
          this.streetsByDays.push(dayInfo)
        }
      }
    },
  },
}
</script>