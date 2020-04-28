var tcDialog = {
    name: 'dialogComponent',
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
