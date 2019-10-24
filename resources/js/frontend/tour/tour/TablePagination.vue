<template>
  <div class="text-xs-center pt-2">
    {{ `${items.from}-${items.to} / ${items.total}` }}
    <v-pagination 
      v-model="items.current_page" 
      color="green"
      :length="items.last_page"
      :total-visible="7"
      @input="changePage"
      @next="nextPage"
      @previous="prevPage"
    />
  </div>
</template>
<script>
export default {
  name: 'TablePagination',
  props: {
    items: {
      type: Object,
      default: () => {
        return {}
      }
    },
  },
  data() {
    return {
      key: 'value'
    }
  },
  methods: {
    changePage(value) {
      document.location.href = this.items.path + `/?page=${value}`
    },
    nextPage() {
      document.location.href = this.items.next_page_url
    },
    prevPage() {
      document.location.href = this.items.prev_page_url
    }
  }
}
</script>