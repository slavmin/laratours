<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Информация о перевозчике</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Form -->
      <v-form
        ref="form3"
        class="text-center"
      >
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
              item-text="text"
              item-value="value"
              attach
            />
          </div>
        </div>
        <!-- Entity name. For type 2 -->
        <div
          v-if="info.type == 2"
          class="md-form"
        >
          <v-text-field
            v-model="info.entity_name"
            type="text"
            label="Полное наименование организации"
          />
        </div>
        <!-- Name. For type 3 -->
        <div
          v-if="info.type == 3"
          class="md-form"
        >
          <v-text-field
            v-model="info.name"
            type="text"
            label="ФИО"
          />
        </div>
        <!-- Entity address. For type 2 -->
        <div
          v-if="info.type == 2"
          class="md-form"
        >
          <v-text-field
            v-model="info.entity_address"
            type="text"
            label="Юридический адрес"
          />
        </div>
        <!-- Entity address. For type 3 -->
        <div
          v-if="info.type == 3"
          class="md-form"
        >
          <v-text-field
            v-model="info.address"
            type="text"
            label="Адрес места жительства"
          />
        </div>
        <!-- Entity location. Only for type 2 -->
        <div
          v-if="info.type == 2"
          class="md-form"
        >
          <v-text-field
            v-model="info.entity_location"
            type="text"
            label="Адрес места нахождения"
          />
        </div>
        <!-- Phone number -->
        <div class="md-form">
          <v-text-field
            v-model="info.phone"
            type="text"
            label="Контактный номер телефона и (или) факса"
          />
        </div>
        <!-- email -->
        <div class="md-form">
          <v-text-field
            v-model="info.email"
            type="email"
            label="Адрес электронной почты"
            :rules="rules.email"
          />
        </div>
        <!-- INN -->
        <div class="md-form">
          <v-text-field
            v-model="info.inn"
            type="text"
            label="ИНН"
            :rules="rules.inn"
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
  name: 'Form3',
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
      info: 'getForm3',
      rules: 'getValidationRules',
    }),
  },
  mounted() {
    this.validate()
  },
  methods: {
    validate() {
      if (this.$refs.form3.validate()) {
        this.snackbar = true
      }
    },
  },
}
</script>