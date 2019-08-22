<template>
  <v-dialog
    v-model="dialog"
  >
    <template v-slot:activator="{ on }">
      <v-btn
        color="green"
        flat
        small
        dark
        v-on="on"
      >
        Подробнее
      </v-btn>
    </template>
    <v-card>
      <v-card-text>
        <div>
          <h3 class="title grey--text text-xs-center">
            Данные по заказу №{{ orderId }}
          </h3>
          <v-layout 
            row 
            wrap
          >
            <v-card
              v-for="(profile, k) in profiles[0].content" 
              :key="k"
              color="#c2c2c2" 
              class="black--text"
              style="max-width: 300px; margin: 16px;"
            >
              <v-card-title primary-title>
                <div class="headline">
                  {{ profile.first_name + ' ' + profile.last_name }}
                </div>   
              </v-card-title>
              <v-card-text>
                <div>
                  Пол: {{ profile.gender }}
                </div>
                <div>
                  Место: 
                  <span class="seat">
                    {{ profile.busSeatId }}
                  </span>
                </div>
                <div>
                  Документ: {{ profile.passport }}
                </div>
                <div v-if="profile.dob">
                  Дата рождения: {{ profile.dob }}
                </div>
                <div v-if="profile.address">
                  Адрес: {{ profile.address }}
                </div>
                <div>
                  Телефон: {{ profile.phone }}
                </div>
                <v-divider />
                <div>
                  Номер: {{ parseInt(profile.room) + 1 }}
                </div>
              </v-card-text>
            </v-card>
          </v-layout>
        </div>
        <div v-if="profiles[0].content[0].chat">
          <h3 class="title grey--text text-xs-center">
            Комментарии к заявке
          </h3>
          <div>
            <span class="sender body-2">
              {{ JSON.parse(profiles[0].content[0].chat).sender }}:
            </span>
            <span class="text body-1">
              {{ JSON.parse(profiles[0].content[0].chat).text }}
            </span>
            <br>
            <span class="date grey--text">
              {{ JSON.parse(profiles[0].content[0].chat).date }}
            </span>
          </div>
        </div>
      </v-card-text>
      <v-divider />
      <v-card-actions>
        <v-spacer />
        <v-btn
          color="green"
          flat
          @click="dialog = false"
        >
          Закрыть
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'OrderDetails',
  props: {
    profiles: {
      type: Array,
      default: () => {
        return []
      },
    },
    orderId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      dialog: false,
    }
  },
}
</script>

<style lang="scss" scoped>
.seat {
  padding: 6px;
  background-color: #ffa83b;
  border-radius: 3px;
}
</style>