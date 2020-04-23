<template>
  <v-dialog v-model="dialog" width="200">
    <template v-slot:activator="{ on }">
      <v-btn text small color="yellow" dark v-on="on">
        <v-icon>edit</v-icon>
      </v-btn>
    </template>
    <v-card>
      <v-card-text>
        <v-form
          :id="`form-${price.id}`"
          :action="`/operator/attribute-price/${price.id}`"
          method="POST"
        >
          <input name="_method" type="hidden" value="PATCH" />
          <input name="_token" type="hidden" :value="token" />
          <v-text-field v-model="value" name="price" color="#aa282a" />
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-btn text color="#aa282a" @click="dialog = false">
          <v-icon>close</v-icon>
        </v-btn>
        <v-spacer></v-spacer>
        <v-btn
          v-if="value != ''"
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
  },
  data() {
    return {
      dialog: false,
      value: 0,
    }
  },
  mounted() {
    this.value = this.price.price
  },
}
</script>

<style>
</style>