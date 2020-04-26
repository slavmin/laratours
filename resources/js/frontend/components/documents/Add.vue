<template>
  <v-container fluid grid-list-md text-xs-center>
    <v-row justify="center">
      <v-col>
        <h1 class="text-center white--text mb-5">
          <v-icon dark large>
            view_list
          </v-icon>
          Добавить
        </h1>
      </v-col>
    </v-row>
    <v-row justify="center">
      <v-col cols="12" md="8">
        <Form edit-mode :document="document" />
      </v-col>
      <v-col cols="12" md="3">
        <v-card>
          <v-card-text>
            <v-btn color="#aa282a" dark type="submit">
              Сохранить
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
              color="#aa282a"
              text
              small
              dark
              href="/operator/modules/document"
            >
              Закрыть
            </v-btn>
            <v-divider />
            <Labels />
            <v-divider />
            <Controls />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import Form from './Form'
import Labels from './Labels'
import Controls from './Controls'
export default {
  name: 'DocumentAdd',
  components: {
    Form,
    Labels,
    Controls,
  },
  props: {
    token: {
      type: String,
      default: '',
    },
    document: {
      type: Object,
      default: () => {
        return {}
      },
    },
  },
  data() {
    return {}
  },
}
</script>
