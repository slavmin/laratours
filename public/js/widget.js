(function () {
    // var root = 'https://id154.tour-click.ru'
    var root = '//tourclick6.local'

    var vue = document.createElement('script')
    vue.src = 'https://cdn.jsdelivr.net/npm/vue'
    document.head.appendChild(vue)

    var axiosLib = document.createElement('script')
    axiosLib.src = 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js'
    axiosLib.inegrity = 'sha256-T/f7Sju1ZfNNfBh7skWn0idlCBcI3RwdLSS4/I7NQKQ='
    axiosLib.crossOrigin = 'anonymous'
    document.head.appendChild(axiosLib)

    var vuetifyCSS = document.createElement('link')
    vuetifyCSS.href = 'https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css'
    vuetifyCSS.rel = "stylesheet"
    document.head.appendChild(vuetifyCSS)

    var vuetifyJS = document.createElement('script')
    vuetifyJS.src = 'https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js'
    document.head.appendChild(vuetifyJS)

    var mdIconsCSS = document.createElement('link')
    mdIconsCSS.href = 'https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css'
    mdIconsCSS.rel = "stylesheet"
    document.head.appendChild(mdIconsCSS)

    var tcDatesModule = document.createElement('script')
    tcDatesModule.src = `${root}/js/widget-dates.js`
    document.head.appendChild(tcDatesModule)

    var tcCitiesModule = document.createElement('script')
    tcCitiesModule.src = `${root}/js/widget-cities.js`
    document.head.appendChild(tcCitiesModule)

    var tcOrderModule = document.createElement('script')
    tcOrderModule.src = `${root}/js/widget-order.js`
    document.head.appendChild(tcOrderModule)

    var tcAboutTourModule = document.createElement('script')
    tcAboutTourModule.src = `${root}/js/widget-about-tour.js`
    document.head.appendChild(tcAboutTourModule)


    var tcWidgetStyles = document.createElement('style')
    tcWidgetStyles.innerHTML = `<style type="text/css">
    
        html,
        body,
        body * {
            margin: 0;
            padding: 0;
        }

        .tc-widget
        {
            background-color: #63a3ac;
            box-sizing: border-box;
            font-family: Roboto, sans-serif;
            border: solid 1px grey;
            padding: 20px;
            color: black;
        }

        .tc-widget__justify-center {
          justify-content: center;
        }

        .tc-widget__header {
            color: white;
            font-size: 1.5rem;
            text-align: center;
            margin-bottom: 24px;
        }

        .tc-widget__card {
            width: 100%;
            background-color: #fff;
            margin-bottom: 24px;
        }

        .tc-widget__grey--text {
          color: #bbbaba;
        }

        .tc-widget__card  {
          background-color: #fff;
        }

        .tc-widget__card-header {
            color: #bbbaba;
            font-size: 1rem;
            margin: 0;
            padding: 18px;
            padding-bottom: 24px;
        }

        .tc-widget__card-text {
          padding: 12px;
          padding-bottom: 36px;
        }

        .tc-widget__card-text input {
          padding: 12px;
          font-size: 1.2rem;
          max-width: 160px;
          margin-bottom: 16px;
        }

        .tc-widget__table {
            width: 100%;
        }

        .tc-widget__table th {
            color: #bbbaba;
            font-size: 1rem;
            margin: 0;
            padding: 18px;
            padding-bottom: 24px;
            background-color: #fff;
            border-bottom: 2px solid #bbbaba;
        }

        .tc-widget__table td {
            padding: 18px;
            font-size: .8rem;
            text-align: center;
        }

        .tc-widget__cities-list {
          list-style: none !important;
        }

        .tc-widget__btn {
          background-color: #aa282a;
          color: white !important;
          padding: 12px 24px;
          display: inline-block;
        }
        .tc-widget__btn:hover {
          color: yellow !important;
        }

        .tc-widget__btn-text {
          background-color: transparent;
          color: #aa282a !important;
        }

        .tc-widget__btn-text:hover {
          color: #63a3ac !important;
        }
    </style>`
    document.head.appendChild(tcWidgetStyles)

    window.onload = () => {
        var widget = `<div class="tc-widget" id="app" data-app>
                          <div class="tc-widget__header">
                              Модуль от ТурКлика
                          </div>
                              <v-row class="tc-widget__justify-center">
                                <img v-show="showLoader" class="tc-widget__loader" src="${root}/widget-loader.svg">
                              </v-row>
                              <div v-show="!showLoader">
                                <v-row>
                                  <v-col cols="12" md="6">
                                    <tc-dates></tc-dates>
                                  </v-col>
                                  <v-col cols="12" md="6">
                                    <tc-cities></tc-cities>
                                  </v-col>
                                </v-row>
                                <v-row>
                                  <v-spacer></v-spacer>
                                  <v-btn 
                                    dark
                                    color="#aa282a" 
                                    @click="fetchTours"
                                  >
                                    Искать
                                  </v-btn>
                                  <v-spacer></v-spacer>
                                </v-row>
                                <v-row>
                                  <v-spacer></v-spacer>
                                  <v-btn 
                                    dark
                                    text
                                    color="#aa282a" 
                                    @click="resetAll"
                                  >
                                    Очистить всё
                                  </v-btn>
                                  <v-spacer></v-spacer>
                                </v-row>
                                <br>
                                <v-row>
                                  <v-col cols="12">
                                    <v-card>
                                      <table class="tc-widget__table">
                                        <thead>
                                            <th>Название</th>
                                            <th>Города</th>
                                            <th>Дата заезда</th>
                                            <th>Кол-во ночей</th>
                                            <th>Цена</th>
                                            <th>Статус</th>
                                        </thead>
                                        <tbody>
                                          <tr v-for="tour in tours" :key="tour.id">
                                              <td>
                                                {{ tour.name }}
                                                <tc-about-tour 
                                                  :tour-name="tour.name"
                                                  :programm="tour.description"
                                                >
                                                </tc-about-tour>
                                              </td>
                                              <td>
                                                <ul class="tc-widget__cities-list">
                                                  <li v-for="city in tour.cities_list">
                                                    {{ city }}
                                                  </li>
                                                </ul>
                                              </td>
                                              <td>{{ tour.date }}</td>
                                              <td>{{ tour.duration }}</td>
                                              <td>{{ tour.widgetPrice }}</td>
                                              <td v-if="tour.widgetPrice != 'уточняйте'">
                                                <tc-order 
                                                  :tour-id="tour.id"
                                                  :tour-name="tour.name"
                                                  :price="tour.widgetPrice"
                                                ></tc-order>
                                              </td>
                                              <td v-if="tour.widgetPrice == 'уточняйте'">под запрос</td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </v-card>
                                  </v-col>
                                </v-row>
                              </div>
                          </div>
                      </div>`

        var wrapper = document.getElementById('tc-widget')
        wrapper.innerHTML = widget

        var app = new Vue({
            el: "#tc-widget",
            vuetify: new Vuetify(),
            data: {
                message: 'Hi!',
                tours: [],
                showLoader: true,
                startDate: '',
                endDate: '',
                citiesList: [],
                cities: [],
            },
            mounted() {
                this.fetchTours()
            },
            methods: {
                fetchTours() {
                    this.showLoader = true
                    axios.get(`${root}/api/widget/get-tours`, {
                            params: {
                                team_id: tcTeamId,
                                date_start: this.startDate,
                                date_end: this.endDate,
                                cities_list: this.cities,
                            }
                        })
                        .then(r => {
                            this.tours = r.data.tours
                            this.citiesList = r.data.cities_options.filter((city) => {
                                return !this.citiesList.includes(city)
                            })
                            console.log(r)
                        })
                        .then(() => this.parseExtra())
                        .catch(e => console.log(e))
                        .finally(() => this.showLoader = false)
                },
                parseExtra() {
                    this.tours.forEach((tour) => {
                        tour.extra = JSON.parse(tour.extra)
                        const price = tour.extra.calc.priceList.find(p => {
                            return p.name = "Взрослый"
                        })
                        tour.widgetPrice = price ? price.commissionStandardPrice : 'уточняйте'
                        tour.extra.editorsContent.forEach((htmlString) => {
                            tour.description += htmlString
                        })
                    })
                },
                formatDate(date, delimiter) {
                    const d = new Date(date)

                    let dd = d.getDate()
                    if (dd < 10) dd = '0' + dd

                    let mm = d.getMonth() + 1
                    if (mm < 10) mm = '0' + mm

                    let yy = d.getFullYear()

                    return dd + '/' + mm + '/' + yy
                },
                resetAll() {
                    this.startDate = null
                    this.endDate = null
                    this.cities = []
                    this.fetchTours()
                },
                resetDates() {
                    this.startDate = null
                    this.endDate = null
                    this.fetchTours()
                },
                resetCities() {
                    this.cities = []
                    this.fetchTours()
                },
                removeCity(id) {
                    this.cities = this.cities.filter(cityId => cityId != id)
                },
            },
        })

        wrapper.setAttribute('data-app', true)

        Vue.component('tc-dates', tcDates)
        Vue.component('tc-cities', tcCities)
        Vue.component('tc-order', tcOrder)
        Vue.component('tc-about-tour', tcAboutTour)
    }
})()
