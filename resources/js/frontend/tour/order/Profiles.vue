<template>
  <table>
    <thead>
      <th>
        №
      </th>
      <th>
        Туристов
      </th>
      <th>
        Агент
      </th>
      <th>
        Статус агентства
      </th>
      <th>
        Статус оператора
      </th>
      <th>
        Документы
      </th>
      <th>
        Действия
      </th>
    </thead>
    <tbody>
      <tr
        v-for="order in tour.orders"
        :key="order.id"
      >
        <td>
          {{ order.id }}
        </td>
        <td>
          Туристов: {{ touristsCount(order.profiles[0].content) }}
          <br>
          <i
            v-for="n in touristsCount(order.profiles[0].content)"
            :key="n" 
            class="material-icons body-2"
          >
            accessibility_new
          </i>
          <br>
          <Details 
            :profiles="order.profiles"
            :order-id="order.id"
          />
        </td>
        <td>
          {{ agencies[order.team_id] }}
        </td>
        <td>
          {{ order.profiles[0].content[0].orderStatus }}
        </td>
        <td>
          <span 
            :class="statuses[order.status]"
          >
            {{ statuses[order.status] }}
          </span>
        </td>
        <td>
          <v-btn 
            color="green"
            dark
            @click="getPdf(order)"
          >
            pdf
          </v-btn>
        </td>
        <td>
          <v-layout 
            row 
            wrap
          >
            <v-btn
              :href="'/operator/order/' + order.id + '/edit'"
              color="green"
              dark
              small
              fab
              flat
              outline
            >
              <i class="material-icons">
                edit
              </i>
            </v-btn>
            <form 
              :action="'/operator/order/' + order.id"
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
          </v-layout>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
import pdfMake from "pdfmake/build/pdfmake"
import pdfFonts from "pdfmake/build/vfs_fonts"
pdfMake.vfs = pdfFonts.pdfMake.vfs
import Details from './Details'
export default {
  name: 'Profiles',
  components: {
    Details,
  },
  props: {
    tour: {
      type: Object,
      default: () => {
        return {}
      }
    },
    token: {
      type: String,
      default: ''
    },
    agencies: {
      type: Object,
      default: () => {
        return {}
      }
    },
    statuses: {
      type: Array,
      default: () => {
        return []
      }
    },
    tourNames: {
      type: Object,
      default: () => {
        return []
      }
    },
  },
  data() {
    return {}
  },
  mounted() {
  },
  methods: {
    touristsCount(content) {
      let count = 0
      for (let key in content) {
        count += 1
      }
      return count
    },
    getPdf(order) {
      console.log(order)
      let dd = {
        content: [
          order.profiles[0].content[0].first_name,
          order.profiles[0].content[0].last_name,
        ]   
      }
      pdfMake.createPdf(dd).open();
    },
  },
}
</script>
<style lang="scss" scoped>
table {
  td,
  th {
    border: 1px solid #d6d6d6;
    font-size: 16px;
    padding: 12px;
  }
}
span {
  &.pending {
    display: block;
    background-color: #FDD835;
    padding: 6px;
    border-radius: 6px;
    color: white;
  }
}  
</style>