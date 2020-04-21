<template>
  <div>
    <v-select
      v-model="selectedTypes"
      :items="items"
      label="Тип музея"
      multiple
      outlined
    ></v-select>
    <input
      v-for="(type, i) in selectedTypes"
      :key="i"
      name="types_list[]"
      type="text"
      :value="type"
    />
  </div>
</template>

<script>
export default {
  name: 'MuseumTypeSelect',
  props: {
    savedTypes: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      items: [
        'Исторический',
        'Художественный',
        'Научно-познавательный',
        'Военно-Исторический',
        'Литературный',
        'Интерактивный',
      ],
      selectedTypes: [],
    }
  },
  mounted() {
    if (this.savedTypes != '') {
      this.selectedTypes = JSON.parse(this.savedTypes)
    }
  },
}
</script>
