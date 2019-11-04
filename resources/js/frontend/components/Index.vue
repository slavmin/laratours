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
      }
    }
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
    }
  }
}
</script>

<style lang="scss">
html,
body,
#app,
.root-wrap {
  width: 100%;
  height: 100%;
  margin-bottom: -106px;
}
.fullscreen-bg {
  background-color: #333;
  width: 100%;
  height: 100%;
  margin-top: -106px;
  background: url('/img/frontend/bg-bridge.jpg') center center no-repeat;
  background-size: cover;
  z-index: 2;
  > .row {
    width: 100%;
    height: 100%;
    margin-bottom: -106px;
    z-index: 10;
    position: relative;
  }
    &:before {
        display: block;
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 36px;
        left: 0;
        background-image: linear-gradient(to top,#000,rgba(0,0,0,.17));
        opacity: .7;
        z-index: 1;
    }
}
.slogan {
  font-family: 'Merriweather', serif;
    text-align: center;
}
</style>
