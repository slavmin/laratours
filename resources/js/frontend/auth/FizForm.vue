<template>
  <form
    action="/register"
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
          name=""
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.surname"
          label="Фамилия"
          name=""
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.country"
          label="Страна"
          name=""
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.region"
          label="Город"
          name=""
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.address"
          label="Адрес"
          name=""
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
      </v-flex>
      <v-flex xs5>
        <v-text-field
          v-model="user.phone"
          label="Телефон. Знаки +, ( ), - добавляются автоматически"
          placeholder="+7"
          name=""
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          mask="+7 (###) ###-##-##"
          required
        />
        <v-text-field
          v-model="user.email"
          label="E-mail. Будет использоваться для входа в систему"
          name="email"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="user.password"
          label="Пароль"
          name="password"
          type="password"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          label="Подтверждение пароля"
          name="password_confirmation"
          color="green lighten-3"
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
            color="green"
            class="white--text"
            type="submit"
            disabled
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
