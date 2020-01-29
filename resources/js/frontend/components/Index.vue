<template>
  <div>
    <div class="row justify-content-md-center align-items-center">
      <a
        class="btn btn-outline-light"
        href="/login"
      >
        Войти
      </a>
    </div>
    <div class="row justify-content-md-center align-items-center mt-3">
      <a
        class="btn btn-outline-light"
        href="/register"
      >
        Зарегистрироваться
      </a>
    </div>
    <div class="row justify-content-center mt-4">
      <a
        class="btn btn-outline-light"
        href="/password/reset"
      >
        Забыли пароль?
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Index',
  props: {
    token: {
      type: String,
      default: () => {
        return ''
      },
    },
  },
  data() {
    return {}
  },
  methods: {
    toggleShowStates() {
      this.showLoginForm = !this.showLoginForm
      this.showForgottenPasswordButton = !this.showForgottenPasswordButton
    },
    clickLoginButton() {
      this.showLoginForm = true
      this.showLoginButton = false
      this.showForgottenPasswordButton = true
    },
    clickForgottenPasswordButton() {
      this.showLoginForm = false
      this.showLoginButton = false
      this.showForgottenPasswordButton = false
      this.showForgottenPasswordForm = true
    },
  },
}
</script>

<style lang="scss">
.slogan {
  text-align: center;
}
</style>
