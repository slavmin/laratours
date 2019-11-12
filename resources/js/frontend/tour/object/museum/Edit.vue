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
        title="Редактировать музей"
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
          {{ 'Редактирование музея: ' + museum.name }}
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
                :action="'/operator/museum/' + museum.id"
                method="POST"
                class="form"
              >
                <v-layout 
                  row 
                  wrap
                >
                  <v-flex xs6>
                    <input 
                      id="_method" 
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
                      :value="museum.name"
                      label="Название музея"
                      name="name"
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-select
                      v-model="city"
                      :items="cities"
                      label="Город"
                      item-text="name"
                      item-value="id"
                      outline
                      :rules="[v => !!v || 'Это обязательное поле']"
                      color="#aa282a"
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
                    <input 
                      type="hidden" 
                      name="city_id" 
                      :value="city"
                    > 
                    <v-select
                      v-model="type"
                      :items="museumTypes"
                      label="Тип музея"
                      multiple
                      hint="Можно выбрать несколько"
                      persistent-hint
                      color="#aa282a"
                      outline
                    />
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
                      name="extra" 
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
                      label="Ф.И.О. сотрудника музея"
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
export default {
  name: 'ObjectMuseumEdit',
  props: {
    museum: {
      type: Object,
      required: true,
      default: null,
    },
    token: {
      type: String,
      default: ''
    },
    citiesSelect: {
      type: Object,
      required: true,
      default: null,
    },
  },
  data() {
    return {
      dialog: false,
      name: '',
      cities: [],
      city: 0,
      address: '',
      site: 'http://',
      email: '',
      phone: '+7-',
      staffName: '',
      staffPhone: '+7-',
      museumTypes: [
        'Исторический', 
        'Художественный', 
        'Научно-познавательный', 
        'Военно-Исторический',
        'Литературный',
        'Интерактивный'
      ],
      type: [],
      about: '',
    }
  },
  computed: {
    details: function () {
      return JSON.stringify({
        museumType: this.type,
        address: this.address,
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
    for (let city in this.citiesSelect.Россия) {
      this.cities.push({'id': city, 'name': this.citiesSelect.Россия[city]})
    }
    this.city = parseInt(this.museum.city_id)
    const museumInfo = JSON.parse(this.museum.extra)
    this.address = museumInfo.address
    this.about = museumInfo.about
    this.type = museumInfo.museumType
    this.site = museumInfo.contacts.site
    this.email = museumInfo.contacts.email
    this.phone = museumInfo.contacts.phone
    this.staffName = museumInfo.staff.name
    this.staffPhone = museumInfo.staff.phone
  },
  methods: {
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