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
        outline
        title="Редактировать"
        color="green"
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
        color="green"
      >
        <v-btn 
          icon 
          @click="dialog = false"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          {{ 'Редактирование ресторана: ' + meal.name }}
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
                :action="'/operator/meal/' + meal.id"
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
                      :value="meal.name"
                      label="Название отеля"
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
                      v-model="type"
                      label="Макс. группа"
                      name="about"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      mask="###"
                      outline
                      required
                    />
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
                      name="extra" 
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
                      label="Ф.И.О. сотрудника музея"
                      name="staffName"
                      color="green lighten-3"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-text-field
                      v-model="staffPhone"
                      label="Телефон"
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
  name: 'ObjectMealEdit',
  props: {
    meal: {
      type: Object,
      required: true,
      default: null,
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
      type: [],
      about: '',
    }
  },
  computed: {
    ...mapGetters(['allCities']),
    details: function () {
      return JSON.stringify({
        mealType: this.type,
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
    this.city = parseInt(this.meal.city_id)
    const objectInfo = JSON.parse(this.meal.extra)
    this.about = objectInfo.about
    this.type = objectInfo.mealType
    this.site = objectInfo.contacts.site
    this.email = objectInfo.contacts.email
    this.phone = objectInfo.contacts.phone
    this.staffName = objectInfo.staff.name
    this.staffPhone = objectInfo.staff.phone
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