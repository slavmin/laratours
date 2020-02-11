<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Программа маршрута</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <v-form
        ref="form6"
        class="text-center"
      >
        <div class="h5 grey-text pt-2">
          Начало маршрута
        </div>
        <!-- Address start -->
        <!-- <div class="md-form">
          <input
            id="form6-address_start"
            v-model="info.address_start"
            type="text"
            class="form-control"
          >
          <label for="address_start">Адрес места начала перевозки</label>
        </div> -->
        <!-- Start lat -->
        <!-- <div class="md-form">
          <input
            type="text"
            name="start_coords[lat]"
            class="form-control"
            value="59.879456882294406"
          >
          <label for="drivers[0][licence]">
            Широта
          </label>
        </div> -->
        <!-- Start lng -->
        <!-- <div class="md-form">
          <input
            type="text"
            name="start_coords[lng]"
            class="form-control"
            value="30.3875184984233"
          >
          <label for="drivers[0][licence]">
            Долгота
          </label>
        </div> -->
        <!-- Region -->
        <div class="md-form">
          <v-select
            v-model="info.region_code"
            :items="availableRegions"
            label="Регион начала маршрута"
            :rules="rules.notEmpty"
          />
        </div>
        <!-- Start district -->
        <div class="md-form">
          <v-select
            v-model="info.district"
            :items="spbDistricts"
            label="Район или городской округ начала
            маршрута"
            :rules="rules.notEmpty"
          />
        </div>
        <!-- <div class="h5 grey-text pt-2">
          Адреса промежуточных остановочных пунктов и места окончания
          перевозки (координаты)
        </div> -->
        <!-- Start point lat -->
        <!-- <div class="md-form">
          <input
            type="text"
            name="stop_points[0][lat]"
            class="form-control"
            value="60.05244395768214"
          >
          <label for="drivers[0][licence]">
            Широта
          </label>
        </div> -->
        <!-- Stop point lat -->
        <!-- <div class="md-form">
          <input
            type="text"
            name="stop_points[0][lng]"
            class="form-control"
            value="30.380161110304684"
          >
          <label for="drivers[0][licence]">
            Долгота
          </label>
        </div> -->
        <!-- Stop time -->
        <!-- <div class="md-form">
          <input
            id="stop_points[0][time]"
            name="stop_points[0][time]"
            type="text"
            class="form-control"
            value="00:30"
          >
          <label for="stop_points[0][time]">
            Планируемое время стоянки
            (ЧЧ:ММ)
          </label>
        </div> -->
        <!-- Stop goal -->
        <!-- <div class="md-form">
          <input
            id="stop_points[0][goal]"
            name="stop_points[0][goal]"
            type="text"
            class="form-control"
            value="ОПОПУДАЧА2"
          >
          <label for="stop_points[0][goal]">
            Цель стоянки
          </label>
        </div> -->
        <div class="h5 grey-text pt-2">
          О маршруте
        </div>
        <!-- Distance -->
        <div class="md-form">
          <v-text-field
            v-model="info.distance"
            type="text"
            label="Расстояние перевозки в километрах"
            :rules="rules.notEmpty"
          />
        </div>
        <!-- Schedule -->
        <div class="md-form">
          <v-text-field
            v-model="info.schedule"
            type="text"
            label="График движения"
            :rules="rules.notEmpty"
          />
        </div>
        <!-- Duration -->
        <div class="md-form">
          <v-text-field
            v-model="info.duration"
            type="text"
            label="Расчётное время в пути (ЧЧ:ММ)"
            :rules="rules.notEmpty"
          />
        </div>
      </v-form>
      <!-- Form -->
    </div>
  </div>
  <!-- Material form login -->
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Form6',
  data() {
    return {
      step: 0,
      spbDistricts: [
        'Адмиралтейский',
        'Василеостровский',
        'Выборгский',
        'Калининский',
        'Кировский',
        'Колпинский',
        'Красногвардейский',
        'Красносельский',
        'Кронштадтский',
        'Курортный',
        'Московский',
        'Невский',
        'Область',
        'Петроградский',
        'Петродворцовый',
        'Приморский',
        'Пушкинский',
        'Фрунзенский',
        'Центральный',
      ],
    }
  },
  computed: {
    ...mapGetters({
      info: 'getForm6',
      form1: 'getForm1',
      availableRegions: 'getAvailableRegions',
      rules: 'getValidationRules',
    }),
  },
  mounted() {
    this.validate()
  },
  methods: {
    send() {
      let newWin = window.open('', `form1${this.step}`)
      newWin.document.write(this.forms[this.step].form)
      let form = newWin.document.getElementsByTagName('form')[0]
      form.submit()
      setTimeout(() => {
        if (this.step != 5) {
          newWin.close()
          this.step++
          this.send()
        }
      }, 2000)
      // this.forms.forEach(item => {
      //   console.log(item)
      //   let newWin = window.open('', `form${item.id}`)
      //   newWin.document.write(item.form)
      //   let form = newWin.document.getElementsByTagName('form')[0]
      //   form.submit()
      //   setTimeout(() => {
      //     if (item.id != 6) newWin.close()
      //     if (item.id == 6) newWin.location.reload(true)
      //   }, 2000)
      // })
    },
    delay(ms) {
      return new Promise(resolve => setTimeout(resolve, ms))
    },
    validate() {
      if (this.$refs.form6.validate()) {
        this.snackbar = true
      }
    },
  },
}
</script>