var tcDates = {
    name: 'tcDatesComponent',
    data: () => {
        return {
            showStartPicker: false,
            showEndPicker: false,
        }
    },
    template: `
    <v-container fluid>
      <v-row>
        <v-card>
          <v-card-header>
            <v-card-title>
              <h3 class="body-2 tc-widget__grey--text">Даты</h3>
              <v-spacer></v-spacer>
              <svg style="width:24px;height:24px;" viewBox="0 0 24 24">
                <path fill="#bbbaba" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z" />
              </svg>
            </v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12" sm="6">
                  <div data-app>
                    <v-menu
                      v-model="showStartPicker"
                      :close-on-content-click="false"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="$parent.startDate"
                          label="Начало"
                          color="#aa282a"
                          readonly
                          clearable
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-date-picker 
                        v-model="$parent.startDate" 
                        header-color="#aa282a" 
                        color="#aa282a" 
                        locale="ru"
                        scrollable
                        @input="showStartPicker = false"
                      >
                      </v-date-picker>
                    </v-menu>
                  </div>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-menu
                    v-model="showEndPicker"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template v-slot:activator="{ on }">
                      <v-text-field
                        v-model="$parent.endDate"
                        label="Конец"
                        color="#aa282a"
                        readonly
                        clearable
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker 
                      v-model="$parent.endDate" 
                      header-color="#aa282a" 
                      color="#aa282a" 
                      locale="ru"
                      scrollable
                      :min="$parent.startDate"
                      @input="showEndPicker = false"
                    >
                    </v-date-picker>
                  </v-menu>
                </v-col>
              </v-row>
              <v-btn 
                dark
                small
                text
                color="#aa282a" 
                @click="$parent.resetDates"
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
