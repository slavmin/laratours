<template>
  <form
    action="/signup"
    method="POST"
  >
    <v-layout
      row
      wrap
      justify-space-between
    >
      <v-flex xs5>
        <v-text-field
          v-model="user.name"
          label="Имя"
          name="first_name"
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.surname"
          label="Фамилия"
          name="last_name"
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.country"
          label="Страна"
          name=""
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
        />
        <v-text-field
          v-model="user.region"
          label="Город"
          name=""
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
        />
        <v-text-field
          v-model="user.address"
          label="Адрес"
          name=""
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
        />
      </v-flex>
      <v-flex xs5>
        <v-text-field
          v-model="user.phone"
          label="Телефон. Знаки +, ( ), - добавляются автоматически"
          placeholder="+7"
          name=""
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          mask="+7 (###) ###-##-##"
          required
        />
        <v-text-field
          v-model="user.email"
          label="E-mail. Будет использоваться для входа в систему"
          name="email"
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.password"
          label="Пароль"
          name="password"
          type="password"
          color="#aa282a"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          label="Подтверждение пароля"
          name="password_confirmation"
          color="#aa282a"
          type="password"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-layout 
          row 
          wrap
          justify-end
        >
          <input
            v-model="token"
            type="hidden"
            name="_token"
          >
          <v-btn 
            color="#aa282a"
            class="white--text"
            type="submit"
          >
            Зарегистрироваться
          </v-btn>  
          * в данный момент регистрация физ.лиц недоступна
        </v-layout>
      </v-flex>
    </v-layout>
  </form>
</template>

<script>
export default {
  name: 'FizForm',
  props: {
    token: {
      type: String,
      default: ''
    },
  },
  data() {
    return {
      user: {},
    }
  },
}
</script>

<style>

</style>
