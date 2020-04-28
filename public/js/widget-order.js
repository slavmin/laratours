var tcOrder = {
    name: 'tcOrderComponent',
    props: {
        tourId: {
            type: String,
        },
        tourName: {
            type: String,
            default: 'Программа не пришла'
        },
        price: {
            type: String,
            default: ''
        }
    },
    data: () => {
        return {
            dialog: false,
            valid: false,
            loader: false,
            showSuccess: false,
            nameRules: [
                v => !!v || 'ФИО обязательны',
                v => (v && v.length <= 10) || 'ФИО должно содержать больше 10 символов',
            ],
            name: '',
            email: '',
            emailRules: [
                v => !!v || 'Введите email',
            ],
            phone: '',
            phoneRules: [
                v => !!v || 'Введите телефон',
            ],
            orderId: null,
        }
    },
    methods: {
        createOrder() {
            this.validate()
            if (this.valid) {
                this.loader = true
                axios.post('/api/widget/create-order', {
                        team_id: tcTeamId,
                        tour_id: this.tourId,
                        customer_name: this.name,
                        customer_email: this.email,
                        customer_phone_number: this.phone,
                        total_price: this.price
                    })
                    .then(r => {
                        this.orderId = r.data
                        this.showSuccess = true
                    })
                    .catch(e => console.log(e))
                    .finally(() => this.loader = false)
            }
        },
        validate() {
            if (this.$refs.form.validate()) {
                this.snackbar = true
            }
        },
        reset() {
            this.$refs.form.reset()
        },
        close() {
            this.reset()
            this.showSuccess = false
            this.orderId = null
            this.valid = false
            this.loader = false
            this.dialog = false
        }
    },
    template: `
    <v-row style="justify-content: center;">
      <v-dialog v-model="dialog" persistent max-width="900">
        <template v-slot:activator="{ on }">
          <v-btn
            small
            dark
            v-on="on"
            color="#aa282a"
          >
            Заказать
          </v-btn>
        </template>
        <v-card>
          <v-toolbar dark color="#63a3ac">
            {{ tourName }}
            <v-spacer></v-spacer>
            <v-btn 
              icon 
              @click="close"
            >
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="currentColor" d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
            </svg>
            </v-btn> 
          </v-toolbar>
          <v-card-title class="headline">
          </v-card-title>
          <v-card-text v-show="!showSuccess">
            <v-form 
              v-model="valid"
              ref="form"
            >
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="name"
                    :rules="nameRules"
                    label="ФИО"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    label="email"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="phone"
                    :rules="phoneRules"
                    label="Телефон"
                    required
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
            <v-row>
              <v-spacer></v-spacer>
                Цена: {{ price }}
            </v-row>
          </v-card-text>
          <v-card-text v-show="showSuccess">
            <v-row class="tc-widget__justify-center">
              <h2>
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                  <path fill="green" d="M19.78,2.2L24,6.42L8.44,22L0,13.55L4.22,9.33L8.44,13.55L19.78,2.2M19.78,5L8.44,16.36L4.22,12.19L2.81,13.55L8.44,19.17L21.19,6.42L19.78,5Z" />
                </svg>
                Успешно создан заказ №{{ orderId }}!
              </h2>
            </v-row>
          </v-card-text>
          <v-card-actions v-show="!showSuccess">
            <v-btn 
              color="#aa282a"
              text 
              @click="reset"
            >
              Очистить
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn
              small
              dark
              color="#aa282a"
              @click="createOrder"
            >
             Отправить
            </v-btn>
          </v-card-actions>
        </v-card>
        <v-overlay :value="loader">
          <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
      </v-dialog>
    </v-row>`,
}
