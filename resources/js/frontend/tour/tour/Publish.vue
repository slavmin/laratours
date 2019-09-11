<template>
  <form 
    :action="'/operator/tour/' + tour.id"
    method="POST"
  >
    <input 
      type="hidden"
      name="_method"
      value="PATCH"
    >
    <input 
      type="hidden"
      name="_token"
      :value="token"
    >
    <input 
      type="hidden"
      name="name"
      :value="tour.name"
    >
    <!-- <input 
      type="hidden"
      name="city_id"
      :value="tour.city_id"
    > -->
    <input 
      type="hidden"
      name="tour_type_id"
      :value="tour.tour_type_id"
    >
    <input 
      type="hidden"
      name="cities_list[]"
      :value="tour.cities_list"
    >
    <input
      type="hidden"
      name="published"
      :value="published"
    >
    <v-btn 
      v-if="!tour.published"
      color="green"
      flat
      fab
      outline
      small
      dark
      type="submit"
    >
      <i 
        class="material-icons"
        title="Опубликовать"
      >
        publish
      </i>
    </v-btn>
    <v-btn 
      v-if="tour.published"
      color="orange"
      flat
      fab
      outline
      small
      dark
      type="submit"
    >
      <i 
        class="material-icons rotate-180"
        title="Снять с публикации"
      >
        publish
      </i>
    </v-btn>
  </form>
</template>
<script>
export default {
  name: 'PublishTour',
  props: {
    token: {
      type: String,
      default: ''
    },
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    }
  },
  data() {
    return {}
  },
  computed: {
    published: function() {
      if (this.tour.published) {
        return 0
      }
      else {
        return 1
      }
    }
  },
  mounted() {
    console.log(this.token, this.tour)
  }
}
</script>
<style lang="scss" scoped>
.rotate-180 {
  transform: rotate(180deg);
}  
</style>