<template>
  <v-row>
    <v-col cols="12">
      <h3 class="grey--text">
        Программа тура
      </h3>
      <Editor
        id="editor"
        v-model="editor"
        :api-key="tiny.apiKey"
        :init="tiny.init"
      />
      <v-row>
        <v-col xs12>
          <v-btn
            v-if="editor != ''"
            class="mt-2"
            small
            dark
            color="#aa282a"
            @click="clearEditor"
          >
            Очистить
          </v-btn>
          <v-btn
            v-if="editor == ''"
            class="mt-2"
            small
            dark
            color="#aa282a"
            @click="fetchData"
          >
            Заполнить
          </v-btn>
          <v-btn class="mt-2" small dark color="#aa282a" @click="saveProgram">
            Сохранить
          </v-btn>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>
<script>
import Editor from '@tinymce/tinymce-vue'
export default {
  name: 'TourProgram',
  components: { Editor },
  props: {
    tourId: {
      type: Number,
      default: 0,
    },
  },
  data() {
    return {
      tiny: {
        apiKey: 'x7zbaypkm5jwplpkson0mxhq5w59oxtrrudgxphqx8llayfd',
        init: {
          min_width: '600',
          branding: false,
          language: 'ru',
          language_url: '/fonts/vendor/tinymce/ru.js',
          height: 500,
          plugins: 'table link print image',
          default_link_target: '_blank',
        },
      },
      editor: '',
    }
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    fetchData() {
      axios
        .get('/api/get-detailed-tour-data-for-editor', {
          params: {
            tour_id: this.tourId,
          },
        })
        .then(r => this.parseData(r.data))
    },
    parseData(data) {
      console.log(data)
      let result = ''
      if (data.tour_objects.length > 0) {
        for (let i = 1; i <= data.tour_duration; i++) {
          result += `<h2>День ${i}</h2>`
          data.tour_objects.map(tour_object => {
            const objectDaysArray = JSON.parse(
              tour_object.properties.days_array
            )
            if (objectDaysArray.includes(i)) {
              result += `<h3>${tour_object.company.name}</h3>`
              if (tour_object.photo != '') {
                result += `<img src="${tour_object.photo}">`
              }
              result += `<h3>${
                tour_object.company.description
                  ? tour_object.company.description
                  : 'Описание компании не заполнено'
              }</h3>`
              result += `<p>${tour_object.object.name}`
              result += `<p>${
                tour_object.object.description
                  ? tour_object.object.description
                  : 'Описание объекта не заполнено'
              }</p>`
              result += '<hr>'
            }
          })
        }
      } else {
        result = 'Данные не получены'
      }
      this.editor = result
    },
    clearEditor() {
      this.editor = ''
    },
    saveProgram() {
      axios
        .post('/api/save-detailed-tour-program', {
          tour_id: this.tourId,
          program: this.editor,
        })
        .then(r => console.log(r))
    },
  },
}
</script>