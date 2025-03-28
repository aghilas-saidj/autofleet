<template>
  <v-row>
    <v-col cols="12">
      <v-row>
        <!-- Loop through filteredCars -->
        <v-col v-for="(item) in filteredCars" :key="item.car.id" cols="12" md="4"> <!-- Replace 'item.car.id' with your unique identifier -->
          <v-card>
            <v-card-title>{{ item.car.name }}</v-card-title> <!-- Display the car name -->
            <v-card-text>
              <p>Description: {{ item.car.description }}</p> <!-- Display car description -->
              <p>Price per Day: {{ item.car.price_per_day }}</p> <!-- Display price -->
              <p>Type: {{ item.car.type }}</p> <!-- Display type -->
              <p>Seats: {{ item.car.seats }}</p> <!-- Display number of seats -->
              <p>Available From: {{ item.available_from }}</p> <!-- Display availability -->
              <p>Available To: {{ item.available_to }}</p> <!-- Display availability -->
            </v-card-text>
            <v-img :src="getImageUrl(item.car.image_path)" alt="Car Image" height="200px"></v-img>

          
          
          </v-card>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>


<script>

import { ref , computed , onMounted , watch} from 'vue';
import { useStore } from 'vuex';
import { getCars } from '../services/carService';

export default {
  setup() {
    const cars = ref([]);

    const store = useStore();
    const getminprice = computed(() => store.state.minprice);
    const getmaxprice = computed(() => store.state.maxprice);
    const getminseats = computed(() => store.state.minseats);
    const getfrom = computed(() => store.state.from);
    const getto = computed(() => store.state.to);









    const GetCarData = async () => {
        try {
          const response = await getCars({ from: store.state.from, to: store.state.to }); // Pass from and to dates
          cars.value = response; // Store the fetched cars
        } catch (error) {
          console.error("Error fetching cars:", error);
        }
      };
        

      const filteredCars = computed(() => {
    return cars.value.filter(car => {
        return (
            (store.state.minseats === null || store.state.minseats === undefined || isNaN(store.state.minseats) || store.state.minseats === '' || car.car.seats >= store.state.minseats) && // Filter by min seats
            (store.state.minprice === null || store.state.minprice === undefined || isNaN(store.state.minprice) || store.state.minprice === '' || car.car.price_per_day >= store.state.minprice) && // Filter by min price
            (store.state.maxprice === null || store.state.maxprice === undefined || isNaN(store.state.maxprice) || store.state.maxprice === '' || car.car.price_per_day <= store.state.maxprice)&& // Apply max price filter if set
            (store.state.from === null || store.state.from === undefined || isNaN(store.state.from) || store.state.from === '' || car.car.available_from == store.state.from)&& // Apply max price filter if set

            (store.state.to === null || store.state.to === undefined || isNaN(store.state.to) || store.state.to === '' || car.car.available_to == store.state.to) // Apply max price filter if set

        );
    });
});

    // Watch for changes in the 'from' and 'to' dates
    watch([getfrom, getto], async () => {
      await GetCarData(); // Call the API when either date changes
    });
        
     // Fetch cars when the component mounts
     onMounted(async () => {
        await GetCarData(); // Initial fetch of cars
      });

      const getImageUrl = (imagePath) => `http://127.0.0.1:8000/images/${imagePath}`;


  return {
    getminprice,
    getmaxprice,
    getminseats,
    getfrom,
    getto,
    filteredCars,
    getImageUrl
  }
  }
}
</script>