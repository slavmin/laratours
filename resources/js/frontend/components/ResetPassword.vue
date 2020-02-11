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
            <p class="subheading">
              Введите новый пароль.
            </p>
            <p>
              {{ resetPasswordHint }}
            </p>
            <form 
              id="form"
              :action="resetPasswordUrl"
              method="POST"  
            >
              <input
                type="hidden"
                name="_token"
                :value="token"
              >
              <input
                v-model="user"
                type="hidden"
                name="email"
              >
              <input
                v-model="userToken"
                type="hidden"
                name="token"
              >
              <v-text-field
                v-model="password"
                :label="passwordText"
                :placeholder="passwordText"
                type="password"
                color="#aa282a"
                name="password"
                required
              />
              <v-text-field
                v-model="confirmPassword"
                :label="confirmPasswordText"
                :placeholder="confirmPasswordText"
                type="password"
                color="#aa282a"
                name="password_confirmation"
                required
              />
            </form>
          </v-card-text>
          <v-divider />
          <v-card-actions>
            <v-spacer />
            <v-btn 
              color="#aa282a"
              dark
              form="form"
              type="submit"
            >
              {{ submitText }}
            </v-btn>
          </v-card-actions>
        </v-card> 
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
export default {
  name: 'ResetPassword',
  props: {
    headerText: {
      type: String,
      default: 'Заголовок',
    },
    resetPasswordHint: {
      type: String,
      default: '#'
    },
    resetPasswordUrl: {
      type: String,
      default: '#'
    },
    passwordText: {
      type: String,
      default: 'password'
    },
    confirmPasswordText: {
      type: String,
      default: 'confirm'
    },
    submitText: {
      type: String,
      default: 'submit'
    },
    token: {
      type: String,
      default: ''
    },
    userToken: {
      type: String,
      default: '',
    },
    user: {
      type: String,
      default: '',
    }
  },
  data() {
    return {
      password: '',
      confirmPassword: '',
    }
  },
}
</script>