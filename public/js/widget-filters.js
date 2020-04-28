var tcFilters = {
    name: 'tcFiltersComponent',
    data: () => {
        return {
            showDatesPicker: false,
            showCitiesAutoselect: false,
        }
    },
    computed: {
        today: function () {
            const d = new Date()

            let dd = d.getDate()
            if (dd < 10) dd = '0' + dd

            let mm = d.getMonth() + 1
            if (mm < 10) mm = '0' + mm

            let yy = d.getFullYear()

            return `${yy}-${mm}-${dd}`
        },
        selectedCitiesNames: function () {
            if (this.$parent.cities.length > 0) {
                let result = ''
                for (const city in this.$parent.cities) {
                    result += this.getCityName(this.$parent.cities[city])
                }
                return result
            }
        }
    },
    methods: {
        getCityName(cityId) {
            let result = this.$parent.citiesList.find(c => c.id == cityId)
            console.log(result)
            return result ? `${result.name}, ` : ''
        }
    },
    template: `
    <v-row class="tc-widget__filters-card">
      <v-col cols="12" md="5">
        <v-row>
          <h3 class="body-2 tc-widget__grey--text">Даты</h3>
          <v-spacer></v-spacer>
          <svg style="width:24px;height:24px;" viewBox="0 0 24 24">
            <path fill="#bbbaba" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z" />
          </svg>
        </v-row>
        <v-row>
            <v-dialog max-width="290" v-model="showDatesPicker">
              <v-date-picker 
                v-model="$parent.dates" 
                first-day-of-week="1"
                :min="today"
                header-color="#aa282a" 
                color="#aa282a" 
                locale="ru"
                selected-items-text="Выбрано"
                scrollable
                range
              >
              </v-date-picker>
            </v-dialog>
            <v-text-field
              v-model="$parent.dates"
              label="Период"
              color="#aa282a"
              readonly
              @click="showDatesPicker = true"
            ></v-text-field>
        </v-row>
      </v-col>
      <v-col cols="12" md="5">
        <v-row>
          <h3 class="body-2 tc-widget__grey--text">Города</h3>
          <v-spacer></v-spacer>
          <svg style="width:24px;height:24px" viewBox="0 0 24 24">
            <path fill="#bbbaba" d="M15,23H13V21H15V23M19,21H17V23H19V21M15,17H13V19H15V17M7,21H5V23H7V21M7,17H5V19H7V17M19,17H17V19H19V17M15,13H13V15H15V13M19,13H17V15H19V13M21,9A2,2 0 0,1 23,11V23H21V11H11V23H9V15H3V23H1V15A2,2 0 0,1 3,13H9V11A2,2 0 0,1 11,9V7A2,2 0 0,1 13,5H15V1H17V5H19A2,2 0 0,1 21,7V9M19,9V7H13V9H19Z" />
          </svg>
        </v-row>
        <v-dialog max-width="400" v-model="showCitiesAutoselect">
          <v-card dense>
            <v-autocomplete
              v-model="$parent.cities"
              item-text="name"
              item-value="id"
              :items="$parent.citiesList"
              color="#aa282a"
              item-color="#aa282a"
              multiple
              chips
              style="width: 300px;margin: 0 auto;"
            >
              <template v-slot:selection="data">
                <v-chip
                  v-bind="data.attrs"
                  :input-value="data.selected"
                  close
                  @click="data.select"
                  @click:close="$parent.removeCity(data.item.id)"
                >
                  {{ data.item.name }}
                </v-chip>
              </template>
            </v-autocomplete>
          </v-card>
        </v-dialog>
        <v-text-field
          v-model="selectedCitiesNames"
          color="#aa282a"
          readonly
          @click="showCitiesAutoselect = true"
        ></v-text-field>
      </v-col>
    </v-row>
      `,
}
