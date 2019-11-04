<template>
  <div>
    <!-- Login form -->
    <div 
      v-if="showLoginForm"
      class="row justify-content-center align-items-center"
    >
      <form 
        method="POST" 
        action="/login"
      >
        <input 
          type="hidden" 
          name="_token" 
          :value="token"
        >
        <div class="form-group">
          <input  
            id="email"
            type="email" 
            class="form-control" 
            name="email" 
            placeholder="Введите email" 
            required
          >
        </div>
        <div class="form-group">
          <input  
            id="password" 
            type="password" 
            class="form-control" 
            name="password"
            placeholder="Пароль"    
            required
          >
        </div>
        <div class="form-group form-check">
          <input 
            id="remember" 
            type="checkbox" 
            class="form-check-input" 
            name="remember" 
            value="1" 
            checked
          >
          <label 
            class="form-check-label text-white" 
            for="remember"
          >
            Запомнить
          </label>
        </div>
        <div class="row justify-content-center">
          <button 
            type="submit" 
            class="btn btn-light"
          >
            Войти
          </button> 
        </div>
      </form>
    </div>
    <!-- /Login form -->
    <!-- Forgotten password form -->
    <!-- <div
      v-if="showForgottenPasswordForm"
      class="row justify-content-center align-items-center" 
    >
      <form 
        method="POST" 
        action="/password/email"
      >
        <input 
          type="hidden" 
          name="_token" 
          :value="token"
        >
        <div class="form-group">
          <div class="row justify-content-center">
            <p class="text-white">
              Восстановление пароля
            </p>
          </div>
          <input 
            id="email" 
            type="email" 
            class="form-control" 
            name="email" 
            placeholder="Enter email" 
            required
          >
        </div> 
        <div class="row justify-content-center">
          <button 
            type="submit" 
            class="btn btn-outline-light"
          >
            Отправить
          </button> 
        </div> 
      </form>       
    </div>  -->
    <!-- /Forgotten password form -->
    <!-- Button switch display login form -->
    <div class="row justify-content-md-center align-items-center">
      <button 
        v-if="showLoginButton"
        type="button" 
        class="btn btn-outline-light"
        @click="clickLoginButton"
      >
        Вход
      </button>
    </div>
    <div class="row justify-content-md-center align-items-center mt-3">
      <a
        class="btn btn-outline-light" 
        href="/register"
      >
        Зарегистрироваться
      </a>
    </div>
    <!-- /Button switch display login form -->
    <div class="row justify-content-center mt-4">
      <a
        v-if="showForgottenPasswordButton"
        class="btn btn-outline-light"
        href="/password/reset"
      >  
        <!-- @click="clickForgottenPasswordButton" -->
        Забыли пароль?
      </a> 
    </div>
  </div>
</template>

<script>
export default {

  name: 'Login',
  props: {
    token: {
      type: String,
      default: () => {
        return ''
      }
    }
  },
  data() {
    return {
      showLoginForm: false,
        showLoginButton: true,
        showForgottenPasswordButton: false,
        showForgottenPasswordForm: false
    }
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
