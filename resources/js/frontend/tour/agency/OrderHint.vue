<template>
  <v-dialog
    v-model="dialog"
    width="500"
  >
    <template v-slot:activator="{ on }">
      <v-btn
        color="white"
        flat
        small
        v-on="on"
      >
        Подсказка
      </v-btn>
    </template>

    <v-card>
      <v-card-title
        class="headline green white--text"
        primary-title
      >
        Правила заполнения
      </v-card-title>

      <v-card-text class="body-1">
        <h4 class="subheading">
          Паспорт гражданина РФ
        </h4>
        <p>
          <span class="body-2">Серия:</span> четыре цифры (без пробелов) 
        </p>
        <p>
          <span class="body-2">Hомер:</span> шесть цифр (без знака "№") 
        </p> 
        <p>
          Например. Серия: 1234 Hомер: 123456
        </p>
        <v-divider />

        <h4 class="subheading">
          Загранпаспорт гражданина РФ
        </h4>
        <p>
          <span class="body-2">Серия:</span> две цифры 
        </p>
        <p>
          <span class="body-2">Hомер:</span> семь цифр (без знака "№")
        </p> 
        <p>
          Например. Серия: 12 Hомер: 1234567
        </p>
        <v-divider />

        <h4 class="subheading">
          Свидетельство о рождении, выданное в РФ
        </h4>
        <p>
          <span class="body-2">Серия:</span> римские цифры (латинскими заглавными буквами) тире (без пробелов) две заглавные буквы кириллицей 
        </p>
        <p>
          <span class="body-2">Hомер:</span> шесть цифр (без знака "№")
        </p> 
        <p>
          Например. Серия: VII-МЮ Hомер: 123456
        </p>
      </v-card-text>

      <v-divider />

      <v-card-actions>
        <v-spacer />
        <v-btn
          color="green"
          flat
          @click="dialog = false"
        >
          Закрыть
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
    }
  },
}
</script>