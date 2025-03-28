<template>


      <v-row>
       <v-col cols="12">
        <c-card>
          <v-card-title>
            Filter
          </v-card-title>

          <v-card-text>
          <v-form></v-form>
          </v-card-text>

        </c-card>
        </v-col>
      </v-row>

</template>

<script>
import { ref, watch } from 'vue';
import { useStore } from 'vuex';

export default {
  setup() {
    const minprice = ref(null);
    const maxprice = ref(null);
    const minseats = ref(null);
    const from = ref(null); // Date input
    const to = ref(null); // Date input

    const store = useStore(); // Access the Vuex store

    watch(minprice, (newValue) => {
      const price = parseFloat(newValue);
      if (!isNaN(price)) {
        store.dispatch('updateMinPrice', price); // Dispatch action to update price
      } else {
        store.dispatch('updateMinPrice', null); // Clear value in Vuex store
      }
    });

    watch(maxprice, (newValue) => {
      const price = parseFloat(newValue);
      if (!isNaN(price)) {
        store.dispatch('updateMaxPrice', price); // Dispatch action to update price
      } else {
        store.dispatch('updateMaxPrice', null); // Clear value in Vuex store
      }
    });

    watch(minseats, (newValue) => {
      const seats = parseFloat(newValue);
      if (!isNaN(seats)) {
        store.dispatch('updateMinSeats', seats); // Dispatch action to update seats
      } else {
        store.dispatch('updateMinSeats', null); // Clear value in Vuex store
      }
    });

    // Watch for date changes and dispatch them to the store
    watch(from, (newValue) => {
      store.dispatch('updateFrom', newValue || null); // Send null if input is cleared
    });

    watch(to, (newValue) => {
      store.dispatch('updateTo', newValue || null); // Send null if input is cleared
    });

    return {
      minprice,
      maxprice,
      minseats,
      from,
      to,
    };
  },
};
</script>
