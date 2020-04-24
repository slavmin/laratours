<template>
  <v-container grid-list-xs>
    <form :action="url" method="GET">
      <v-layout wrap justify-space-between align-center>
        <v-flex col12 lg3>
          <v-text-field
            v-model="name"
            name="name"
            label="Название"
            dark
            clearable
          />
        </v-flex>
        <v-flex col12 lg3>
          <v-autocomplete
            v-model="city_id"
            name="city_id"
            item-text="name"
            item-value="id"
            :items="allCities"
            label="Город:"
            dark
            persistent-hint
            clearable
          />
        </v-flex>
        <v-flex col12 lg3>
          <v-layout wrap justify-space-around>
            <v-btn dark small color="red" @click="clear">
              Сбросить
            </v-btn>
            <v-btn type="submit" dark small color="green">
              <v-icon>search</v-icon>
            </v-btn>
          </v-layout>
        </v-flex>
      </v-layout>
    </form>
  </v-container>
</template>
<script>
export default {
  name: 'FilterForObjects',
  props: {
    modelAlias: {
      type: String,
      default: '',
    },
    nameParam: {
      type: String,
      default: '',
    },
    cityParam: {
      type: String,
      default: '',
    },
    cities: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      city_id: null,
      name: null,
    }
  },
  computed: {
    url: function() {
      const result = `/operator/${this.modelAlias}`
      return result
    },
    allCities() {
      const citiesObject = JSON.parse(this.cities)
      let result = []
      for (const key in citiesObject) {
        result.push({
          id: key,
          name: citiesObject[key],
        })
      }
      return result
    },
  },
  mounted() {
    this.name = this.nameParam
    this.city_id = this.cityParam
  },
  methods: {
    clear() {
      this.city_id = null
      this.name = null
      location.replace(this.url)
    },
  },
}
</script>