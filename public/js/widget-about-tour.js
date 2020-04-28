var tcAboutTour = {
    name: 'aboutTourComponent',
    props: {
        tourName: {
            type: String,
            default: 'Программа не пришла'
        },
        programm: {
            type: String,
            default: 'Программа не пришла'
        }
    },
    data: () => {
        return {
            dialog: false,
        }
    },
    template: `
    <v-row style="justify-content: center;">
      <v-dialog v-model="dialog" persistent max-width="900">
        <template v-slot:activator="{ on }">
          <a small dark text v-on="on" style="color: #aa282a; cursor: pointer;">Описание</v-btn>
        </template>
        <v-card>
          <v-toolbar dark color="#63a3ac">
            {{ tourName }}
            <v-spacer></v-spacer>
            <v-btn 
              color="green darken-1" 
              icon 
              @click="dialog = false"
            >
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
            </svg>
            </v-btn> 
          </v-toolbar>
          <v-card-title class="headline">
          </v-card-title>
          <v-card-text>
            <div v-html="programm"></div>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green darken-1" text @click="dialog = false">Закрыть</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>`,
}
