<template>
  <v-container grid-list-xs>
    <h4>Цена</h4>
    {{ eventId }}
    <form
      action="/operator/attribute-price"
      method="POST"
    >
      <input
        type="hidden"
        name="_token"
        :value="token"
      >
      <input
        type="text"
        name="attribute_id"
        :value="eventId"
      >
      <v-btn
        color="yellow"
        type="submit"
      >
        send
      </v-btn>
    </form>
  </v-container>
</template>
<script>
export default {
  name: 'MuseumPrice',
  props: {
    eventId: {
      type: Number,
      default: 0,
    },
    token: {
      type: String,
      required: true,
      default: null,
    },
  },
}
</script>