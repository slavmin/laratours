<template>
  <v-card>
    <v-card-title 
      primary-title
      class="white--text"
      style="background-color: #66a5ae;"
    >
      <h3>
        Документы на автобус
      </h3>
    </v-card-title>
    <v-card-text>
      <v-layout 
        row 
        wrap
      >
        <v-flex
          xs12
          md6
        >
          <h4
            v-if="drivers.length > 0" 
            class="grey--text text--darken-1 mb-4"
          >
            Водители ({{ drivers.length }}):
          </h4>
          <v-layout 
            v-if="drivers.length > 0" 
            row 
            wrap
          > 
            <table class="grey--text drivers-table">
              <th>
                ФИО
              </th>
              <th>
                Дата рождения
              </th>
              <th>
                Стаж
              </th>
              <th>
                Действия
              </th>
              <tr
                v-for="(item, i) in drivers"
                :key="i"
              >
                <td class="text-xs-left">
                  {{ item.name }}
                </td>
                <td>
                  {{ item.dob }}
                </td>
                <td>
                  {{ item.exp }}
                </td>
                <td>
                  <v-btn 
                    small
                    fab
                    dark
                    color="red"
                    @click="removeDriver(item)"
                  >
                    <v-icon>close</v-icon>
                  </v-btn>
                </td>
              </tr>
            </table>
            <v-divider />
          </v-layout>
          Добавить водителя:
          <v-layout 
            row 
            wrap
          >
            <v-flex xs12>
              <v-text-field
                v-model="driver.name"
                label="ФИО"
              />
            </v-flex>
            <v-flex 
              xs12 
              md6
            >
              <v-text-field
                v-model="driver.dob"
                label="Дата рождения"
              />
            </v-flex>
            <v-flex 
              xs12 
              md6
            >
              <v-text-field
                v-model="driver.exp"
                label="Стаж категории D"
              />
            </v-flex>
          </v-layout>
          <v-layout 
            row 
            wrap
          >
            <v-btn 
              color="#aa282a"
              dark
              flat
              @click="clearDriver"
            >
              Очистить
            </v-btn>
            <v-spacer />
            <v-btn 
              v-if="driver.name != ''"
              color="#aa282a"
              dark
              @click="addDriver"
            >
              Добавить
              <v-icon right>
                add
              </v-icon>
            </v-btn>  
          </v-layout>
        </v-flex>
        <v-flex
          xs12
          md6
        >
          <h4 class="grey--text text--darken-1 mb-2">
            Данные по транспортному средству:
          </h4>
          Номер Диагностическая карта Свидетельство регистрации ТС
          Наличие Глонасс Эраглонасс Страховка
        </v-flex> 
      </v-layout>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'TransportDocs',
  data() {
    return {
      driver: {
        name: '',
        dob: '',
        exp: 0,
      },
      drivers: [],
    }
  },
  methods: {
    clearDriver() {
      this.driver = {
        name: '',
        dob: '',
        exp: 0,
      }
    },
    addDriver() {
      this.drivers.push(this.driver)
      this.clearDriver()
    },
    removeDriver(item) {
      this.drivers = this.drivers.filter(driver => driver != item)
    }
  }
}
</script>
<style lang="scss" scoped>
.drivers-table {
  width: 100%;
  font-size: 14px;
  th {
    font-size: 16px;
    border-bottom: solid 2px #e3e3e3;
    padding-bottom: 6px;
  }
}
</style>