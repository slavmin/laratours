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
          v-model="companyInfo.name"
          label="Название организации"
          name="profile[formal][company_name]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.country"
          label="Страна"
          name="profile[formal][company_country]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.region"
          label="Регион"
          name="profile[formal][company_city]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.address"
          label="Юридический адрес"
          name="profile[formal][company_address]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.inn"
          label="ИНН"
          mask="##########"
          name="profile[formal][company_inn]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.kpp"
          label="КПП"
          name="profile[formal][company_kpp]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.company_email"
          label="E-mail организации"
          name="profile[formal][company_email]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
      </v-flex>
      <v-flex xs5>
        <v-text-field
          v-model="companyInfo.staffName"
          label="Имя"
          name="first_name"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.staffSurname"
          label="Фамилия"
          name="last_name"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.phone"
          label="Телефон. Знаки +, ( ), - добавляются автоматически"
          placeholder="+7"
          name="profile[formal][company_phone]"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          mask="+7 (###) ###-##-##"
          required
        />
        <v-text-field
          v-model="companyInfo.email"
          label="E-mail. Будет использоваться для входа в систему"
          name="email"
          color="green lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.password"
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
          >
            Зарегистрироваться
          </v-btn>  
        </v-layout>
      </v-flex>
    </v-layout>
  </form>
</template>

<script>
export default {
  name: 'UlForm',
  props: {
    token: {
      type: String,
      default: ''
    },
    companyInfo: {
      type: Object,
      default: () => {
        return {
        }
      }
    },
  },
  data() {
    return {
    }
  },
  methods: {
    register() {
      const d = this.companyInfo
      const data = {
        '_token': this.token,
        'profile[formal][company_name]': d.name,
        'profile[formal][company_phone]': d.phone,
        'profile[formal][company_email]': d.email,
        'profile[formal][company_country]': d.country,
        'profile[formal][company_city]': d.region,
        'profile[formal][company_address]': d.address,
        'profile[formal][company_inn]': d.inn,
        'profile[formal][company_kpp]': d.kpp,
        'first_name': d.staffName,
        'last_name': d.staffSurname,
        'email': d.email,
        'password': d.password,
        'password_confirmation': d.password,
      }
      axios.post('/register', data)
        .then(r => console.log(r))
        .catch(e => console.log(e))
      console.log(this.companyInfo)
      console.log(data)
    }
  }
}
</script>

<style>

</style>
