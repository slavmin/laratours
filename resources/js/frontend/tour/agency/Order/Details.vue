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
                Место: 
                <span class="seat">
                  {{ profile.busSeatId }}
                </span>
              </div>
              <div>
                Документ: {{ profile.passport }}
              </div>
              <div>
                Дата рождения: {{ profile.dob }}
              </div>
              <div>
                Телефон: {{ profile.phone }}
              </div>
            </v-card-text>
          </v-card>
        </v-layout>
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