<template>
  <div class="card">
    <h5 class="card-header info-color white-text text-center py-4">
      <strong>Информация о водителе (водителях)</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <form
        class="text-center"
        target="_blank"
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
            value="Водителев Вод Водович"
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
            Номер водительского удостоверения
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
            Дата выдачи водительского удостоверения
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
            Сведения о стаже работы в качестве водителя транспортного средства
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