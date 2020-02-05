<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Информация об используемых автобусах</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Vue for-loop -->
      <div
        v-for="(vehicle, i) in info.vehicles"
        :key="i"
      >
        <div class="h5 grey-text pt-2">
          Автобус {{ i+1 }}
          <button
            class="btn btn-red btn-small"
            @click="removeVehicle(vehicle)"
          >
            <i class="fas fa-times white-text" />
          </button>
        </div>
        <!-- Bus model -->
        <div class="md-form">
          <input
            :id="`vehicles[${i}][brand_and_model]`"
            v-model="vehicle.brand_and_model"
            type="text"
            class="form-control"
          >
          <label :for="`vehicles[${i}][brand_and_model]`">
            Марка, модель
          </label>
        </div>
        <!-- Bus regnumber -->
        <div class="md-form">
          <input
            :id="`vehicles[${i}][number]`"
            v-model="vehicle.number"
            type="text"
            class="form-control"
          >
          <label :for="`vehicles[${i}][number]`">
            Государственный регистрационный знак
          </label>
        </div>
        <!-- Bus regnumber -->
        <div class="md-form">
          <input
            :id="`vehicles[${i}][diagnostic_card_info]`"
            v-model="vehicle.diagnostic_card_info"
            type="text"
            class="form-control"
          >
          <label :for="`vehicles[${i}][diagnostic_card_info]`">
            Номер диагностической карты и срок её действия
          </label>
        </div>
        <div class="custom-control custom-checkbox">
          <input
            :id="`navigator_info[${i}]`"
            v-model="vehicle.navigator_info"
            type="checkbox"
            class="custom-control-input"
            checked
          >
          <label
            class="custom-control-label grey-text"
            :for="`navigator_info[${i}]`"
          >
            Сведения об оснащении тахографом и аппаратурой спутниковой
            навигации
            ГЛОНАСС или ГЛОНАСС/GPS
          </label>
        </div>
        <hr>
      </div>
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
    }),
  },
  methods: {
    ...mapActions(['removeVehicle', 'addVehicle']),
  },
}
</script>