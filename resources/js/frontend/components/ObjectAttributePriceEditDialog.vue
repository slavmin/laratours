<template>
  <v-dialog v-model="dialog">
    <template v-slot:activator="{ on }">
      <v-btn text small color="yellow" dark v-on="on">
        <v-icon>edit</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-title primary-title>
        {{ headerText }}
      </v-card-title>
      <v-card-text>
        <v-form
          :id="`form-${price.id}`"
          :action="`/operator/attribute-price/${price.id}`"
          method="POST"
        >
          <v-row>
            <v-col cols="12" lg="4">
              <v-menu
                v-model="showDateStart"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="dateStart"
                    name="period_start"
                    color="#aa282a"
                    label="Начало периода"
                    :rules="[v => !!v || 'Выберите']"
                    prepend-icon="event"
                    clearable
                    readonly
                    required
                    v-on="on"
                  />
                </template>
                <v-date-picker
                  v-model="dateStart"
                  color="#aa282a"
                  :first-day-of-week="1"
                  locale="ru-ru"
                  @input="showDateStart = false"
                />
              </v-menu>
            </v-col>
            <v-col cols="12" lg="4">
              <v-menu
                v-model="showDateEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                offset-y
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field
                    v-model="dateEnd"
                    name="period_end"
                    color="#aa282a"
                    label="Конец периода"
                    :rules="[v => !!v || 'Выберите']"
                    prepend-icon="event"
                    clearable
                    readonly
                    required
                    v-on="on"
                  />
                </template>
                <v-date-picker
                  v-model="dateEnd"
                  color="#aa282a"
                  :min="dateStart"
                  :first-day-of-week="1"
                  locale="ru-ru"
                  @input="showDateEnd = false"
                />
              </v-menu>
            </v-col>
            <v-col cols="12" lg="4">
              <v-text-field v-model="value" name="price" color="#aa282a" />
            </v-col>
          </v-row>

          <input name="_method" type="hidden" value="PATCH" />
          <input name="_token" type="hidden" :value="token" />
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-btn text color="#aa282a" @click="dialog = false">
          <v-icon>close</v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn
          v-if="value != '' && dateStart != '' && dateEnd != ''"
          :form="`form-${price.id}`"
          type="submit"
          dark
          small
          color="#aa282a"
        >
          Сохранить
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'ObjectAttributePriceEditDialog',
  props: {
    price: {
      type: Object,
      default: () => {},
    },
    token: {
      type: String,
      default: '',
    },
    headerText: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      dialog: false,
      value: 0,
      showDateEnd: false,
      showDateStart: false,
      dateEnd: '',
      dateStart: '',
    }
  },
  mounted() {
    this.value = this.price.price
    this.dateEnd = this.price.period_end
    this.dateStart = this.price.period_start
  },
}
</script>
