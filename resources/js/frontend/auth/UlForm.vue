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
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.country"
          label="Страна"
          name="profile[formal][company_country]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.region"
          label="Регион"
          name="profile[formal][company_city]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.address"
          label="Юридический адрес"
          name="profile[formal][company_address]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.ogrn"
          label="ОГРН"
          mask="##########"
          name="profile[formal][company_ogrn]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.inn"
          label="ИНН"
          mask="##########"
          name="profile[formal][company_inn]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.kpp"
          label="КПП"
          mask="#########"
          name="profile[formal][company_kpp]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.bik"
          label="БИК"
          mask="####################"
          name="profile[formal][company_bik]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.okved"
          label="ОКВЭД"
          mask="##########"
          name="profile[formal][company_okved]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.company_email"
          label="E-mail организации"
          name="profile[formal][company_email]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.bankname"
          label="Полное наименование банка"
          name="profile[formal][company_bankname]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.bankaccount"
          label="Расчётный счёт"
          mask="####################"
          name="profile[formal][company_bankaccount]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.bankcorr"
          label="Корреспондентский счет банка"
          mask="####################"
          name="profile[formal][company_bankcorr]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.bankkpp"
          label="КПП"
          mask="#########"
          name="profile[formal][company_bankkpp]"
          color="#aa282a lighten-3"
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
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.staffSurname"
          label="Фамилия"
          name="last_name"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.phone"
          label="Телефон"
          placeholder="+7"
          name="profile[formal][company_phone]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          mask="+N (NNN) NNN-NN-NN"
          required
        />
        <v-text-field
          v-model="companyInfo.ceoName"
          label="ФИО генерального"
          name="profile[formal][company_ceo_name]"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <v-text-field
          v-model="companyInfo.email"
          label="E-mail. Будет использоваться для входа в систему"
          name="email"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
        />
        <span
          v-if="tooltip"
          class="body-1 grey--text"
        >
          Минимум 8 символов, заглавные, строчные буквы, и цифры.
        </span>
        <v-text-field
          v-model="companyInfo.password"
          label="Пароль"
          name="password"
          type="password"
          color="#aa282a lighten-3"
          :rules="[v => !!v || 'Это обязательное поле']"
          outline
          required
          @input="tooltip = true"
        />
        <v-text-field
          v-model="companyInfo.password_confirmation"
          label="Подтверждение пароля"
          name="password_confirmation"
          :color="!error ? '#aa282a lighten-3' : 'red'"
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
      tooltip: false,
    }
  },
  computed: {
    error: function() {
      if (this.companyInfo.password != this.companyInfo.password_confirmation) {
        return true
      }
      return false
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
        'profile[formal][company_ogrn]': d.ogrn,
        'profile[formal][company_inn]': d.inn,
        'profile[formal][company_kpp]': d.kpp,
        'profile[formal][company_okved]': d.okved,
        'profile[formal][company_bik]': d.bik,
        'profile[formal][company_ceo_name]': d.ceoName,
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
