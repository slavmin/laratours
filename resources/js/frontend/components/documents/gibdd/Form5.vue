<template>
  <div class="card">
    <h5 class="card-header white-text text-center py-4 tc-blue-header">
      <strong>Информация о водителе (водителях)</strong>
    </h5>
    <!--Card content-->
    <div class="card-body px-lg-5 pt-0">
      <!-- Vue for-loop -->
      <div
        v-for="(driver, i) in info.drivers"
        :key="i"
      >
        <div class="h5 grey-text pt-2">
          Водитель {{ i+1 }}
          <button
            class="btn btn-red btn-small"
            @click="removeDriver(driver)"
          >
            <i class="fas fa-times white-text" />
          </button>
        </div>
        <!-- Driver name -->
        <div class="md-form">
          <input
            :id="`drivers[${i}][name]`"
            v-model="driver.name"
            type="text"
            class="form-control"
          >
          <label :for="`drivers[${i}][name]`">
            Фамилия имя и отчество (полностью)
          </label>
        </div>
        <!-- Driver license number -->
        <div class="md-form">
          <input
            :id="`drivers[${i}][licence]`"
            v-model="driver.licence"
            type="text"
            class="form-control"
          >
          <label :for="`drivers[${i}][licence]`">
            Номер водительского удостоверения
          </label>
        </div>
        <!-- Driver license date -->
        <div class="md-form">
          <input
            :id="`drivers[${i}][licence_date]`"
            v-model="driver.licence_date"
            type="text"
            class="form-control"
          >
          <label :for="`drivers[${i}][licence_date]`">
            Дата выдачи водительского удостоверения
          </label>
        </div>
        <!-- Driver license date -->
        <div class="row text-center justify-content-center">
          <p class="grey-text mt-3 mb-0">
            Сведения о стаже работы в качестве водителя транспортного средства
            категории «D» не менее одного года из последних 3 календарных лет:
          </p>
        </div>
        <div class="md-form">
          <input
            :id="`drivers[${i}][experience]`"
            v-model="driver.experience"
            type="text"
            class="form-control"
          >
        </div>
        <hr>
      </div>
      <!-- /Vue for-loop -->
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
    }),
  },
  methods: {
    ...mapActions(['removeDriver', 'addDriver']),
  },
}
</script>