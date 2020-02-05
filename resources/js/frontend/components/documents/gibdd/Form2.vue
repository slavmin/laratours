<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Информация о заказчике</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <form class="text-center">
        <!-- Type -->
        <div class="row">
          <div class="col-12 text-center grey-text">
            Тип заказчика
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <v-select
              v-model="info.type"
              color="#aa282a"
              :items="typesArray"
              attach
            />
          </div>
        </div>
        <!-- Entity name. For type 2 -->
        <div
          v-if="info.type == 2"
          class="md-form"
        >
          <input
            id="form2-entity_name"
            v-model="info.entity_name"
            type="text"
            class="form-control"
          >
          <label for="form2-entity_name">
            Полное наименование организации
          </label>
        </div>
        <!-- Name. For type 3 -->
        <div
          v-if="info.type == 3"
          class="md-form"
        >
          <input
            id="form2-name"
            v-model="info.name"
            type="text"
            class="form-control"
          >
          <label for="form2-name">
            ФИО
          </label>
        </div>
        <!-- Entity address. For type 2 -->
        <div
          v-if="info.type == 2"
          class="md-form"
        >
          <input
            id="form2-entity_address"
            v-model="info.entity_address"
            type="text"
            class="form-control"
          >
          <label for="form2-entity_address">
            Юридический адрес
          </label>
        </div>
        <!-- Entity address. For type 3 -->
        <div
          v-if="info.type == 3"
          class="md-form"
        >
          <input
            id="form2-address"
            v-model="info.address"
            type="text"
            class="form-control"
          >
          <label for="form2-address">
            Адрес места жительства
          </label>
        </div>
        <!-- Entity location. Only for type 2 -->
        <div
          v-if="info.type == 2"
          class="md-form"
        >
          <input
            id="form2-entity_location"
            v-model="info.entity_location"
            type="text"
            class="form-control"
          >
          <label for="form2-entity_location">
            Адрес места нахождения
          </label>
        </div>
        <!-- Phone number -->
        <div class="md-form">
          <input
            id="form2-phone"
            v-model="info.phone"
            type="text"
            class="form-control"
          >
          <label for="form2-phone">
            Контактный номер телефона и (или)
            факса
          </label>
        </div>
        <!-- email -->
        <div class="md-form">
          <input
            id="form2-email"
            v-model="info.email"
            type="email"
            class="form-control"
          >
          <label for="form2-email">
            Адрес электронной почты (при наличии)
          </label>
        </div>
        <!-- INN -->
        <div class="md-form">
          <input
            id="form2-inn"
            v-model="info.inn"
            type="text"
            class="form-control"
          >
          <label for="form2-inn">ИНН</label>
        </div>
      </form>
      <!-- Form -->
    </div>
  </div>
  <!-- Material form login -->
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'Form2',
  data() {
    return {
      typesArray: [
        { value: '2', text: 'Юр. лицо' },
        { value: '3', text: 'ИП' },
      ],
    }
  },
  computed: {
    ...mapGetters({
      info: 'getForm2',
    }),
  },
}
</script>