<template>
  <v-container grid-list-xs>
    <h1 class="text-center white--text my-5">
      Уведомление в ГИБДД
    </h1>
    <h2 class="text-center white--text my-5">
      Тур "{{ tourName }}"
    </h2>
    <div class="row">
      <p class="white--text display-1 mb-5">
        Ниже представленная информация была загружена из созданного вами тура,
        на основе внесенных в конструктор и справочники данных. Эта информация
        может быть отправлена на сайт гибдд.рф
        для формирования уведомления о перевозке детей.
      </p>
      <p class="white--text display-1">
        Проверьте данные и, в случае необходимости, отредактируйте:
      </p>
    </div>
    <div class="row justify-content-center">
      <div class="col-xs-2">
        <v-select
          v-model="selectedTourDay"
          :items="tourTransportDays"
          dark
          label="Выберите день тура"
          @input="daySelected"
        />
      </div>
    </div>
    <div v-if="selectedTourDay">
      <div class="row mb-2">
        <div class="col-md-6 col-xs-12">
          <Form1 />
        </div>
        <div class="col-md-6 col-xs-12">
          <Form2 />
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6 col-xs-12">
          <Form3 />
        </div>
        <div class="col-md-6 col-xs-12">
          <Form4 />
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-md-6 col-xs-12">
          <Form5 />
        </div>
        <div class="col-md-6 col-xs-12">
          <Form6 />
        </div>
      </div>
      <p class="alert alert-danger">
        <strong>Внимание:</strong>
        Вносимые изменения не сохраняются. Не закрывайте страницу до отправки
        заявки
        на сайт гибдд.рф!
      </p>
      <v-layout
        row
        wrap
        justify-center
      >
        <v-flex
          xs12
          md8
        >
          <ol class="subheading white--text">
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
      <div class="row justify-content-center">
        <div class="col-xs-2">
          <v-select
            v-model="selectedTourDay"
            :items="tourTransportDays"
            dark
            label="Выберите день тура"
            @input="daySelected"
          />
        </div>
      </div>
      <YandexMap :day-data="streetsByDays[selectedTourDay - 1]" />
      <v-layout
        row
        wrap
        justify-center
      >
        <SendInfoToGibdd />
      </v-layout>
    </div>
  </v-container>
</template>
<script>
import { mapGetters } from 'vuex'
import YandexMap from './YandexMap'
import Form1 from './documents/gibdd/Form1'
import Form2 from './documents/gibdd/Form2'
import Form3 from './documents/gibdd/Form3'
import Form4 from './documents/gibdd/Form4'
import Form5 from './documents/gibdd/Form5'
import Form6 from './documents/gibdd/Form6'
import SendInfoToGibdd from './documents/gibdd/SendInfoToGibdd'
import { mapActions } from 'vuex'
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
    SendInfoToGibdd,
  },
  props: {
    data: {
      type: Object,
      default: () => {},
    },
    tourTransportDays: {
      type: Array,
      default: () => [],
    },
    reqTourDay: {
      type: String,
      default: '',
    },
    tourId: {
      type: String,
      default: '',
    },
    notifyData: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      streetsByDays: [],
      selectedTourDay: NaN,
      dayDataForYandexMap: {},
    }
  },
  computed: {
    ...mapGetters({
      tourName: 'getTourNameForGibddNotify',
    }),
  },
  created() {
    this.parseData()
    this.fillTourInfo(this.notifyData)
    if (this.reqTourDay) this.selectedTourDay = parseInt(this.reqTourDay)
  },
  methods: {
    ...mapActions(['fillTourInfo']),
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
    daySelected() {
      let url = window.location.pathname
      window.location.href = `${url}?tour_id=${this.tourId}&tour_day=${this.selectedTourDay}`
    },
  },
}
</script>