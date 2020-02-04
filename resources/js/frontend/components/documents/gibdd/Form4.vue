<template>
  <div class="card">
    <h5 class="card-header info-color white-text text-center py-4">
      <strong>Информация о заказчике</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <form
        class="text-center"
        target="_blank"
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
            value="Тестовый автобус"
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
            value="1"
            checked
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
      </form>
      <!-- Form -->
    </div>
  </div>
  <!-- Material form login -->
</template>
<script>
export default {
  name: 'Form4',
}
</script>