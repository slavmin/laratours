<template>
  <div class="card">
    <h5 class="card-header info-color white-text text-center py-4">
      <strong>Программа маршрута</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <form
        class="text-center"
        target="_blank"
        style="color: #757575;"
        action="https://гибдд.рф/transportation/route/"
        method="POST"
      >
        <h6>Начало маршрута</h6>
        <!-- Address start -->
        <div class="md-form">
          <input
            id="address_start"
            name="address_start"
            type="text"
            class="form-control"
            value="Россия, Санкт-Петербург, проспект Обуховской Обороны, 120ДЕ"
          >
          <label for="address_start">Адрес места начала перевозки</label>
        </div>
        <!-- Start lat -->
        <div class="md-form">
          <input
            type="text"
            name="start_coords[lat]"
            class="form-control"
            value="59.879456882294406"
          >
          <label for="drivers[0][licence]">
            Широта
          </label>
        </div>
        <!-- End lat -->
        <div class="md-form">
          <input
            type="text"
            name="start_coords[lng]"
            class="form-control"
            value="30.3875184984233"
          >
          <label for="drivers[0][licence]">
            Долгота
          </label>
        </div>
        <!-- Region -->
        <div class="md-form">
          <input
            id="region"
            name="region_code"
            type="text"
            class="form-control"
            value="78"
          >
          <label for="region">Регион</label>
        </div>
        <!-- Start district -->
        <div class="md-form">
          <input
            id="district"
            name="district"
            type="text"
            class="form-control"
            value="УДАЧНОалтейский"
          >
          <label for="district">
            Район или городской округ начала
            маршрута
          </label>
        </div>
        <h6>
          Адреса промежуточных остановочных пунктов и места окончания
          перевозки (координаты)
        </h6>
        <!-- Start point lat -->
        <div class="md-form">
          <input
            type="text"
            name="stop_points[0][lat]"
            class="form-control"
            value="60.05244395768214"
          >
          <label for="drivers[0][licence]">
            Широта
          </label>
        </div>
        <!-- Stop point lat -->
        <div class="md-form">
          <input
            type="text"
            name="stop_points[0][lng]"
            class="form-control"
            value="30.380161110304684"
          >
          <label for="drivers[0][licence]">
            Долгота
          </label>
        </div>
        <!-- Stop time -->
        <div class="md-form">
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
        </div>
        <!-- Stop goal -->
        <div class="md-form">
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
        </div>
        <!-- Distance -->
        <div class="md-form">
          <input
            id="distance"
            name="distance"
            type="text"
            class="form-control"
            value="15"
          >
          <label for="distance">
            Расстояние перевозки в километрах
          </label>
        </div>
        <!-- Schedule -->
        <div class="md-form">
          <input
            id="schedule"
            name="schedule"
            type="text"
            class="form-control"
            value="9-18"
          >
          <label for="schedule">
            График движения
          </label>
        </div>
        <!-- Duration -->
        <div class="md-form">
          <input
            id="duration"
            name="duration"
            type="text"
            class="form-control"
            value="04:00"
          >
          <label for="duration">
            Расчётное время в пути (ЧЧ:ММ)
          </label>
        </div>
        <!-- Sign in button -->
        <button
          class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
          type="submit"
        >
          Отправить
        </button>
      </form>
      <!-- Form -->
    </div>
    <v-btn
      color="green"
      @click="send"
    >
      ОПОПУДАЧА2
    </v-btn>
  </div>
  <!-- Material form login -->
