<template>
  <v-dialog
    v-model="dialog"
    width="500"
  >
    <template v-slot:activator="{ on }">
      <v-btn
        color="#aa282a"
        dark
        small
        v-on="on"
      >
        Подсказка
      </v-btn>
    </template>

    <v-card>
      <v-card-title
        style="background-color:#66a5ae;"
        class="headline white--text"
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
          Например. Серия: 4605 Hомер: 390089
          <br>
          Заполняется только цифрами: 4605390089
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
          Например. Серия: 52 Hомер: 0022196
          <br>
          Заполняется только цифрами: 520022196
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
          <br>
          Заполняется в свободной форме.
        </p>
      </v-card-text>

      <v-divider />

      <v-card-actions>
        <v-spacer />
        <v-btn
          color="#aa282a"
          dark
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