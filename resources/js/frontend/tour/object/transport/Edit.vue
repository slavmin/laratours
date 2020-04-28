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
        small
        fab
        title="Редактировать"
        color="#aa282a"
        dark
        v-on="on"
      >
        <i class="material-icons">
          edit
        </i>
      </v-btn>
    </template>
    <v-card>
      <v-toolbar
        dark
        color="#66a5ae"
      >
        <v-btn
          icon
          @click="dialog = false"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          {{ 'Редактирование транспортной компании: ' + transport.name }}
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
                :action="'/operator/transport/' + transport.id"
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
                      name="_method"
                      value="PATCH"
                    >
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
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-autocomplete
                      v-model="city"
                      :items="allCities"
                      label="Город"
                      item-text="name"
                      item-value="id"
                      outline
                      :rules="[v => !!v || 'Это обязательное поле']"
                      color="#aa282a"
                      required
                    />
                    <v-text-field
                      v-model="formalAddress"
                      label="Юридический адрес"
                      name="formalAddress"
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="address"
                      label="Адрес"
                      name="address"
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="inn"
                      label="ИНН"
                      name="inn"
                      mask="############"
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
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
                      color="#aa282a"
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
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="email"
                      label="e-mail"
                      name="email"
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="phone"
                      label="Телефон"
                      name="phone"
                      color="#aa282a"
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
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="staffPhone"
                      label="Телефон"
                      name="staffPhone"
                      color="#aa282a"
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
                      color="#aa282a"
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
  name: 'ObjectTransportCompanyEdit',
  props: {
    transport: {
      type: Object,
      required: true,
      default: null,
    },
    token: {
      type: String,
      default: '',
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
      address: '',
      formalAddress: '',
    }
  },
  computed: {
    ...mapGetters(['allCities']),
    details: function() {
      return JSON.stringify({
        about: this.about,
        address: this.address,
        formalAddress: this.formalAddress,
        inn: this.inn,
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
    },
  },
  created() {
    this.fetchCities()
    this.city = parseInt(this.transport.city_id)
    const objectInfo = JSON.parse(this.transport.description)
    this.about = objectInfo.about
    this.address = objectInfo.address
    this.formalAddress = objectInfo.formalAddress
    this.inn = objectInfo.inn
    this.site = objectInfo.contacts.site
    this.email = objectInfo.contacts.email
    this.phone = objectInfo.contacts.phone
    this.staffName = objectInfo.staff.name
    this.staffPhone = objectInfo.staff.phone
  },
  methods: {
    ...mapActions(['fetchCities']),
    setDefaults() {},
    log() {
      console.log(this.details)
    },
  },
}
</script>
<style lang="css" scoped>
.form {
  width: 100%;
}
</style>