<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on }">
        <v-list-tile
          class="black--text menu-text"
          v-on="on"
        >
          <v-list-tile-title>
            Список обновлений
          </v-list-tile-title>
        </v-list-tile>
      </template>
      <v-card>
        <v-card-title
          class="headline white--text"
          style="background-color: #66a5ae;"
          primary-title
        >
          Что нового:
        </v-card-title>
        <v-card-text>
          <div
            v-for="(item, i) in news"
            :key="i"
          >
            <span
              class="body-2"
            >
              {{ `${formatDate(item.date)}: ` }}
            </span>
            <ul class="changes-list">
              <li
                v-for="(message, k) in item.changes"
                :key="`${item.date}-${k}`"
              > 
                {{ message.text }}
              </li>
            </ul>
          </div>
        </v-card-text>
        <v-divider />
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="#aa282a"
            dark
            @click="dialog = false"
          >
            Закрыть
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
const allNews =  './ChangeLog.json'
import moment from 'moment'
export default {
  name: 'ChangeLog',
  data () {
    return {
      dialog: false,
      allNews: [],
    }
  },
  computed: {
    ...mapGetters({
      status: 'getNavBarStatus'
    }),
    news: function() {
      let result = []
      if (this.status.agency) {
        this.allNews.forEach((item) => {
          result.push({
            date: item.date,
            changes: [...item.changes]
          })
        })
        result.forEach((item) => {
          item.changes = item.changes.filter(message => message.forAgency)
        })
        result = result.filter(item => item.changes.length > 0)
      } else {
        result = this.allNews
      }
      return result
    }
  },
  mounted() {
    axios.get('/changelog.json')
      .then((res) => {
        this.allNews = res.data
      })
      .catch(e => console.log('changelog error: ', e))
  },
  methods: {
    formatDate(date) {
      return moment(date).locale('ru-ru').format('LL')
    }
  }
}
</script>
<style lang="scss" scoped>
.changes-list {
  li {
    text-align: left;
  }
}
.menu-link {
  &:hover {
    text-decoration: none;
  }
}
.menu-text {
  &:hover {
    background-color: #66a5ae;
    color: white !important;
  }
}
</style>