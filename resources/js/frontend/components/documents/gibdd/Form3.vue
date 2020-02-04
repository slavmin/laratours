<template>
  <div class="card">
    <h5 class="card-header info-color white-text text-center py-4">
      <strong>Информация о перевозчике</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <form
        class="text-center"
        target="_blank"
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
            value="не ООО 'Тест'"
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
            value="test@test.test"
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
      </form>
      <!-- Form -->
    </div>
  </div>
  <!-- Material form login -->
</template>
<script>
export default {
  name: 'Form3',
}
</script>