</template>
<script>
export default {
  name: 'Form4',
  data() {
    return {
      step: 0,
      forms: [
        {
          id: 1,
          form: `<form
        id="form1"
        class="text-center"
        
        style="color: #757575;"
        action="https://гибдд.рф/transportation/applicant/"
        method="POST"
      >
        <!-- Name -->
        <div class="md-form">
          <input
            id="name"
            name="name"
            type="text"
            class="form-control"
            value="ОПОПУДАЧА2ов ОПОПУДАЧА2 ОПОПУДАЧА2ович"
          >
          <label for="name">ФИО</label>
        </div>
        <!-- Position -->
        <div class="md-form">
          <input
            id="position"
            name="position"
            type="text"
            class="form-control"
            value="ОПОПУДАЧА2ировщик форм"
          >
          <label for="position">Должность</label>
        </div>
        <!-- Phone number -->
        <div class="md-form">
          <input
            id="phone"
            name="phone"
            type="text"
            class="form-control"
            value="+7-111-111-22-33"
          >
          <label for="phone">Телефон</label>
        </div>
        <!-- email -->
        <div class="md-form">
          <input
            id="email"
            name="email"
            type="email"
            class="form-control"
            value="ОПОПУДАЧА21@ОПОПУДАЧА2.ОПОПУДАЧА2"
          >
          <label for="email">Email</label>
        </div>
        <!-- Region -->
        <div class="md-form">
          <input
            id="region"
            name="region_code[]"
            type="text"
            class="form-control"
            value="78"
          >
          <label for="region">Регион</label>
        </div>
        <!-- Count -->
        <div class="md-form">
          <input
            id="count"
            name="count"
            type="text"
            class="form-control"
            value="15"
          >
          <label for="count">Количество детей</label>
        </div>
        <!-- Goal -->
        <div class="md-form">
          <input
            id="goal"
            name="goal"
            type="text"
            class="form-control"
            value="Экскурсия ОПОПУДАЧА2а"
          >
          <label for="goal">Цель</label>
        </div>
        <!-- Date start -->
        <div class="md-form">
          <input
            id="date_start"
            name="date_start"
            type="text"
            class="form-control"
            value="2020-10-01 00:00"
          >
          <label for="date_start">
            Предполагаемое время начала перевозки
          </label>
        </div>
        <!-- Date end -->
        <div class="md-form">
          <input
            id="date_end"
            name="date_end"
            type="text"
            class="form-control"
            value="2020-11-01 00:00"
          >
          <label for="date_start">
            Предполагаемое время окончания перевозки
          </label>
        </div>
      </form>`,
        },
        {
          id: 2,
          form: `<form
          class="text-center"
          
          style="color: #757575;"
          action="https://гибдд.рф/transportation/customers/"
          method="POST"
        >
          <!-- Type -->
          <div class="md-form">
            <input
              id="type"
              name="type"
              type="text"
              class="form-control"
              value="2"
            >
            <label for="type">Тип заказчика (1 - физ, 2 - юр, 3 - ИП)</label>
          </div>
          <!-- Entity name -->
          <div class="md-form">
            <input
              id="entity_name"
              name="entity_name"
              type="text"
              class="form-control"
              value="не ООО 'ОПОПУДАЧА2'"
            >
            <label for="entity_name">
              Полное наименование с указанием организационно-правовой формы
            </label>
          </div>
          <!-- Entity address -->
          <div class="md-form">
            <input
              id="entity_address"
              name="entity_address"
              type="text"
              class="form-control"
              value="СПб"
            >
            <label for="entity_address">
              Юридический адрес
            </label>
          </div>
          <!-- Entity location -->
          <div class="md-form">
            <input
              id="entity_location"
              name="entity_location"
              type="text"
              class="form-control"
              value="Горелово"
            >
            <label for="entity_location">
              Адрес места нахождения
            </label>
          </div>
          <!-- Phone number -->
          <div class="md-form">
            <input
              id="phone"
              name="phone"
              type="text"
              class="form-control"
              value="+7-111-22-55"
            >
            <label for="phone">Контактный номер телефона и (или) факса</label>
          </div>
          <!-- email -->
          <div class="md-form">
            <input
              id="email"
              name="email"
              type="email"
              class="form-control"
              value="ОПОПУДАЧА2@ОПОПУДАЧА2.ОПОПУДАЧА2"
            >
            <label for="email">Адрес электронной почты (при наличии)</label>
          </div>
          <!-- INN -->
          <div class="md-form">
            <input
              id="inn"
              name="inn"
              type="text"
              class="form-control"
              value="7729773587"
            >
            <label for="inn">ИНН</label>
          </div>
          <!-- Sign in button -->
          <button
            class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
            type="submit"
          >
            Отправить
          </button>
        </form>`,
        },
        {
          id: 3,
          form: `<form
          class="text-center"
          
          style="color: #757575;"
          action="https://гибдд.рф/transportation/carriers/"
          method="POST"
        >
          <!-- Type -->
          <div class="md-form">
            <input
              id="type"
              name="type"
              type="text"
              class="form-control"
              value="2"
            >
            <label for="type">Тип заказчика (2 - юр, 3 - ИП)</label>
          </div>
          <!-- Entity name -->
          <div class="md-form">
            <input
              id="entity_name"
              name="entity_name"
              type="text"
              class="form-control"
              value="не ООО 'ОПОПУДАЧА2'"
            >
            <label for="entity_name">
              Полное наименование с указанием организационно-правовой формы
            </label>
          </div>
          <!-- Entity address -->
          <div class="md-form">
            <input
              id="entity_address"
              name="entity_address"
              type="text"
              class="form-control"
              value="СПб"
            >
            <label for="entity_address">
              Юридический адрес
            </label>
          </div>
          <!-- Entity location -->
          <div class="md-form">
            <input
              id="entity_location"
              name="entity_location"
              type="text"
              class="form-control"
              value="Горелово"
            >
            <label for="entity_location">
              Адрес места нахождения
            </label>
          </div>
          <!-- Phone number -->
          <div class="md-form">
            <input
              id="phone"
              name="phone"
              type="text"
              class="form-control"
              value="+7-111-22-55"
            >
            <label for="phone">Контактный номер телефона и (или) факса</label>
          </div>
          <!-- email -->
          <div class="md-form">
            <input
              id="email"
              name="email"
              type="email"
              class="form-control"
              value="ОПОПУДАЧА2@ОПОПУДАЧА2.ОПОПУДАЧА2"
            >
            <label for="email">Адрес электронной почты (при наличии)</label>
          </div>
          <!-- INN -->
          <div class="md-form">
            <input
              id="inn"
              name="inn"
              type="text"
              class="form-control"
              value="7729773587"
            >
            <label for="inn">ИНН</label>
          </div>
          <!-- Sign in button -->
          <button
            class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
            type="submit"
          >
            Sign in
          </button>
        </form>`,
        },
        {
          id: 4,
          form: `<div class="card-body px-lg-5 pt-0">
        <!-- Form -->
        <form
          class="text-center"
          
          style="color: #757575;"
          action="https://гибдд.рф/transportation/vehicles/"
          method="POST"
        >
          <!-- Bus model -->
          <div class="md-form">
            <input
              id="vehicles[0][brand_and_model]"
              name="vehicles[0][brand_and_model]"
              type="text"
              class="form-control"
              value="ОПОПУДАЧА2овый автобус"
            >
            <label for="vehicles[0][brand_and_model]">
              Марка, модель
            </label>
          </div>
          <!-- Bus regnumber -->
          <div class="md-form">
            <input
              id="vehicles[0][number]"
              name="vehicles[0][number]"
              type="text"
              class="form-control"
              value="o000oo00"
            >
            <label for="vehicles[0][number]">
              Государственный регистрационный знак
            </label>
          </div>
          <!-- Bus regnumber -->
          <div class="md-form">
            <input
              id="vehicles[0][diagnostic_card_info]"
              name="vehicles[0][diagnostic_card_info]"
              type="text"
              class="form-control"
              value="111"
            >
            <label for="vehicles[0][diagnostic_card_info]">
              Номер диагностической карты и срок её действия
            </label>
          </div>
          <div class="custom-control custom-checkbox">
            <input
              id="glonass"
              type="checkbox"
              name="vehicles[0][navigator_info]"
              class="custom-control-input"
              checked
              value="1"
            >
            <label
              class="custom-control-label"
              for="glonass"
            >
              Сведения об оснащении тахографом и аппаратурой спутниковой навигации
              ГЛОНАСС или ГЛОНАСС/GPS
            </label>
          </div>
          <!-- Sign in button -->
          <button
            class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
            type="submit"
          >
            Отправить
          </button>
        </form>`,
        },
        {
          id: 5,
          form: `<form
          class="text-center"
          
          style="color: #757575;"
          action="https://гибдд.рф/transportation/drivers/"
          method="POST"
        >
          <!-- Driver name -->
          <div class="md-form">
            <input
              id="drivers[0][name]"
              name="drivers[0][name]"
              type="text"
              class="form-control"
              value="УДАЧНОЕителев УДАЧНОЕ УДАЧНОЕович"
            >
            <label for="drivers[0][name]">
              Фамилия имя и отчество (полностью)
            </label>
          </div>
          <!-- Driver license number -->
          <div class="md-form">
            <input
              id="drivers[0][licence]"
              name="drivers[0][licence]"
              type="text"
              class="form-control"
              value="78РН000000"
            >
            <label for="drivers[0][licence]">
              Номер УДАЧНОЕительского удостоверения
            </label>
          </div>
          <!-- Driver license date -->
          <div class="md-form">
            <input
              id="drivers[0][licence_date]"
              name="drivers[0][licence_date]"
              type="text"
              class="form-control"
              value="01.01.2001"
            >
            <label for="drivers[0][licence_date]">
              Дата выдачи УДАЧНОЕительского удостоверения
            </label>
          </div>
          <!-- Driver license date -->
          <div class="md-form">
            <input
              id="drivers[0][experience]"
              name="drivers[0][experience]"
              type="text"
              class="form-control"
              value="10 лет"
            >
            <label for="drivers[0][experience]">
              Сведения о стаже работы в качестве УДАЧНОЕителя транспортного средства
              категории «D» не менее одного года из последних 3 календарных лет
            </label>
          </div>
          <!-- Sign in button -->
          <button
            class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
            type="submit"
          >
            Отправить
          </button>
        </form>`,
        },
        {
          id: 6,
          form: `<form
          class="text-center"
          
          style="color: #757575;"
          action="https://гибдд.рф/transportation/route/"
          method="POST"
        >
          <h6>Начало маршрута</h6>
          <!-- Address start -->
          <div class="md-form">
            <input
              id="address_start"
              name="address_start"
              type="text"
              class="form-control"
              value="Россия, Санкт-Петербург, проспект Обуховской Обороны, 120ДЕ"
            >
            <label for="address_start">Адрес места начала перевозки</label>
          </div>
          <!-- Start lat -->
          <div class="md-form">
            <input
              type="text"
              name="start_coords[lat]"
              class="form-control"
              value="59.879456882294406"
            >
            <label for="drivers[0][licence]">
              Широта
            </label>
          </div>
          <!-- End lat -->
          <div class="md-form">
            <input
              type="text"
              name="start_coords[lng]"
              class="form-control"
              value="30.3875184984233"
            >
            <label for="drivers[0][licence]">
              Долгота
            </label>
          </div>
          <!-- Region -->
          <div class="md-form">
            <input
              id="region"
              name="region_code"
              type="text"
              class="form-control"
              value="78"
            >
            <label for="region">Регион</label>
          </div>
          <!-- Start district -->
          <div class="md-form">
            <input
              id="district"
              name="district"
              type="text"
              class="form-control"
              value="УДАЧНОалтейский"
            >
            <label for="district">
              Район или городской округ начала
              маршрута
            </label>
          </div>
          <h6>
            Адреса промежуточных остановочных пунктов и места окончания
            перевозки (координаты)
          </h6>
          <!-- Start point lat -->
          <div class="md-form">
            <input
              type="text"
              name="stop_points[0][lat]"
              class="form-control"
              value="60.05244395768214"
            >
            <label for="drivers[0][licence]">
              Широта
            </label>
          </div>
          <!-- Stop point lat -->
          <div class="md-form">
            <input
              type="text"
              name="stop_points[0][lng]"
              class="form-control"
              value="30.380161110304684"
            >
            <label for="drivers[0][licence]">
              Долгота
            </label>
          </div>
          <!-- Stop time -->
          <div class="md-form">
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
          </div>
          <!-- Stop goal -->
          <div class="md-form">
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
          </div>
          <!-- Distance -->
          <div class="md-form">
            <input
              id="distance"
              name="distance"
              type="text"
              class="form-control"
              value="15"
            >
            <label for="distance">
              Расстояние перевозки в километрах
            </label>
          </div>
          <!-- Schedule -->
          <div class="md-form">
            <input
              id="schedule"
              name="schedule"
              type="text"
              class="form-control"
              value="9-18"
            >
            <label for="schedule">
              График движения
            </label>
          </div>
          <!-- Duration -->
          <div class="md-form">
            <input
              id="duration"
              name="duration"
              type="text"
              class="form-control"
              value="04:00"
            >
            <label for="duration">
              Расчётное время в пути (ЧЧ:ММ)
            </label>
          </div>
          <!-- Sign in button -->
          <button
            class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
            type="submit"
          >
            Отправить
          </button>
        </form>`,
        },
      ],
    }
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
  },
}
</script>