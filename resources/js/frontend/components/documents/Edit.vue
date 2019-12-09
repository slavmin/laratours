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
          Редактирование
        </h1>
      </v-flex>
    </v-layout>
    <v-layout
      row
      wrap
    >
      <v-flex xs8>
        <Form 
          edit-mode
          :document="document"
        />
      </v-flex>
      <v-flex xs3>
        <v-card>
          <v-btn 
            color="#aa282a"
            dark
            type="submit"
          >
            Сохранить  
          </v-btn>
          <div class="subheading">
            Создан: {{ document.created_at }}
          </div>
          <div class="subheading">
            Изменён: {{ document.updated_at }}
          </div>
          <div class="subheading">
            Удалён: {{ document.deleted_at }}
          </div>
          <v-divider />
          <Labels />
          <v-divider />
          <Controls
            edit-mode
            :document="document"
          />
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import Form from './Form'
import Labels from './Labels'
import Controls from './Controls'
export default {
  name: 'DocumentEdit',
  components: {
    Form,
    Labels,
    Controls,
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
    return {
      pdfIsActive: false,
      wordIsActive: false,
    }
  },
  
}
</script>
