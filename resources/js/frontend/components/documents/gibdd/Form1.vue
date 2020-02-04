<template>
  <div class="card">
    <h5 class="card-header info-color white-text text-center py-4">
      <strong>Информация о заявителе</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <form
        id="form1"
        class="text-center"
        target="_blank"
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
            value="Тестов Тест Тестович"
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
            value="Тестировщик форм"
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
            value="+7-000-111-22-33"
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
            value="test@test.test"
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
            value="Экскурсия теста"
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
      </form>
      <!-- Sign in button -->
      <button
        class="btn btn-outline-info btn-rounded btn-block my-4 waves-effect z-depth-0"
        @click="send"
      >
        Отправить
      </button>
      <!-- Form -->
    </div>
  </div>
  <!-- Material form login -->
</template>
<script>
export default {
  name: 'Form1',
  methods: {
    send() {
      let form = document.getElementById('form1')
      form.submit()
      console.log('submit', form)
    },
  },
}
</script>