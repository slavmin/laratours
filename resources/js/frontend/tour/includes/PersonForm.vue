<template>
  <v-row>
    <v-col
      cols="12"
      md="6"
    >
      <v-text-field
        v-model="name"
        name="name"
        label="Имя"
        maxlength="191"
        color="#aa282a"
        outlined
        required
      />
      <v-text-field
        v-model="description"
        name="description"
        label="Описание"
        maxlength="191"
        color="#aa282a"
        outlined
      />
    </v-col>
    <v-col
      cols="12"
      md="6"
    >
      <v-autocomplete
        v-model="gradeList"
        name="grade_list[]"
        :items="countriesOptions"
        :rules="[v => !!v || 'Выберите класс']"
        label="Класс"
        color="#aa282a"
        outlined
        clearable
        disabled
      />
      <v-autocomplete
        v-model="langList"
        name="lang_list[]"
        :items="countriesOptions"
        :rules="[v => !!v || 'Выберите язык']"
        label="Язык"
        color="#aa282a"
        outlined
        clearable
        disabled
      />
    </v-col>
    <v-col
      cols="12"
      md="6"
    >
      <v-autocomplete
        v-model="countryId"
        name="country_id"
        :items="countriesOptions"
        :rules="[v => !!v || 'Выберите страну']"
        label="Страна"
        color="#aa282a"
        outlined
        clearable
        required
      />
      <v-autocomplete
        v-if="countryId"
        v-model="cityId"
        name="city_id"
        :items="citiesOptions"
        :rules="[v => !!v || 'Выберите город']"
        label="Город"
        color="#aa282a"
        outlined
        clearable
        required
      />
      <v-text-field
        v-if="countryId"
        v-model="address"
        name="address"
        label="Адрес"
        color="#aa282a"
        outlined
      />
    </v-col>
    <v-col
      cols="12"
      md="6"
    >
      <v-text-field
        v-model="email"
        name="email"
        label="email"
        color="#aa282a"
        outlined
      />
      <v-text-field
        v-model="phone"
        type="tel"
        pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}"
        name="phone"
        label="Телефон"
        placeholder="(555) 555-5555"
        autocomplete="tel"
        maxlength="14"
        color="#aa282a"
        outlined
      />
      <v-text-field
        v-model="secretPhone"
        type="tel"
        pattern="[(][0-9]{3}[)] [0-9]{3}-[0-9]{4}"
        name="secret_phone"
        label="Секретный телефон"
        placeholder="(555) 555-5555"
        autocomplete="tel"
        maxlength="14"
        color="#aa282a"
        outlined
      />
    </v-col>
    <v-overlay
      :value="loader"
      style="z-index: 10000;"
    >
      <v-progress-circular
        indeterminate
        size="64"
      />
    </v-overlay>
  </v-row>
</template>
<script>
export default {
  name: 'PersonForm',
  props: {
    item: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      loader: false,
      name: null,
      description: null,
      address: null,
      countriesCitiesOptions: [],
      countryId: null,
      cityId: null,
      email: null,
      phone: null,
      secretPhone: null,
      gradeList: null,
      langList: null,
    }
  },
  computed: {
    countriesOptions: function() {
      let result = []
      for (const key in this.countriesCitiesOptions) {
        result.push({
          value: parseInt(key),
          text: this.countriesCitiesOptions[key].name,
        })
      }
      return result
    },
    citiesOptions: function() {
      let result = []
      const cities = this.countriesCitiesOptions[this.countryId].cities
      for (const key in cities) {
        result.push({
          value: parseInt(key),
          text: cities[key],
        })
      }
      return result
    },
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      this.loader = true
      axios
        .get('/api/tour-countries-with-cities')
        .then(r => {
          this.countriesCitiesOptions = r.data
          this.parseData()
        })
        .finally(() => (this.loader = false))
    },
    parseData() {
      if (this.item !== null) {
        this.name = this.item.name
        this.description = this.item.description
        this.address = this.item.address
        this.countryId = this.item.country_id
        this.cityId = this.item.city_id
        this.email = this.item.email
        this.phone = this.item.phone
        this.secretPhone = this.item.secret_phone
      }
    },
  },
}
</script>