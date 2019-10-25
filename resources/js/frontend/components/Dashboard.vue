<template>
  <div>
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
                ТурКлик начинает свою работу!
              </div>
            </v-card-title>
            <v-divider />
            <v-card-text>
              <span class="subheading">
                Добро пожаловать в ТурКлик! Сейчас вы находитесь в панели управления. По вашим пожеланиям мы вынесем сюда необходимые и удобные для вас ссылки, разделы, графики и отчёты.
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
            <v-img
              :src="accountImgUrl"
            />
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
                  <span class="subheading">{{ `${joinedText}: ${joinedTime}` }}</span>
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
                <span
                  style="color: #ffc5c3;"
                >
                  {{ accountText }}
                </span>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
    <v-footer class="pa-3">
      <v-spacer />
      <a 
        href="http://tour-click.ru"
        class="mr-3"  
      >
        TourClick
      </a>
      <div>&copy; {{ new Date().getFullYear() }}</div>
    </v-footer>
  </div>
</template>
<script>
export default {
  name: 'Dashboard',
  props: {
    headerText: {
      type: String,
      default: 'Header'
    },
    userName: {
      type: String,
      default: 'UserName'
    },
    userEmail: {
      type: String,
      default: 'user@tour-click.ru'
    },
    joinedText: {
      type: String,
      default: 'user@tour-click.ru'
    },
    joinedTime: {
      type: String,
      default: '01.07.2019'
    },
    accountUrl: {
      type: String,
      default: '#'
    },
    accountText: {
      type: String,
      default: 'tourclick!'
    },
    accountImgUrl: {
      type: String,
      default: '#'
    },
  },
  data() {
    return {
      management: [
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
        }
      ],
    }
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