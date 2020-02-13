<template>
  <v-tooltip right>
    <template v-slot:activator="{ on }">
      <v-btn
        icon
        v-on="on"
      >
        <svg
          style="width:24px;height:24px"
          viewBox="0 0 24 24"
        >
          <path
            fill="currentColor"
            d="M5,6H23V18H5V6M14,9A3,3 0 0,1 17,12A3,3 0 0,1 14,15A3,3 0 0,1 11,12A3,3 0 0,1 14,9M9,8A2,2 0 0,1 7,10V14A2,2 0 0,1 9,16H19A2,2 0 0,1 21,14V10A2,2 0 0,1 19,8H9M1,10H3V20H19V22H1V10Z"
          />
        </svg>
      </v-btn>
    </template>
    <span>
      <!-- @foreach($event->priceable as $price)
      Период: {{ $price->period_start }} - {{ $price->period_end }}
      <hr>
      {{ $customer_type_options[$price->tour_customer_type_id] }}:
      {{ $price->price }}
      <br>
      @endforeach -->
      test
    </span>
  </v-tooltip>
</template>
<script>
export default {
  name: 'ObjectAttributesTooltipPrices',
  props: {
    prices: {
      type: String,
      default: '',
    },
  },
  mounted() {
    console.log(this.prices)
  },
}
</script>