<template>
  <v-dialog 
    v-model="dialog" 
    persistent 
    max-width="600px"
  >
    <template v-slot:activator="{ on }">
      <v-btn 
        small
        fab
        outline
        color="green" 
        title="Редактировать"
        dark 
        v-on="on"
      >
        <i class="material-icons">
          edit
        </i>
      </v-btn>
    </template>
    <v-card>
      <v-card-title>
        <span class="headline">
          User Profile
        </span>
      </v-card-title>
      <v-card-text>
        <form 
          method="POST" 
          :action="'http://127.0.0.1:8000/operator/transport/' + companyId" 
          class="form-horizontal"
        >
          <input 
            id="_method" 
            type="hidden" 
            name="_method" 
            value="PATCH"
          >
          <input 
            type="hidden" 
            name="_token" 
            value="zVAcZSK0e8ZUXp1se8kUL7ZuXe0ix3hvqPIzKGID"
          > 
          <input 
            :id="attribute + '[id]'" 
            type="hidden" 
            :name="attribute + '[id]'" 
            :value="id"
          > 
          <div class="card mt-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-5">
                  <h6 class="card-title mb-0">
                    Тип транспорта                
                  </h6>
                </div>
              </div>
              <hr>
              <div class="row mt-4">
                <div class="col">
                  <div class="form-group row">
                    <label 
                      for="customer_type_id" 
                      class="col-md-2 form-control-label"
                    >
                      Тип туриста
                    </label> 
                    <div class="col-md-10">
                      <select 
                        :id="attribute + '[customer_type_id]'" 
                        :name="attribute + '[customer_type_id]'" 
                        class="form-control"
                      >
                        <option 
                          value="" 
                          selected="selected"
                        >
                          Выбрать
                        </option>
                        <option value="17">
                          test
                        </option>
                        <option value="19">
                          testt
                        </option>
                        <option value="1">
                          Взрослый
                        </option>
                        <option value="16">
                          Пенсионер
                        </option>
                        <option value="15">
                          Школьник
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mt-4">
                  <input 
                    :id="attribute + '[name]'" 
                    v-model="name"
                    type="text" 
                    :name="attribute + '[name]'" 
                    placeholder="Название" 
                    maxlength="191" 
                    required="required" 
                    autofocus="autofocus" 
                    class="form-control"
                  >
                  <input 
                    :id="attribute + '[price]'" 
                    v-model="price"
                    type="number" 
                    :name="attribute + '[price]'" 
                    value="34343434343434" 
                    placeholder="Цена" 
                    maxlength="191" 
                    autofocus="autofocus" 
                    class="form-control"
                  >
                  <input 
                    :id="attribute + '[qnt]'" 
                    v-model="qnt"
                    type="number" 
                    :name="attribute + '[qnt]'" 
                    placeholder="Кол-во" 
                    maxlength="191" 
                    autofocus="autofocus" 
                    class="form-control"
                  >
                  <input 
                    :id="attribute + '[extra]'" 
                    v-model="extra"
                    type="text" 
                    :name="attribute + '[extra]'"
                    placeholder="Кол-во" 
                    maxlength="191" 
                    autofocus="autofocus" 
                    class="form-control"
                  >
                </div>
                <button 
                  type="submit" 
                  class="btn btn-success btn-sm"
                >
                  Применить
                </button>
              </div>
            </div>
          </div>
        </form>
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn 
          color="blue darken-1" 
          flat 
          @click="dialog = false"
        >
          Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {

  name: 'Test',
  props: {
    item: {
      type: Object,
      default: () => {
        return {}
      }
    },
    companyId: {
      type: Number,
      default: 0
    }
  },
  data() {
    return {
      dialog: false,
      extra: {
        grade: ['TOP-class']
      },
      id: 0,
      name: '',
      price: 0,
      qnt: 0,
      attribute: 'attribute'
    };
  },
  created() {
    this.id = this.item.id
    this.name = this.item.name
    this.price = this.item.price
    this.qnt = this.item.qnt
    this.attribute = this.attribute + '[' + this.id + ']'
    console.log(this.attribute)
  },
};
</script>

<style lang="css" scoped>
</style>
