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
      <v-row>
        <v-col
          cols="12"
          md="6"
        >
          <h4
            v-if="drivers.length > 0"
            class="grey--text text--darken-1 mb-4"
          >
            Водители ({{ drivers.length }}):
          </h4>
          <v-row v-if="drivers.length > 0">
            <table class="grey--text drivers-table mb-5">
              <th>
                ФИО
              </th>
              <th>
                Дата рождения
              </th>
              <th>
                Вод. удостоверение
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
                  {{ item.license }}
                </td>
                <td>
                  {{ item.exp }}
                </td>
                <td>
                  <v-btn
                    small
                    fab
                    text
                    dark
                    color="yellow"
                    @click="editDriver(item)"
                  >
                    <v-icon>edit</v-icon>
                  </v-btn>
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
          </v-row>
          <h4 class="grey--text text--darken-1 mb-2">
            Добавить водителя:
          </h4>
          <v-row>
            <v-col cols="12">
              <v-text-field
                v-model="driver.name"
                label="ФИО"
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-text-field
                v-model="driver.dob"
                label="Дата рождения"
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-text-field
                v-model="driver.exp"
                label="Стаж категории D"
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                v-model="driver.license"
                label="Водительское удостоверение"
              />
            </v-col>
          </v-row>
          <v-row>
            <v-btn
              color="#aa282a"
              dark
              text
              @click="clearDriver"
            >
              Очистить
            </v-btn>
            <v-spacer />
            <!-- Add new driver -->
            <v-btn
              v-if="!editDriverMode"
              color="#aa282a"
              dark
              :disable="driver.name == ''"
              @click="addDriver"
            >
              Добавить
              <v-icon right>
                add
              </v-icon>
            </v-btn>
            <!-- Edit driver -->
            <v-btn
              v-if="editDriverMode"
              color="#aa282a"
              dark
              text
              @click="cancelEditDriver"
            >
              Отменить изменения
            </v-btn>
            <v-btn
              v-if="editDriverMode"
              color="#aa282a"
              dark
              @click="addDriver"
            >
              Сохранить
            </v-btn>
          </v-row>
        </v-col>
        <v-col
          cols="12"
          md="6"
        >
          <h4 class="grey--text text--darken-1 mb-2">
            Данные по транспортному средству:
          </h4>
          <v-row>
            <v-col
              cols="12"
              md="6"
            >
              <v-text-field
                v-model="bus.regNumber"
                label="Госномер"
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-text-field
                v-model="bus.diagCard"
                label="Диагностическая карта"
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-text-field
                v-model="bus.regCert"
                label="Свидетельство о регистрации ТС"
              />
            </v-col>
            <v-col
              cols="12"
              md="6"
            >
              <v-text-field
                v-model="bus.insurance"
                label="Страховка"
              />
            </v-col>
            <v-col>
              <v-switch
                v-model="bus.glonass"
                color="#aa282a"
                label="Глонасс"
              />
            </v-col>
            <v-col>
              <v-switch
                v-model="bus.eraGlonass"
                color="#aa282a"
                label="Эра-глонасс"
              />
            </v-col>
          </v-row>
          <v-row justify="end">
            <v-btn
              color="#aa282a"
              dark
              text
              @click="clearBus"
            >
              Очистить
            </v-btn>
          </v-row>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'TransportDocs',
  props: {
    editMode: Boolean,
    busData: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
  data() {
    return {
      driver: {
        name: '',
        dob: '',
        exp: 0,
        license: '',
      },
      drivers: [],
      bus: {
        regNumber: '',
        diagCard: '',
        regCert: '',
        glonass: false,
        eraGlonass: false,
        insurance: '',
      },
      editDriverMode: false,
      prevDriverData: {},
    }
  },
  updated() {
    this.$emit('update', {
      drivers: this.drivers,
      bus: this.bus,
    })
  },
  mounted() {
    if (this.editMode) {
      this.drivers = this.busData.drivers
      this.bus = this.busData.busDocs
    }
  },
  methods: {
    clearDriver() {
      this.driver = {
        name: '',
        dob: '',
        exp: 0,
        license: '',
      }
    },
    clearBus() {
      this.bus = {
        regNumber: '',
        diagCard: '',
        regCert: '',
        glonass: false,
        eraGlonass: false,
        insurance: '',
      }
    },
    addDriver() {
      this.drivers.push(this.driver)
      this.clearDriver()
    },
    removeDriver(item) {
      this.drivers = this.drivers.filter(driver => driver != item)
    },
    editDriver(driver) {
      this.editDriverMode = true
      this.prevDriverData = Object.assign({}, driver)
      this.removeDriver(driver)
      this.driver = driver
    },
    cancelEditDriver() {
      this.drivers.push(this.prevDriverData)
      this.prevDriverData = {}
      this.driver = {}
      this.editDriverMode = false
    },
  },
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