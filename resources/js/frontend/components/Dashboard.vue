<template>
  <v-container
    fluid
    grid-list-xs
    style="background-color: #66a5ae;"
  >
    <v-layout
      row
      wrap
      justify-center
    >
      <v-flex xs12>
        <h1 class="text-xs-center white--text mb-4">
          <v-icon
            color="white"
            large
          >
            speed
          </v-icon>
          {{ headerText }}
        </h1>
      </v-flex>
    </v-layout>
    <v-layout
      row
      wrap
    >
      <v-flex sm7>
        <v-card>
          <v-card-title primary-title>
            <div
              class="headline"
              style="color: #979694;"
            >
              Вас приветствует туроператор "{{ teamData.name }}"!
            </div>
          </v-card-title>
          <v-divider />
          <v-card-text>
            <span class="subheading">
              Здесь вы можете подобрать и оформить заказ на туры в
              Санкт-Петербург от туроператора {{ teamData.name }}.
              <br>
              Так же мы предлагаем школьные экскурсии , сборные туры для детей и
              взрослых, туристические поездки по России, Золотое кольцо и
              многое-многое другое!
            </span>
          </v-card-text>
        </v-card>
        <v-layout
          row
          wrap
          mt-5
        >
          <v-flex xs6>
            <v-card>
              <v-card-title primary-title>
                <div
                  class="headline"
                  style="color: #979694;"
                >
                  Управление турами
                </div>
              </v-card-title>
              <v-divider />
              <v-card-text>
                <v-btn
                  v-for="item in management"
                  :key="item.text"
                  flat
                >
                  <a
                    :href="item.url"
                    class="link"
                  >
                    <v-icon>
                      {{ item.icon }}
                    </v-icon>
                    {{ item.text }}
                  </a>
                </v-btn>
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-flex>
      <v-spacer />
      <v-flex sm4>
        <v-card>
          <v-img :src="accountImgUrl" />
          <v-card-title primary-title>
            <div style="color: #979694;">
              <h3 class="headline mb-2">
                {{ userName }}
              </h3>
              <div class="mb-2">
                <v-icon>email</v-icon>
                <span class="subheading">{{ userEmail }}</span>
              </div>
              <div>
                <v-icon>calendar_today</v-icon>
                <span class="subheading">
                  {{ `${joinedText}: ${joinedTime}` }}
                </span>
              </div>
            </div>
          </v-card-title>

          <v-card-actions>
            <v-spacer />
            <v-btn
              :href="accountUrl"
              dark
              color="#ac2728"
            >
              <span style="color: #ffc5c3;">
                {{ accountText }}
              </span>
            </v-btn>
          </v-card-actions>
        </v-card>
        <v-layout
          row
          wrap
          justify-center
        >
          <v-btn
            v-if="showFillDemo && dataIsNotLoaded"
            color="green"
            dark
            @click="fillDemoData"
          >
            Заполнить профиль демо данными
          </v-btn>
          <v-alert
            v-model="showFillDemoDataSuccess"
            type="success"
            color="green"
            dismissible
          >
            В ваш аккаунт добавлены демонстрационные данные:
            <ul>
              <li>
                Типы туристов
              </li>
              <li>
                Категории размещения
              </li>
              <li>
                Отели и номера
              </li>
              <li>
                Гид
              </li>
              <li>
                Сопровождающий
              </li>
            </ul>
          </v-alert>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
  name: 'Dashboard',
  props: {
    team: {
      type: String,
      default: () => {
        return {}
      },
    },
    headerText: {
      type: String,
      default: 'Header',
    },
    userName: {
      type: String,
      default: 'UserName',
    },
    userEmail: {
      type: String,
      default: 'user@tour-click.ru',
    },
    joinedText: {
      type: String,
      default: 'user@tour-click.ru',
    },
    joinedTime: {
      type: String,
      default: '01.07.2019',
    },
    accountUrl: {
      type: String,
      default: '#',
    },
    accountText: {
      type: String,
      default: 'tourclick!',
    },
    accountImgUrl: {
      type: String,
      default: '#',
    },
    showFillDemo: {
      type: String,
      default: 'false',
    },
  },
  data() {
    return {
      managementOperator: [
        {
          text: 'Заказы',
          url: '/operator/order',
          icon: 'check_circle_outline',
        },
        {
          text: 'Туры',
          url: '/operator/tour',
          icon: 'flight_takeoff',
        },
        {
          text: 'Типы туров',
          url: '/operator/type',
          icon: 'commute',
        },
        {
          text: 'Категории размещения',
          url: '/operator/hotel-category',
          icon: 'grade',
        },
        {
          text: 'Страны / Города',
          url: '/operator/country',
          icon: 'location_city',
        },
        {
          text: 'Размещения',
          url: '/operator/hotel',
          icon: 'hotel',
        },
        {
          text: 'Питание',
          url: '/operator/meal',
          icon: 'fastfood',
        },
        {
          text: 'Транспорт',
          url: '/operator/transport',
          icon: 'directions_bus',
        },
        {
          text: 'Гиды',
          url: '/operator/guide',
          icon: 'nature_people',
        },
        {
          text: 'Сопровождающие',
          url: '/operator/attendant',
          icon: 'nature_people',
        },
      ],
      managementAgency: [
        {
          text: 'Заказы',
          url: '/agency/order',
          icon: 'check_circle_outline',
        },
        {
          text: 'Туры',
          url: '/agency/tours',
          icon: 'flight_takeoff',
        },
      ],
      isAgency: false,
      dataIsNotLoaded: true,
      showFillDemoDataSuccess: false,
    }
  },
  computed: {
    ...mapGetters({
      management: 'getNavLinks',
    }),
    teamData: function() {
      if (this.team == '') return {}
      return JSON.parse(this.team)
    },
  },
  mounted() {},
  methods: {
    fillDemoData() {
      axios
        .post(`/modules/fill-demo-data?team_id=${this.teamData.id}`)
        .then(response => {
          console.log(response)
          this.dataIsNotLoaded = false
          this.showFillDemoDataSuccess = true
        })
    },
  },
}
</script>
<style lang="scss" scoped>
.link {
  color: #8c9399;
  &:hover {
    border: none;
    text-decoration: none;
  }
}
</style>