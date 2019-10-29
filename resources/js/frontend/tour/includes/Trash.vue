<template>
  <v-container>
    <v-toolbar 
      color="#66a5ae"
      dark  
    >
      <v-toolbar-title>
        <v-icon>
          delete
        </v-icon>
        Корзина ({{ items.length }})
      </v-toolbar-title>
      <v-spacer />
      <v-btn 
        color="white"
        fab
        flat
        @click="showContent = !showContent"
      >
        <v-icon>
          expand_{{ showContent ? 'less' : 'more' }}
        </v-icon>
      </v-btn>
    </v-toolbar>
    <v-card
      v-if="showContent"
    >
      <v-data-table
        :items="items"
        class="elevation-1"
        hide-actions
        hide-headers
      >
        <template v-slot:items="props">
          <td>{{ props.item.name }}</td>
          <td class="text-xs-right">
            <v-btn 
              color="green"
              flat
              fab
              outline
              small
              dark
              :href="`/operator/${props.item.model_alias}/${props.item.id}/restore`"
              title="Восстановить"
            >
              <i class="material-icons">
                restore
              </i>
            </v-btn>
            <form 
              :action="`/operator/${props.item.model_alias}/${props.item.id}/delete`"
              method="POST"
            > 
              <input 
                type="hidden"
                name="_method"
                value="DELETE"
              >
              <input 
                type="hidden"
                name="_token"
                :value="token"
              >
              <v-btn 
                color="red"
                flat
                fab
                outline
                small
                dark
                type="submit"
                title="Удалить навсегда"
              >
                <i class="material-icons">
                  delete
                </i>
              </v-btn>
            </form>
          </td>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>
<script>
export default {
  name: 'Trash',
  props: {
    token: {
      type: String,
      default: ''
    },
    items: {
      type: Array,
      default: () => {
        []
      }
    },
  },
  data() {
    return {
      showContent: false,
    }
  },
  mounted() {
    console.log(this.items)
  }
}
</script>