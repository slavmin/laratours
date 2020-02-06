<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Информация об используемых автобусах</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <v-form
        ref="form4"
        class="text-center"
      >
        <!-- Vue for-loop -->
        <div
          v-for="(vehicle, i) in info.vehicles"
          :key="i"
        >
          <div class="h5 grey-text pt-2">
            Автобус {{ i+1 }}
            <button
              v-if="i != 0"
              class="btn btn-red btn-small"
              @click="removeVehicle(vehicle)"
            >
              <i class="fas fa-times white-text" />
            </button>
          </div>
          <!-- Bus model -->
          <div class="md-form">
            <v-text-field
              v-model="vehicle.brand_and_model"
              type="text"
              label="Марка, модель"
              :rules="rules.notEmpty"
            />
          </div>
          <!-- Bus regnumber -->
          <div class="md-form">
            <v-text-field
              v-model="vehicle.number"
              type="text"
              label="Государственный регистрационный знак"
              :rules="rules.notEmpty"
            />
          </div>
          <!-- Bus regnumber -->
          <div class="md-form">
            <v-text-field
              v-model="vehicle.diagnostic_card_info"
              type="text"
              label="Номер диагностической карты и срок её действия"
              :rules="rules.notEmpty"
            />
          </div>
          <div class="custom-control custom-checkbox">
            <v-checkbox
              v-model="vehicle.navigator_info"
              type="checkbox"
              checked
              label="Сведения об оснащении тахографом и аппаратурой спутниковой навигации ГЛОНАСС или ГЛОНАСС/GPS"
              color="#aa282a"
            />
            <div
              v-if="!vehicle.navigator_info"
              class="error--text"
            >
              Оснащение автобусов тахографом и аппаратурой спутниковой навигации
              ГЛОНАСС или ГЛОНАСС/GPS для перевозки группы детей является
              обязательным требованием
            </div>
          </div>
          <hr>
        </div>
      </v-form>
      <!-- /Vue for-loop -->
      <div class="row text-center justify-content-center">
        <button
          class="btn btn-green btn-small"
          @click="addVehicle"
        >
          <i class="fas fa-plus white-text" />
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'Form4',
  computed: {
    ...mapGetters({
      info: 'getForm4',
      rules: 'getValidationRules',
    }),
  },
  mounted() {
    this.validate()
  },
  methods: {
    ...mapActions(['removeVehicle', 'addVehicle']),
    validate() {
      if (this.$refs.form4.validate()) {
        this.snackbar = true
      }
    },
  },
}
</script>