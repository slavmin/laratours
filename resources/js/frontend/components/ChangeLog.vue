<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      width="500"
    >
      <template v-slot:activator="{ on }">
        <v-list-tile
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
              {{ `${item.date}: ` }}
            </span>
            <ul>
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
import moment from 'moment'
export default {
  name: 'ChangeLog',
  data () {
    return {
      dialog: false,
      allNews: [
        {
          date: moment('20191028').locale('ru-ru').format('LL'),
          changes: [
            { 
              forAgency: false,
              text: 'Убран ввод суммы по заказу на стороне Агентства.'
            },
            { 
              forAgency: false,
              text: 'Добавлено брендирование "Алфавит".'
            },
            { 
              forAgency: false,
              text: 'Скрыт выбор питания при оформлении заказа.'
              
            },
            { 
              forAgency: true,
              text: 'Убраны лишние ссылки из "Управления" у Агентства.'
            },
            { 
              forAgency: true,
              text:'Добавлен этот компонент.',
            }
          ]
        }
      ]
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
      } else {
        result = this.allNews
      }
      return result
    }
  }
}
</script>