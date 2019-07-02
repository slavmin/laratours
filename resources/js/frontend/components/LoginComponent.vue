<template>
    <div>
        <!-- Login form -->
    	<div 
            class="row justify-content-center align-items-center"
            v-if="showLoginForm"
        >
    		<form method="POST" action="/login">
                <input type="hidden" name="_token" :value="token">
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1" checked>
                    <label class="form-check-label text-white" for="exampleCheck1">Запомнить</label>
                </div>
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-light">Войти</button> 
                </div>
            </form>
    	</div>
        <!-- /Login form -->
        <!-- Forgotten password form -->
        <div
            class="row justify-content-center align-items-center" 
            v-if="showForgottenPasswordForm"
        >
            <form method="POST" action="/password/email">
                <input type="hidden" name="_token" :value="token">
                <div class="form-group">
                    <div class="row justify-content-center">
                        <p class="text-white">Восстановление пароля</p>
                    </div>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
                </div> 
                <div class="row justify-content-center">
                    <button type="submit" class="btn btn-outline-light">Отправить</button> 
                </div> 
            </form>       
        </div> 
        <!-- /Forgotten password form -->
        <!-- Button switch display login form -->
    	<div class="row justify-content-md-center align-items-center">
    		<button 
                type="button" 
                class="btn btn-outline-light"
                v-if="showLoginButton"
                v-on:click="clickLoginButton"
            >
                Вход
            </button>
    	</div>
        <!-- /Button switch display login form -->
        <div class="row justify-content-center mt-4">
            <button 
                type="button"
                class="btn btn-outline-light"
                v-if="showForgottenPasswordButton"
                v-on:click="clickForgottenPasswordButton"
            >
                Забыли пароль?
            </button> 
        </div>
    </div>
</template>

<script>
export default {

  name: 'Login',
  props: ['token'],
  data() {
    return {
    	showLoginForm: false,
        showLoginButton: true,
        showForgottenPasswordButton: false,
        showForgottenPasswordForm: false
    }
  },
  mounted() {
    // this.sayHello()
  },
  methods: {
    sayHello() {
        console.log('hello from methods!')
    },
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
}
.fullscreen-bg {
	background-color: #333;
	width: 100%;
	height: 100%;
	background: url('/img/frontend/bg-bridge.jpg') center center no-repeat;
	background-size: cover;
    z-index: 1;
	> .row {
		width: 100%;
		height: 100%;
        z-index: 10;
        position: relative;
	}
    &:before {
        display: block;
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: linear-gradient(to top,#000,rgba(0,0,0,.17));
        opacity: .7;
    }
}
.slogan {
	font-family: 'Merriweather', serif;
    text-align: center;
}
</style>
