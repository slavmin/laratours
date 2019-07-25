<template>
  <div>
    <v-layout 
      row 
      wrap
    >
      <v-flex xs12>
        <v-layout 
          row 
          wrap
          justify-content-center
        >
          <v-btn 
            dark 
            color="green"
            @click="addMoreGuide"
          >
            Добавить гида
          </v-btn>
          <v-btn 
            dark 
            color="green"
            @click="addMoreAttendant"
          >
            Добавить сопровождающего
          </v-btn>
        </v-layout>
      </v-flex>
      <v-flex xs12>
        <v-layout 
          row 
          wrap
          justify-center
          mt-5
        >
          <h3>Доп. услуги:</h3>
        </v-layout>
        <v-layout 
          row 
          wrap
          mt-5
          justify-center
        >
          <v-flex 
            xs3
            mr-5
          >
            <v-text-field
              v-model="customPrice.name"
              label="Название"
              placeholder="доп. услуга"
              outline
            />
          </v-flex>
          <v-flex 
            xs2
            mr-5
          >
            <v-text-field
              v-model="customPrice.value"
              label="Цена"
              mask="########"
              outline
            />
          </v-flex>
          <v-btn 
            fab
            small
            title="Добавить"
            color="green"
            dark 
            @click="addCustomService"
          >
            <i class="material-icons">
              add
            </i>
          </v-btn>
        </v-layout>
        <v-layout 
          row 
          wrap
          justify-center
        >
          <v-flex 
            v-if="showTable"
            xs12
          >
            <table class="summary">
              <thead>
                <th>
                  Услуга
                </th>
                <th>
                  Стоимость
                </th>  
              </thead>
              <tbody>
                <tr
                  v-for="price in getCustomPrice"
                  :key="price.name"
                >
                  <td>
                    {{ price.name }}
                  </td>
                  <td>
                    {{ price.value }}
                  </td>
                </tr>
              </tbody>
            </table>
          </v-flex>
        </v-layout>
        <v-layout 
          row 
          wrap
          justify-end
        >
          <v-flex xs2> 
            <v-btn 
              dark
              color="green"
              @click="done"
            >
              OK
            </v-btn>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {

  name: 'Services',

  data() {
    return {
      customPrice: {
        name: '',
        value: NaN,
      }
    };
  },
  computed: {
    ...mapGetters(['getCustomPrice']),
    showTable: function() {
      return this.getCustomPrice.length == 0 ? false : true
    },
  },
  updated() {
    this.getCustomPrice
  },
  methods: {
    ...mapActions([
      'updateConstructorCurrentStage',
      'updateCustomPrice',
      'updateConstructorCurrentStage',
    ]),
    addMoreGuide() {
      this.updateConstructorCurrentStage('Hotel is set')
    },
    addMoreAttendant() {
      this.updateConstructorCurrentStage('Show attendant')
    },
    addCustomService() {
      if (this.customPrice.name != '' && this.customPrice.value != NaN) {
        this.updateCustomPrice(this.customPrice)
        this.customPrice = {
          name: '',
          value: NaN,
        }
      }
      console.log(this.getCustomPrice)
    },
    done() {
      this.updateConstructorCurrentStage('Show summary')
    }
  },
};
</script>

<style lang="scss" scoped>
.summary {
  margin: 0 auto;
  td,
  th {
    border: 1px solid gray;
    padding: 16px;
    font-size: 24px;
  }
}
</style>
