<template>
  <div>
    <v-autocomplete
      v-model="selectedCity"
      :items="citiesArray"
      :label="label"
      outlined
      clearable
    />
    <input
      v-model="selectedCity"
      name="city_id"
      type="hidden"
    >
  </div>
</template>
<script>
export default {
  name: 'CitiesAutocomplete',
  props: {
    label: {
      type: String,
      default: '',
    },
    cityId: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      selectedCity: '',
      citiesArray: [],
    }
  },
  mounted() {
    this.fetchCities()
    this.selectedCity = parseInt(this.cityId)
  },
  methods: {
    fetchCities(ctx) {
      axios
        .get('/api/tour-options')
        .then(response => {
          const countries = response.data[0].countries_cities_options
          let country = []
          for (let key in countries) {
            if (countries[key].name == 'Россия') {
              country = countries[key]
            }
          }
          let cities = []
          for (let key in country.cities) {
            cities.push({
              value: parseInt(key),
              text: country.cities[key],
            })
          }
          this.citiesArray = cities
        })
        .catch(e => console.log(e))
    },
  },
}
</script>