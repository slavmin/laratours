<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Информация о водителе (водителях)</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <v-form
        ref="form5"
        class="text-center"
      >
        <!-- Vue for-loop -->
        <div
          v-for="(driver, i) in info.drivers"
          :key="i"
        >
          <div class="h5 grey-text pt-2">
            Водитель {{ i+1 }}
            <button
              v-if="i != 0"
              class="btn btn-red btn-small"
              @click="removeDriver(driver)"
            >
              <i class="fas fa-times white-text" />
            </button>
          </div>
          <!-- Driver name -->
          <div class="md-form">
            <v-text-field
              v-model="driver.name"
              type="text"
              label="Фамилия имя и отчество (полностью)"
              :rules="rules.notEmpty"
            />
          </div>
          <!-- Driver license number -->
          <div class="md-form">
            <v-text-field
              v-model="driver.licence"
              type="text"
              label="Номер водительского удостоверения"
              :rules="rules.notEmpty"
            />
          </div>
          <!-- Driver license date -->
          <div class="md-form">
            <v-text-field
              v-model="driver.licence_date"
              type="text"
              label="Дата выдачи водительского удостоверения"
              :rules="rules.notEmpty"
            />
          </div>
          <!-- Driver license date -->
          <div class="row text-center justify-content-center">
            <p class="grey-text mt-3 mb-0">
              Сведения о стаже работы в качестве водителя транспортного средства
              категории «D» не менее одного года из последних 3 календарных лет:
            </p>
          </div>
          <div class="md-form">
            <v-text-field
              v-model="driver.experience"
              type="text"
              :rules="rules.notEmpty"
            />
          </div>
          <hr>
        </div>
        <!-- /Vue for-loop -->
      </v-form>
      <div class="row text-center justify-content-center">
        <button
          class="btn btn-green btn-small"
          @click="addDriver"
        >
          <i class="fas fa-plus white-text" />
        </button>
      </div>
    </div>
  </div>
  <!-- Material form login -->
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'Form5',
  computed: {
    ...mapGetters({
      info: 'getForm5',
      rules: 'getValidationRules',
    }),
  },
  mounted() {
    this.validate()
  },
  methods: {
    ...mapActions(['removeDriver', 'addDriver']),
    validate() {
      if (this.$refs.form5.validate()) {
        this.snackbar = true
      }
    },
  },
}
</script>