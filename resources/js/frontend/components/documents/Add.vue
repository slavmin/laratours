<template>
  <v-container 
    fluid
    grid-list-md
    text-xs-center
    style="background-color: #66a5ae;"
  >
    <v-layout 
      row 
      wrap
      justify-center
    >  
      <v-flex> 
        <h1 class="text-center white--text mb-5">
          <v-icon
            dark
            large
          >
            view_list
          </v-icon>
          Добавить
        </h1>
      </v-flex>
    </v-layout>
    <v-layout
      row
      wrap
      justify-center
    >
      <v-flex 
        xs12
        md8
      >
        <Form 
          edit-mode
          :document="document"
        />
      </v-flex>
      <v-flex 
        xs12
        md3
      >
        <v-card>
          <v-btn 
            color="#aa282a"
            dark
            type="submit"
          >
            Сохранить  
          </v-btn>
          <v-divider />
          <Labels />
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import Form from './Form'
import Labels from './Labels'
export default {
  name: 'DocumentAdd',
  components: {
    Form,
    Labels,
  },
  props: {
    token: {
      type: String,
      default: '',
    },
    document: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {}
  },
}
</script>
