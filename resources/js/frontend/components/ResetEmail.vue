<template>
  <v-container 
    fluid
    grid-list-xs
    fill-height
    style="background-color: white;"
  >
    <v-layout 
      row 
      wrap
      justify-center
    >
      <v-flex
        xs10
        md6
        lg4
      >
        <v-card>
          <v-card-title 
            primary-title
            style="background-color: #66a5ae;"
          >
            <h3 class="subheading white--text">
              {{ headerText }}
            </h3>
          </v-card-title>
          <v-card-text>
            <v-text-field
              v-model="login"
              :label="emailText"
              :placeholder="emailText"
              color="#aa282a"
              required
            />
          </v-card-text>
          <v-divider />
          <v-card-actions>
            <v-spacer />
            <form 
              :action="resetPasswordUrl"
              method="POST"  
            >
              <input
                type="hidden"
                name="_token"
                :value="token"
              >
              <input
                v-model="login"
                type="hidden"
                name="email"
              >
              <v-btn 
                color="#aa282a"
                dark
                type="submit"
              >
                {{ submitText }}
              </v-btn>
            </form>
          </v-card-actions>
        </v-card> 
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
export default {
  name: 'ResetEmail',
  props: {
    headerText: {
      type: String,
      default: 'Заголовок',
    },
    resetPasswordUrl: {
      type: String,
      default: '#'
    },
    emailText: {
      type: String,
      default: 'email'
    },
    submitText: {
      type: String,
      default: 'submit'
    },
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      login: '',
    }
  },
}
</script>