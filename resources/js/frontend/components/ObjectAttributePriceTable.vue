<template>
  <tbody>
    <tr
      v-for="(price, i) in prices"
      v-show="i == 0 || (i > 0 && showAll)"
      :key="price.id"
    >
      <td>
        {{ price.period_start }}
      </td>
      <td>
        {{ price.period_end }}
      </td>
      <td>
        <div v-if="objectModel != 'transport'" class="d-inline">
          {{ customers[price.tour_customer_type_id] }}
        </div>
        <div v-if="objectModel == 'transport'" class="d-inline">
          {{ priceTypesForView[price.tour_price_type_id] }}
        </div>
        <div v-if="i == 0 && prices.length > 1" class="d-inline">
          <v-btn
            text
            :class="showAll ? 'red--text' : 'green--text'"
            @click="showAll = !showAll"
          >
            <v-icon> expand_{{ showAll ? 'less' : 'more' }} </v-icon>
            ({{ prices.length - 1 }})
          </v-btn>
        </div>
      </td>
      <td v-if="objectModel == 'hotel'">
        {{ price.accom_type }}
      </td>
      <td>
        {{ price.price }}
      </td>
      <td>
        <v-row>
          <EditPrice
            :price="price"
            :header-text="
              objectModel == 'transport'
                ? priceTypesForView[price.tour_price_type_id]
                : customers[price.tour_customer_type_id]
            "
            :token="token"
          />
          <form method="POST" :action="`/operator/attribute-price/${price.id}`">
            <input type="hidden" name="_method" value="DELETE" />
            <input type="hidden" name="_token" :value="token" />
            <v-btn icon small color="red" type="submit" title="Удалить">
              <v-icon>close</v-icon>
            </v-btn>
          </form>
        </v-row>
      </td>
    </tr>
  </tbody>
</template>

<script>
import EditPrice from './ObjectAttributePriceEditDialog'
export default {
  name: 'ObjectATtributePriceTable',
  components: { EditPrice },
  props: {
    prices: {
      type: Array,
      default: () => [],
    },
    customers: {
      type: Object,
      default: () => {},
    },
    priceTypesForView: {
      type: Object,
      default: () => {},
    },
    objectModel: {
      type: String,
      default: '',
    },
    token: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      showAll: false,
    }
  },
}
</script>

<style scoped>
tr:last-child {
  border-bottom: 2px solid black;
}
</style>