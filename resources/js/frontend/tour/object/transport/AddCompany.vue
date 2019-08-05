<template>
  <v-dialog 
    v-model="dialog" 
    fullscreen 
    lazy
    hide-overlay 
    transition="dialog-bottom-transition"
    @input="setDefaults"
  >
    <template v-slot:activator="{ on }">
      <v-btn 
        fab
        outline
        title="Добавить"
        color="green"
        dark 
        v-on="on"
      >
        <i class="material-icons">
          add
        </i>
      </v-btn>
    </template>
    <v-card>
      <v-toolbar
        dark
        color="green"
      >
        <v-btn 
          icon 
          @click="dialog = false"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          Добавление транспортной компании
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-container>
        <v-layout 
          row 
          wrap
          justify-center
        >
          <v-flex xs12>
            <v-layout 
              row 
              wrap
            >
              <v-form
                ref="form"
                lazy-validation
                action="/operator/transport"
                method="POST"
                class="form"
              >
                <v-layout 
                  row 
                  wrap
                >
                  <v-flex xs6>
                    <input 
                      type="hidden" 
                      name="_token" 
                      :value="token"
                    > 
                    <input 
                      type="hidden" 
                      name="price" 
                      value="1"
                    > 
                    <div class="display-1 mb-3">
                      Общая информация:
                    </div>
                    <v-text-field
                      :value="transport.name"
                      label="Название транспортной компании"
                      name="name"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-select
                      v-model="city"
                      :items="allCities"
                      label="Город"
                      item-text="name"
                      item-value="id"
                      outline
                      :rules="[v => !!v || 'Это обязательное поле']"
                      color="green lighten-3"
                      required
                    />
                    <input 
                      type="hidden" 
                      name="city_id" 
                      :value="city"
                    > 
                    <v-text-field
                      v-model="about"
                      label="Описание"
                      name="about"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <input 
                      v-model="details"
                      type="hidden" 
                      name="description" 
                    > 
                    <div class="display-1 mb-3">
                      Контакты:
                    </div>
                    <v-text-field
                      v-model="site"
                      label="Сайт"
                      name="site"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="email"
                      label="e-mail"
                      name="email"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="phone"
                      label="Телефон"
                      mask="+7 (###) ###-##-##"
                      name="phone"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                  </v-flex>
                  <v-flex xs6>
                    <div class="display-1 mb-3">
                      Сотрудник:
                    </div>
                    <v-text-field
                      v-model="staffName"
                      label="Ф.И.О. сотрудника"
                      name="staffName"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="staffPhone"
                      label="Телефон"
                      mask="+7 (###) ###-##-##"
                      name="staffPhone"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                  </v-flex>
                  <v-layout 
                    row 
                    wrap
                    justify-end
                  >
                    <v-btn 
                      color="green"
                      class="white--text"
                      type="submit"
                    >
                      Сохранить
                    </v-btn>
                  </v-layout>
                </v-layout>
              </v-form>
            </v-layout>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'AddCompany',
  props: {
    transport: {
      type: Object,
      required: true,
      default: () => {
        return {}
      },
    },
    token: {
      type: String,
      default: ''
    },
  },
  data() {
    return {
      dialog: false,
      name: '',
      cities: [],
      city: 0,
      site: 'http://',
      email: '',
      phone: '+7-',
      staffName: '',
      staffPhone: '+7-',
      about: '',
    }
  },
  computed: {
    ...mapGetters(['allCities']),
    details: function () {
      return JSON.stringify({
        about: this.about,
        contacts: {
          site: this.site,
          email: this.email,
          phone: this.phone,
        },
        staff: {
          name: this.staffName,
          phone: this.staffPhone,
        },
      }) 
    }
  },
  created() {
    this.fetchCities()
    this.city = this.transport.city_id
    if (this.transport.description) {
      console.log(this.transport)
      const objectInfo = JSON.parse(this.transport.description)
      this.about = objectInfo.about
      this.site = objectInfo.contacts.site
      this.email = objectInfo.contacts.email
      this.phone = objectInfo.contacts.phone
      this.staffName = objectInfo.staff.name
      this.staffPhone = objectInfo.staff.phone
    }
  },
  methods: {
    ...mapActions(['fetchCities']),
    setDefaults() {

    },
    log() {
      console.log(this.details)
    }
  }
}
</script>
<style lang="css" scoped>
.form {
  width: 100%;
}
</style>