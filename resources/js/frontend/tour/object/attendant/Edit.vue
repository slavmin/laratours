<template>
  <v-dialog 
    v-model="dialog" 
    fullscreen 
    lazy
    hide-overlay 
    transition="dialog-bottom-transition"
  >
    <template v-slot:activator="{ on }">
      <v-btn 
        fab
        outline
        small
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
        color="#66a5ae"
      >
        <v-btn 
          icon 
          @click="dialog = false"
        >
          <v-icon>close</v-icon>
        </v-btn>
        <v-toolbar-title>
          Сопровождающий: {{ attendant.name }}. Редактирование.
        </v-toolbar-title>
        <v-spacer />
      </v-toolbar>
      <v-container>
        <v-layout 
          row 
          wrap
          justify-center
        >
          <v-flex xs6>
            <v-layout 
              row 
              wrap
            >
              <v-form
                ref="form"
                lazy-validation
                :action="'/operator/attendant/' + attendant.id"
                method="POST"
                class="form"
              >
                <v-layout 
                  row 
                  wrap
                >
                  <v-flex xs12>
                    <input 
                      type="hidden" 
                      name="_token" 
                      :value="token"
                    > 
                    <input 
                      type="hidden" 
                      name="_method" 
                      value="PATCH"
                    > 
                    <input  
                      v-model="attendant.price"
                      type="hidden" 
                      name="price"
                    > 
                    <div class="display-1 mb-3">
                      Общая информация:
                    </div>
                    <v-text-field
                      v-model="attendant.name"
                      label="ФИО сопровождающего"
                      name="name"
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <!-- <v-select
                      v-model="city"
                      :items="allCities"
                      label="Город"
                      item-text="name"
                      item-value="id"
                      outline
                      :rules="[v => !!v || 'Это обязательное поле']"
                      color="#aa282a"
                      multiple
                      required
                    /> -->
                    <v-autocomplete
                      v-model="city"
                      :items="allCities"
                      item-text="name"
                      item-value="id"
                      label="Город"
                      outline
                      multiple
                      chips
                      :rules="[v => !!v || 'Это обязательное поле']"
                      color="#aa282a"
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
                    <v-text-field
                      v-model="attendant.price"
                      label="Цена"
                      mask="#####"
                      name="about"
                      color="#aa282a"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      outline
                      required
                    />
                    <v-select
                      v-model="grade"
                      :items="grades"
                      color="#aa282a"
                      :menu-props="{ maxHeight: '400' }"
                      :rules="[v => !!v || 'Это обязательное поле']"
                      label="Класс обслуживания"
                      multiple
                      hint="Можно выбрать несколько"
                      persistent-hint
                    />
                    <v-select
                      v-model="languages"
                      :items="availableLanguages"
                      name="languages"
                      label="Язык:"
                      item-text="name"
                      item-value="id"
                      :rules="[v => v.length != 0 || 'Выберите язык']"
                      prepend-icon="language"
                      color="#aa282a"
                      multiple
                      required
                    />
                    <input 
                      v-model="details"
                      type="hidden" 
                      name="description" 
                    > 
                    <input 
                      v-model="details"
                      type="hidden" 
                      name="extra" 
                    > 
                    <div class="display-1 mb-3">
                      Контакты:
                    </div>
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
                    <v-text-field
                      v-model="secretPhone"
                      label="Служебный телефон"
                      name="phone"
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

  name: 'AttendantEdit',
  props: {
    token: {
      type: String,
      default: '',
    },
    attendant: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
  data() {
    return {
      dialog: false,
      name: '',
      city: '',
      about: '',
      grade: [],
      languages: [],
      email: '',
      phone: '+7-',
      secretPhone: '+7-',
      price: 0,
      grades: [
        'Стандарт',
        'VIP',
      ],
      availableLanguages: [
        { id: 1, name: 'Русский'},
        { id: 2, name: 'Английский'},
        { id: 3, name: 'Немецкий'},
        { id: 4, name: 'Французский'},
        { id: 5, name: 'Китайский'},
        { id: 6, name: 'Испанский'},
        { id: 7, name: 'Итальянский'},
        { id: 8, name: 'Финский'}
      ],
    };
  },
  computed: {
    ...mapGetters([
      'allCities',
    ]),
    details: function () {
      return JSON.stringify({
        city: this.city,
        guideType: this.type,
        about: this.about,
        grade: this.grade,
        languages: this.languages,
        contacts: {
          email: this.email,
          phone: this.phone,
          secretPhone: this.secretPhone,
        },
      }) 
    }
  },
  created() {
    this.fetchCities()
    this.fetchMeal()
  },
  mounted() {
    if (this.attendant.extra) {
      const data = JSON.parse(this.attendant.extra)
      this.city = data.city
      this.grade = data.grade
      this.about = data.about
      this.email = data.contacts.email
      this.phone = data.contacts.phone
      this.languages = data.languages
      this.secretPhone = data.contacts.secretPhone
    }
    console.log(this.city, this.allCities, JSON.parse(this.attendant.extra))
  },
  methods: {
    ...mapActions([
      'fetchCities',
      'fetchMeal'
    ]),
  }
};
</script>

<style lang="css" scoped>
.form {
  width: 100%;
}
</style>
