<template>
  <div>
    <v-layout
      row
      wrap
      class="wrap"
      justify-center
    >
      <v-flex 
        xs12
        md4
      >
        <h2 class="text-xs-center grey--text">
          Тур от партнёра
        </h2>
        <v-text-field
          v-model="getPartnerTour.partnerName"
          label="Название партнёра"
        />
        <v-layout 
          row 
          wrap
        >
          <v-text-field
            v-model.number="getPartnerTour.commission"
            label="Комиссия в рублях"
          />
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-icon 
                color="grey"
                v-on="on"
              >
                info
              </v-icon>
            </template>
            <span>
              Сумма выплачивается с одного проданного места, вне зависимости от типа туриста
            </span>
          </v-tooltip>
        </v-layout>
      </v-flex>
    </v-layout>
    <v-layout 
      row 
      wrap
      justify-center
    >
      <v-flex 
        xs12
        md6  
      >
        <Prices />
      </v-flex>  
      <v-flex 
        xs12
        md6
      >
        <Extra />
      </v-flex>
    </v-layout>
    <v-layout 
      row 
      wrap
      justify-center
    >
      <v-flex xs12>
        <Editor />
      </v-flex>  
    </v-layout>
    <SaveTourForm
      :token="token"
    />
  </div>
</template>

<script>
import Prices from './partner/Prices'
import Extra from './partner/Extra'
import Editor from './partner/Editor'
import SaveTourForm from './SaveTourForm'
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'PartnerTour',
  components: {
    Prices,
    Extra,
    Editor,
    SaveTourForm,
  },
  props: {
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      partner: '',
    };
  },
  computed: {
    ...mapGetters([
      'getEditMode',
      'getPartnerTour',
    ]),
  },
  methods: {
    done() {
      console.log('done')
    }
  }
};
</script>

<style lang="css" scoped>
.guide-card {
  background-color: #E8F5E9;
}
.is-select {
  background-color: #FFAB16;
  color: white;
  transform: scale(0.9);
}
.wrap {
  position: relative;
}
.done-btn {
  position: fixed;
  top: 50%;
  right: 24px;
}
</style>
