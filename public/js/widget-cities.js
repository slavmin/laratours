var tcCities = {
    name: 'tcCitiesComponent',
    template: `
  <v-container fluid>
    <v-row>
      <v-card>
        <v-card-header>
          <v-card-title>
            <h3 class="body-2 tc-widget__grey--text">Города</h3>
            <v-spacer></v-spacer>
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="#bbbaba" d="M15,23H13V21H15V23M19,21H17V23H19V21M15,17H13V19H15V17M7,21H5V23H7V21M7,17H5V19H7V17M19,17H17V19H19V17M15,13H13V15H15V13M19,13H17V15H19V13M21,9A2,2 0 0,1 23,11V23H21V11H11V23H9V15H3V23H1V15A2,2 0 0,1 3,13H9V11A2,2 0 0,1 11,9V7A2,2 0 0,1 13,5H15V1H17V5H19A2,2 0 0,1 21,7V9M19,9V7H13V9H19Z" />
            </svg>
          </v-card-title>
          <v-card-text>
            <v-row>
              <v-col cols="12">
                <v-autocomplete
                  v-model="$parent.cities"
                  item-text="name"
                  item-value="id"
                  :items="$parent.citiesList"
                  color="#aa282a"
                  item-color="#aa282a"
                  multiple
                  chips
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
              </v-col>
            </v-row>
            <v-btn 
              dark
              small
              text
              color="#aa282a" 
              @click="$parent.resetCities"
            >
              Сбросить
            </v-btn>
          </v-card-text>
        </v-card-header>
      </v-card>
    </v-row>
  </v-container>
    `,
}
