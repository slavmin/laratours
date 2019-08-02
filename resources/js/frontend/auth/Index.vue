<template>
  <v-container grid-list-xs>
    <v-layout
      row
      wrap
    >
      <v-flex xs12>
        <div>
          <v-tabs
            v-model="active"
            color="green"
            dark
            slider-color="yellow"
          >
            <v-tab
              v-for="item in items"
              :key="item.id"
              ripple
            >
              {{ item.name }}
            </v-tab>
            <!-- Юр лицо -->
            <v-tab-item>
              <v-card flat>
                <v-card-text>
                  <transition name="fade">
                    <div v-if="showInnReg">
                      <h2 class="text-center grey--text">
                        Регистрация по ИНН
                        <i
                          :title="innHelp" 
                          class="material-icons"
                        >
                          info
                        </i>
                      </h2>
                      <v-layout 
                        row 
                        wrap
                        justify-center
                      >
                        <v-flex xs2>
                          <v-text-field
                            v-model="inn"
                            label="ИНН"
                          />
                        </v-flex>
                        <v-flex xs1>
                          <v-btn
                            color="green"
                            class="white--text"
                            :disabled="inn.length != 10"
                            @click="getCompanyInfo"
                          >
                            OK
                          </v-btn>
                        </v-flex>
                      </v-layout>
                    </div>
                  </transition>
                  <transition name="fade">
                    <div
                      v-if="showCompanyInfo"
                    >
                      <UlForm 
                        :token="token"
                        :company-info="companyInfo" 
                      />
                    </div>
                  </transition>
                  <v-layout 
                    row 
                    wrap
                    justify-end
                  >
                    <v-btn 
                      v-if="!showCompanyInfo"
                      flat
                      color="green" 
                      dark
                      @click="manual"
                    >
                      Заполнить все поля вручную
                    </v-btn>
                  </v-layout>
                </v-card-text>
              </v-card>
            </v-tab-item>
            <!-- /Юр лицо -->
            <!-- Физ лицо -->
            <v-tab-item>
              <v-card flat>
                <v-card-text>Регистрация физ.лица</v-card-text>
              </v-card>
            </v-tab-item>
            <!-- /Физ лицо -->
          </v-tabs>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import UlForm from './UlForm'
export default {
  name: 'SelectType',
  components: {
    UlForm,
  },
  props: {
    token: {
      type: String,
      default: ''
    },
  },
  data() {
    return {
      active: null,
      items: [
        { 
          id: 1, 
          name: 'Юр. лицо', 
          text: 'Регистрация юр.лица'
        },
        {
          id: 2,
          name: 'Физ. лицо',
          text: 'Регистрация физ. лица'
        }
      ],
      innHelp: 'Введите ИНН и большинство полей заполнится автоматически',
      showInnReg: true,
      inn: '',
      showCompanyInfo: false,
      companyInfo: {},
    } 
  },
  created() {
  },
  methods: {
    getCompanyInfo() {
      const baseURL = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party'
      const data = {
        query: this.inn
      }
      axios({
        data,
        baseURL,
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Token bcd7695a45ca98c7be6fc6978b20aa45fd1549fc'
        },
      })
        .then(r => {
          const data = r.data.suggestions[0]
          const result = {
            name: data.value,
            country: data.data.address.data.country,
            region: data.data.address.data.region_with_type,
            address: data.data.address.value,
            inn: data.data.inn,
            kpp: data.data.kpp
          }
          this.companyInfo = result
        })
        .catch(e => console.log(e))
      this.showCompanyInfo = true
    },
    manual() {
      this.showInnReg = false
      this.showCompanyInfo = true
    }
  }
}
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1.2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
</style>
