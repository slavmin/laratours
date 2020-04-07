<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Отправка запросов</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <div class="row h5 mt-4 grey-text">
        <p>
          После нажатия кнопки "Отправить", система "ТурКлик" начнёт
          автоматически отправлять сведения на сайт гибдд.рф.
        </p>
        <p>
          Во время отправки будет открываться новая вкладка и закрываться спустя
          какое-то время.
        </p>
        <p>
          На всё время отправки информации на сайт гибдд.рф нужно оставить в
          покое ваш компьютер.
        </p>
        <p>
          При правильном заполнении и использовании нашего сервиса, последней
          незакрытой вкладкой останется сайт гибдд.рф с суммарной информацией
          всего уведомления о перевозке группы детей. Где можно проверить всю
          внесённую информацию, отредактировать при необходимости, и создать
          уведомление.
        </p>
      </div>
      <!-- <div class="row">
        <v-select
          v-model="delay"
          :items="delaysArray"
          label="Ожидание ответа"
        />
      </div>
      <div class="row">
        <p class="grey-text">
          При возникновении проблем с работой сервиса из-за медленного интернет
          соединения попробуйте увеличить это значение.
        </p>
      </div> -->
      <div class="row justify-content-end">
        <v-btn
          v-if="step != 0"
          color="red"
          flat
          dark
          @click="step = 0"
        >
          Сброс
        </v-btn>
        <v-btn
          color="green"
          dark
          :disabled="step != 0"
          @click="send"
        >
          Отправить
        </v-btn>
      </div>
    </div>
  </div>
  <!-- Material form login -->
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Form4',
  data() {
    return {
      step: 0,
      delaysArray: [
        { value: 2000, text: '2 сек.' },
        { value: 3000, text: '3 сек.' },
        { value: 5000, text: '5 сек.' },
      ],
      delay: 2000,
    }
  },
  computed: {
    ...mapGetters([
      'getForm1',
      'getForm2',
      'getForm3',
      'getForm4',
      'getForm5',
      'getForm6',
    ]),
    form1: function() {
      let regionCodeInputs = ''
      if (this.getForm1.selectedRegionCodes.length > 0) {
        this.getForm1.selectedRegionCodes.forEach(regionCode => {
          console.log(regionCode)
          regionCodeInputs += `<input
            name="region_code[]"
            type="text"
            value="${regionCode}"
          >`
        })
      }
      let result = `<form
                      id="form1"
                      class="text-center"
                      style="color: #757575;"
                      action="https://гибдд.рф/transportation/applicant/"
                      method="POST"
                    >
                      <!-- Name -->
                      <div>
                        <input
                          name="name"
                          type="text"
                          value="${this.getForm1.name}"
                        >
                      </div>
                      <!-- Position -->
                      <div>
                        <input
                          name="position"
                          type="text"
                          value="${this.getForm1.position}"
                        >
                      </div>
                      <!-- Phone number -->
                      <div>
                        <input
                          name="phone"
                          type="text"
                          value="${this.getForm1.phone}"
                        >
                      </div>
                      <!-- email -->
                      <div>
                        <input
                          name="email"
                          type="email"
                          value="${this.getForm1.email}"
                        >
                      </div>
                      <!-- Region -->
                      <div>
                        ${regionCodeInputs}
                      </div>
                      <!-- Count -->
                      <div>
                        <input
                          name="count"
                          type="text"
                          value="${this.getForm1.count}"
                        >
                      </div>
                      <!-- Goal -->
                      <div>
                        <input
                          name="goal"
                          type="text"
                          value="${this.getForm1.goal}"
                        >
                      </div>
                      <!-- Date start -->
                      <div>
                        <input
                          name="date_start"
                          type="text"
                          value="${this.getForm1.dateStart} ${this.getForm1.timeStart}"
                        >
                      </div>
                      <!-- Date end -->
                      <div>
                        <input
                          name="date_end"
                          type="text"
                          value="${this.getForm1.dateEnd} ${this.getForm1.timeEnd}"
                        >
                      </div>
                      <button type="submit">
                        Отправить
                      </button>
                    </form>`
      return result
    },
    form2: function() {
      let nameAndAddressInputs = ''
      if (this.getForm2.type == 2) {
        nameAndAddressInputs = `
          <input
            name="entity_name"
            type="text"
            value="${this.getForm2.entity_name}"
          >
          <input
            name="entity_address"
            type="text"
            value="${this.getForm2.entity_address}"
          >
          <input
            name="entity_location"
            type="text"
            value="${this.getForm2.entity_location}"
          >`
      }
      if (this.getForm2.type == 3) {
        nameAndAddressInputs = `
          <input
            name="name"
            type="text"
            value="${this.getForm2.name}"
          >
          <input
            name="address"
            type="text"
            value="${this.getForm2.address}"
          >`
      }

      let result = `<form
                      action="https://гибдд.рф/transportation/customers/"
                      method="POST"
                    >
                      <!-- Type -->
                      <div>
                        <input
                          name="type"
                          type="text"
                          value="${this.getForm2.type}"
                        >
                      </div>
                      <!-- Name and address -->
                      <div>
                        ${nameAndAddressInputs}
                      </div>
                      <!-- Phone number -->
                      <div>
                        <input
                          name="phone"
                          type="text"
                          value="${this.getForm2.phone}"
                        >
                      </div>
                      <!-- email -->
                      <div">
                        <input
                          name="email"
                          type="email"
                          value="${this.getForm2.email}"
                        >
                      </div>
                      <!-- INN -->
                      <div>
                        <input
                          name="inn"
                          type="text"
                          value="${this.getForm2.inn}"
                        >
                      </div>
                      <!-- Sign in button -->
                      <button
                        class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                        type="submit"
                      >
                        Отправить
                      </button>
                    </form>`
      return result
    },
    form3: function() {
      let nameAndAddressInputs = ''
      if (this.getForm3.type == 2) {
        nameAndAddressInputs = `
          <input
            name="entity_name"
            type="text"
            value="${this.getForm3.entity_name}"
          >
          <input
            name="entity_address"
            type="text"
            value="${this.getForm3.entity_address}"
          >
          <input
            name="entity_location"
            type="text"
            value="${this.getForm3.entity_location}"
          >`
      }
      if (this.getForm3.type == 3) {
        nameAndAddressInputs = `
          <input
            name="name"
            type="text"
            value="${this.getForm3.name}"
          >
          <input
            name="address"
            type="text"
            value="${this.getForm3.address}"
          >`
      }
      let result = `<form
                      action="https://гибдд.рф/transportation/carriers/"
                      method="POST"
                    >
                      <!-- Type -->
                      <div>
                        <input
                          name="type"
                          type="text"
                          value="${this.getForm3.type}"
                        >
                      </div>
                      <!-- Name and address -->
                      <div>
                        ${nameAndAddressInputs}
                      </div>
                      <!-- Phone number -->
                      <div>
                        <input
                          name="phone"
                          type="text"
                          value="${this.getForm3.phone}"
                        >
                      </div>
                      <!-- email -->
                      <div">
                        <input
                          name="email"
                          type="email"
                          value="${this.getForm3.email}"
                        >
                      </div>
                      <!-- INN -->
                      <div>
                        <input
                          name="inn"
                          type="text"
                          value="${this.getForm3.inn}"
                        >
                      </div>
                      <!-- Sign in button -->
                      <button
                        class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
                        type="submit"
                      >
                        Отправить
                      </button>
                    </form>`
      return result
    },
    form4: function() {
      let result = ''
      result += `
        <form
          action="https://гибдд.рф/transportation/vehicles/"
          method="POST"
        >`
      this.getForm4.vehicles.forEach((vehicle, i) => {
        result += `<!-- Bus model -->
          <div>
            <input
              name="vehicles[${i}][brand_and_model]"
              type="text"
              value="${vehicle.brand_and_model}"
            >
          </div>
          <!-- Bus regnumber -->
          <div class="md-form">
            <input
              name="vehicles[${i}][number]"
              type="text"
              value="${vehicle.number}"
            >
          </div>
          <!-- Bus regnumber -->
          <div>
            <input
              name="vehicles[${i}][diagnostic_card_info]"
              type="text"
              value="${vehicle.diagnostic_card_info}"
            >
          </div>
          <div>
            <input
              type="checkbox"
              name="vehicles[${i}][navigator_info]"
              checked
              value="${vehicle.navigator_info}"
            >
          </div>`
      })
      result += `<!-- Sign in button -->
          <button type="submit">
            Отправить
          </button>
        </form>`
      return result
    },
    form5: function() {
      let result = `<form
          action="https://гибдд.рф/transportation/drivers/"
          method="POST"
        >`
      this.getForm5.drivers.forEach((driver, i) => {
        result += `<!-- Driver name -->
            <div>
              <input
                name="drivers[${i}][name]"
                type="text"
                value="${driver.name}"
              >
            </div>
            <!-- Driver license number -->
            <div>
              <input
                name="drivers[${i}][licence]"
                type="text"
                value="${driver.licence}"
              >
            </div>
            <!-- Driver license date -->
            <div>
              <input
                name="drivers[${i}][licence_date]"
                type="text"
                value="${driver.licence_date}"
              >
            </div>
            <!-- Driver license date -->
            <div>
              <input
                name="drivers[${i}][experience]"
                type="text"
                value="${driver.experience}"
              >
            </div>`
      })
      result += `<!-- Sign in button -->
          <button type="submit">
            Отправить
          </button>
        </form>`
      return result
    },
    form6: function() {
      let stopPointsInputs = ''
      this.getForm6.stopPoints.forEach((stopPoint, i) => {
        stopPointsInputs += `<!-- Start point address -->
          <div class="md-form">
            <input
              type="text"
              name="stop_points[${i}][address]"
              value="${stopPoint.address}"
            >
          </div>
          <!-- Stop time -->
          <div>
            <input
              name="stop_points[${i}][time]"
              type="text"
              value="${stopPoint.time}"
            >
          </div>
          <!-- Stop goal -->
          <div>
            <input
              name="stop_points[${i}][goal]"
              type="text"
              value="${stopPoint.goal}"
            >
          </div>`
      })
      let result = `<form
          action="https://гибдд.рф/transportation/route/"
          method="POST"
        >
          <!-- Address start -->
          <div>
            <input
              name="address_start"
              type="text"
              value="${this.getForm6.address_start}"
            >
          </div>
          <!-- Region -->
          <div>
            <input
              name="region_code"
              type="text"
              value="${parseInt(this.getForm6.region_code)}"
            >
          </div>
          <!-- Start district -->
          <div>
            <input
              name="district"
              type="text"
              value="${this.getForm6.district}"
            >
          </div>`
      result += stopPointsInputs
      result += `<!-- Distance -->
          <div>
            <input
              name="distance"
              type="text"
              value="${this.getForm6.distance}"
            >
          </div>
          <!-- Schedule -->
          <div>
            <input
              name="schedule"
              type="text"
              value="${this.getForm6.schedule}"
            >
          </div>
          <!-- Duration -->
          <div>
            <input
              name="duration"
              type="text"
              value="${this.getForm6.duration}"
            >
          </div>
          <!-- Sign in button -->
          <button type="submit">
            Отправить
          </button>
        </form>`
      return result
    },
    forms: function() {
      return [
        this.form1,
        this.form2,
        this.form3,
        this.form4,
        this.form5,
        this.form6,
      ]
    },
  },
  methods: {
    send() {
      // console.log(this.forms, this.step, this.form1)
      let newWin = window.open('', `form1${this.step}`)
      newWin.document.write(this.forms[this.step])
      let form = newWin.document.getElementsByTagName('form')[0]
      form.submit()
      setTimeout(() => {
        if (this.step != 5) {
          newWin.close()
          this.step++
          this.send()
        }
      }, this.delay)
    },
  },
}
</script>