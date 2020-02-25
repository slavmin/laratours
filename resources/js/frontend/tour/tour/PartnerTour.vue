<template>
  <div>
    <v-row
      v-if="showAlert"
      class="alert"
    >
      <v-col cols="10">
        <v-alert
          border="left"
          dense
          type="success"
          dismissible
        >
          Тур успешно
          <strong>обновлён</strong>
        </v-alert>
      </v-col>
    </v-row>
    <v-container fluid>
      <v-row justify="center">
        <v-col cols="12">
          <v-card>
            <v-toolbar
              dark
              color="#94CED7"
            >
              <h1>
                Тур от партнёра
              </h1>
            </v-toolbar>
            <v-card-text>
              <v-form ref="form">
                <v-row>
                  <v-col
                    cols="12"
                    md="6"
                  >
                    <v-text-field
                      v-model="partnerName"
                      color="#aa282a"
                      label="Название партнёра"
                      @input="throttledSave"
                    />
                  </v-col>
                  <v-col
                    cols="12"
                    md="6"
                  >
                    <v-row>
                      <v-text-field
                        v-model.number="commission"
                        color="#aa282a"
                        label="Комиссия в рублях"
                        @input="throttledSave"
                      />
                      <v-tooltip left>
                        <template v-slot:activator="{ on }">
                          <v-icon
                            color="grey"
                            v-on="on"
                          >
                            info
                          </v-icon>
                        </template>
                        <span>
                          Сумма выплачивается с одного проданного места, вне
                          зависимости от
                          типа туриста
                        </span>
                      </v-tooltip>
                    </v-row>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
      <Prices :tour-id="parseInt(tourId)" />
      <Extra :tour-id="parseInt(tourId)" />
      <v-row justify="center">
        <v-btn
          color="#aa282a"
          dark
          @click="showEditor = !showEditor"
        >
          {{ showEditor ? 'Скрыть' : 'Программа тура' }}
          <v-icon right>
            expand_{{ showEditor ? 'less' : 'more' }}
          </v-icon>
        </v-btn>
        <v-col
          v-if="showEditor"
          cols="12"
        >
          <v-card>
            <v-toolbar
              dark
              color="#94CED7"
            >
              <h2>
                Программа тура
              </h2>
            </v-toolbar>
            <Editor
              id="editor"
              v-model="editor"
              :api-key="tiny.apiKey"
              :init="tiny.init"
              @input="throttledSave"
            />
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import axios from 'axios'
import Prices from './partner/Prices'
import Extra from './partner/Extra'
import Editor from '@tinymce/tinymce-vue'
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'PartnerTour',
  components: {
    Prices,
    Extra,
    Editor,
  },
  props: {
    token: {
      type: String,
      default: '',
    },
    tourId: {
      type: String,
      default: '',
    },
    tourCommission: {
      type: String,
      default: '',
    },
    tourExtra: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      partnerName: '',
      commission: null,
      showEditor: false,
      lastCall: '',
      lastCallTimer: null,
      showAlert: false,
      tiny: {
        apiKey: 'x7zbaypkm5jwplpkson0mxhq5w59oxtrrudgxphqx8llayfd',
        init: {
          min_width: '600',
          branding: false,
          language: 'ru',
          language_url: '/fonts/vendor/tinymce/ru.js',
          height: 500,
          plugins: 'table link print',
          default_link_target: '_blank',
        },
      },
      editor: '',
    }
  },
  computed: {
    ...mapGetters(['getEditMode', 'getPartnerTour']),
    extra: function() {
      return {
        partner_name: this.partnerName,
        editor: this.editor,
      }
    },
  },
  mounted() {
    this.fillFields()
  },
  methods: {
    save() {
      this.showAlert = true
      axios
        .post('/api/update-partner-tour-data', {
          tour_id: this.tourId,
          extra: this.extra,
          commission: this.commission,
        })
        .then(function(response) {
          console.log(response)
        })
      setTimeout(() => {
        this.showAlert = false
      }, 2500)
    },
    throttledSave: _.debounce(function() {
      this.save()
    }, 2000),
    fillFields() {
      this.commission = parseInt(this.tourCommission)
        ? parseInt(this.tourCommission)
        : 0
      if (this.tourExtra) {
        const data = this.tourExtra
        this.partnerName = data.partner_name
        this.editor = data.editor
      }
    },
  },
}
</script>

<style lang="scss" scoped>
.alert {
  position: fixed;
  z-index: 100;
  bottom: 12px;
  right: 12px;
}
</style>
