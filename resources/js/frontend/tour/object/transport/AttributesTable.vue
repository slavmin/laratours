<template>
  <v-data-table
    :headers="headers"
    :items="transportAttributes"
    class="elevation-1"
    rows-per-page-text="На странице:"
  >
    <template v-slot:items="props">
      <td class="text-xs-left">
        {{ props.item.name }}
      </td>
      <td class="text-xs-center">
        {{ JSON.parse(props.item.extra).scheme.totalPassengersCount }}
      </td>
      <td class="text-xs-center">
        <v-layout
          v-for="(grade, i) in getExtraProperty(props.item.extra, 'grade')"
          :key="i"
          row
          justify-center
          wrap
          my-1
        >
          <span class="grey--text text--darken-1">
            {{ grade }}
          </span>
        </v-layout>
      </td>
      <td class="text-xs-center">
        <v-layout
          v-for="(price, i) in getExtraProperty(props.item.extra, 'prices')"
          :key="i"
          row
          justify-content-between
          wrap
          my-1
        >
          <span class="grey--text text--darken-1">
            {{ price.name }}: 
          </span>
          <div>
            {{ price.value }}
          </div>
        </v-layout>
      </td>
      <td style="max-width: 300px;">
        {{ props.item.description }}
      </td>
      <td class="text-xs-center">
        <v-layout 
          row 
          wrap
          justify-center
        >
          <!-- <Edit 
            :edit-item="props.item" 
            :company-id="companyId"
            :edit="true"
            :token="token"
          /> -->
          <EditObjectables
            :item="props.item" 
            :company-id="companyId"
            :token="token"
          />
          <!-- <Scheme
            :id="props.item.id" 
            :object="props.item"
            :company-id="companyId"
            :token="token"
          /> -->
          <form 
            :action="'/operator/attribute/' + props.item.id"
            method="POST"
          >
            <input 
              id="_method" 
              type="hidden" 
              name="_method" 
              value="DELETE"
            >
            <input 
              type="hidden" 
              name="_token" 
              :value="token"
            > 
            <input 
              type="hidden" 
              name="parent_model_id" 
              :value="companyId"
            >
            <input 
              type="hidden" 
              name="parent_model_alias" 
              value="transport"
            >  
            <v-btn 
              fab
              small
              outline
              color="red"
              type="submit"
            >
              <i class="material-icons">
                delete
              </i>
            </v-btn>
          </form>
          <!-- <v-btn
            color="red"
            fab
            small
            outline
            flat
            dark
            @click="del(props.item.id)"
          >
            <i class="far fa-trash-alt" />
          </v-btn> -->
        </v-layout>
      </td>
    </template>
  </v-data-table>
</template>

<script>
// import Scheme from './Scheme'
// import Edit from './AddEdit'
import EditObjectables from './EditObjectables'
export default {

  name: 'AttributesTable',
  components: {
    // Scheme,
    // Edit
    EditObjectables
  },
  props: {
    transportAttributes: {
      type: Array,
      default: () => {
        return {}
      }
    },
    companyId: {
      type: Number,
      default: 0
    },
    token: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      headers: [
        {
          text: 'Название',
          align: 'left',
          value: 'name'
        },
        {
          text: 'Вместимость',
          align: 'center',
          value: 'qnt'
        },
        {
          text: 'Класс',
          align: 'center',
          value: 'grade'
        },
        {
          text: 'Цены',
          align: 'center',
          value: 'price'
        },
        {
          text: 'Описание',
          align: 'center',
          value: 'description'
        },
        {
          text: 'Действия',
          align: 'center',
          value: 'description'
        },
      ],
    };
  },
  methods: {
    getExtraProperty(extra, property) {
      let data = JSON.parse(extra)
      if (data != null) {
        return data[property]
      }
    }
  }
};
</script>

<style lang="css" scoped>
</style>
