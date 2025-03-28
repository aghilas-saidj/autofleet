<template>
  <div>
    <div
      v-if="loading"
      style="display: flex; justify-content: center; align-items: center; height: 100vh"
    >
      <div
        style="
          padding: 20px;
          text-align: center;
          display: flex;
          justify-content: center;
          align-items: center;
        "
      >
        <div>
          <ProgressBar />
        </div>
      </div>
    </div>
    <div
      v-if="filteredCars.length === 0 && !loading"
      class="notification is-warning has-text-centered mt-5"
    >
      No available cars found for your search criteria.
    </div>

    <div class="notification is-danger has-text-centered mt-5" v-if="selectedPastDates">
      The selected pickup date and time is in the past.
    </div>

    <div
      class="notification is-danger has-text-centered mt-5"
      v-if="selectedpickupAfterDropoff"
    >
      The dropoff time must be after the pickup time.
    </div>

    <div v-for="(item, index) in PaginatedCars" :key="index">
      <div class="card is-flex">
        <div class="card-content">
          <div class="columns is-flex">
            <!-- Image Section -->
            <div class="column is-5-mobile is-3-tablet is-3-desktop">
              <figure class="image is-256x256">
                <img
                  :src="`https://carrentalsystemimages.s3.eu-north-1.amazonaws.com/${item.car.image_path}`"
                />
              </figure>

              <span
                class="tag is-link is-light has-text-weight-bold"
                style="color: #3e8ed0"
                >{{ item.car.transmission }}</span
              >
              <span
                class="tag is-primary is-light has-text-weight-bold"
                style="color: #3e8ed0"
                >{{ item.car.type }}</span
              >
              <!-- <p class="subtitle is-6  has-text-weight-bold"  style=" color: #3e8ed0;">⭐⭐⭐☆☆</p> -->
            </div>

            <!-- Details Section -->
            <div class="column is-7-mobile is-9-tablet is-9-desktop">
              <p
                class="title is-6 has-text-weight-bold"
                style="display: flex; align-items: center; color: #4a4a4a !important"
              >
                {{ item.car.name }}
              </p>

              <div class="columns">
                <div
                  class="column is-12-mobile is-6-tablet is-6-desktop"
                  style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                    gap: 0.5rem;
                  "
                >
                  <div>
                    <div>
                      <p
                        class="subtitle is-size-7 has-text-weight-bold"
                        style="
                          display: flex;
                          align-items: center;
                          color: #4a4a4a !important;
                        "
                      >
                        <font-awesome-icon icon="suitcase" style="margin-right: 0.5rem" />
                        {{ item.car.bags }} bag(s)
                      </p>

                      <p
                        class="subtitle is-size-7 has-text-weight-bold"
                        style="
                          display: flex;
                          align-items: center;
                          color: #4a4a4a !important;
                        "
                      >
                        <font-awesome-icon
                          icon="door-open"
                          style="margin-right: 0.5rem"
                        />{{ item.car.doors }} doors
                      </p>

                      <p
                        class="subtitle is-size-7 has-text-weight-bold"
                        style="
                          display: flex;
                          align-items: center;
                          color: #4a4a4a !important;
                        "
                      >
                        <font-awesome-icon icon="user" style="margin-right: 0.5rem" />
                        {{ item.car.seats }} seats
                      </p>
                    </div>
                  </div>
                </div>

                <div
                  class="column is-6 is-hidden-mobile"
                  style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                  "
                >
                  <div>
                    <p
                      v-if="item.car.airconditioning === 1"
                      class="subtitle is-size-7 has-text-weight-bold"
                      style="
                        display: flex;
                        align-items: center;
                        color: #4a4a4a !important;
                      "
                    >
                      <font-awesome-icon icon="fan" style="margin-right: 0.5rem" />
                      Air Conditioning
                    </p>

                    <p
                      class="subtitle is-size-7 has-text-weight-bold"
                      style="
                        display: flex;
                        align-items: center;
                        color: #4a4a4a !important;
                      "
                    >
                      <font-awesome-icon icon="cogs" style="margin-right: 0.5rem" />
                      {{ item.car.engine_type }}
                    </p>

                    <p
                      v-if="item.car.is_unlimited_mileage === 1"
                      class="subtitle is-size-7 has-text-weight-bold"
                      style="
                        display: flex;
                        align-items: center;
                        color: #4a4a4a !important;
                      "
                    >
                      <font-awesome-icon icon="road" style="margin-right: 0.5rem" />
                      Unlimited Mileage
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr style="background-color: #f5f5f5 !important" />

          <div class="columns is-flex">
            <div class="column is-9">
              <p
                class="subtitle is-7 has-text-weight-bold"
                style="color: #363636 !important"
              >
                Price per day:
              </p>
              <p class="title is-4" style="color: #363636 !important">
                ${{ item.car.price_per_day }}
              </p>
            </div>

            <!-- Button Column -->
            <div class="column is-3 is-flex is-justify-content-flex-end">
              <router-link
                :to="`/car/${item.car.id}`"
                class="button is-primary has-text-weight-bold has-text-white"
                >View details</router-link
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <button class="button is-small mr-2" @click="prevPage" :disabled="slicestart <= 0">
      Previous
    </button>

    <button class="button is-small" @click="nextPage" :disabled="sliceend >= cars.length">
      Next
    </button>
  </div>
</template>

<script>
import { ref, onMounted, computed, watch } from "vue";
import axios from "axios"; // Make sure axios is imported
import { useStore } from "vuex";
import config from "@/config";

import ProgressBar from "@/components/ProgressBar.vue";

export default {
  components: {
    ProgressBar,
  },

  setup() {
    // start initial values of the filter
    const store = useStore();

    const carType = computed(() => store.state.filter.carType);
    const priceRange = computed(() => store.state.filter.priceRange);
    const seats = computed(() => store.state.filter.seats);
    const bags = computed(() => store.state.filter.bags);
    const doors = computed(() => store.state.filter.doors);
    const engineType = computed(() => store.state.filter.engineType);

    const slicestart = ref(0);
    const sliceend = ref(5);

    const carTypes = ref([]);
    const engineTypes = ref([]);

    const dateErrorMessage = ref(false);
    const urlChanged = ref(false);

    const pickupLocation = computed(() => store.state.search.pickupLocation);
    const pickupDate = computed(() => store.state.search.pickupDate);
    const pickupTime = computed(() => store.state.search.pickupTime);
    const dropoffLocation = computed(() => store.state.search.dropoffLocation);
    const dropoffDate = computed(() => store.state.search.dropoffDate);
    const dropoffTime = computed(() => store.state.search.dropoffTime);

    const emptyResult = ref(false);
    const showSearchSection = ref(false);
    const showNotification = ref(false);
    const cars = ref([]); // For storing the fetched cars

    const selectedPastDates = ref(false);
    const selectedpickupAfterDropoff = ref(false);
    const loading = ref(true);

    const fetchCars = async () => {
      /////START VERIFICATION :: Verify if the selected dates/times are correct
      ////example :: if the user selected date in the past or selected date of picjup after dropoff

      // Assuming pickupDate.value, pickupTime.value, dropoffDate.value, and dropoffTime.value are strings
      const pickupDateTime = `${pickupDate.value} ${pickupTime.value}`;
      const dropoffDateTime = `${dropoffDate.value} ${dropoffTime.value}`;

      // Convert the pickupDateTime and dropoffDateTime into JavaScript Date objects
      const pickupDateObj = new Date(pickupDateTime);
      const dropoffDateObj = new Date(dropoffDateTime);

      // Get the current date and time
      const currentDateTime = new Date();

      // Check if the pickup date is in the past
      if (pickupDateObj < currentDateTime) {
        // console.log("The selected pickup date and time is in the past.");
        selectedPastDates.value = true;
        loading.value = false;
        cars.value = [];
        return;
        // You can handle this error or return a message as needed
      }
      // Check if dropoff is before pickup
      else if (dropoffDateObj <= pickupDateObj) {
        //  console.log("The dropoff time must be after the pickup time.");
        selectedpickupAfterDropoff.value = true;
        loading.value = false;
        cars.value = [];
        return;
        // You can handle this error or return a message as needed
      } else {
        selectedPastDates.value = false;
        selectedpickupAfterDropoff.value = false;

        //console.log("The selected pickup and dropoff times are valid.");
      }

      /////END VERIFICATION

      /////////////////////////////////////////////////////////
      ///////////////////////////////////////////////////
      try {
        let apiUrl = "";
        const token = localStorage.getItem("token"); // Get the token from localStorage

        // Check if the user is authenticated
        if (localStorage.getItem("Authentication_status") === "true") {
          // If authenticated, use the authenticated API
          apiUrl = `${config.API_BASE_URL}/cars`;
          dateErrorMessage.value = false;
        } else {
          // If not authenticated, use the guest API
          apiUrl = `${config.API_BASE_URL}/guest/cars`;

          urlChanged.value = true;
          dateErrorMessage.value = false;
        }

        //////////////////////////////////////////////////////
        ///////////////////////START FETCHING DATA /////////////////

        // Make the API request
        const response = await axios.get(apiUrl, {
          headers: token ? { Authorization: `Bearer ${token}` } : {}, // Add token if it exists
          params: {
            from: `${pickupDate.value} ${pickupTime.value}`,
            to: `${dropoffDate.value} ${dropoffTime.value}`,
            pickup: pickupLocation.value,
            dropoff: dropoffLocation.value,
          },
        });

        if (Array.isArray(response.data) && response.data.length === 0) {
          emptyResult.value = true;
          showSearchSection.value = true;
        }
        // Set the fetched car data
        cars.value = response.data;

        // Loop through the response data and extract unique car types and engine types
        response.data.forEach((car) => {
          // Push the car type to carTypes array if it isn't already in the array
          if (!carTypes.value.includes(car.car.type)) {
            carTypes.value.push(car.car.type);
          }

          // Push the engine type to engineTypes array if it isn't already in the array
          if (!engineTypes.value.includes(car.car.engine_type)) {
            engineTypes.value.push(car.car.engine_type);
          }
        });

        // Commit the values to Vuex
        store.commit("filter/SET_CAR_TYPES", carTypes.value);
        store.commit("filter/SET_ENGINE_TYPES", engineTypes.value);
      } catch (error) {
        localStorage.setItem("Authentication_status", "false");
        if (!urlChanged.value) {
          fetchCars();
        } else {
          showNotification.value = false;
          showSearchSection.value = true;
          dateErrorMessage.value = true;
        }

        cars.value = [];
      } finally {
        loading.value = false; // Stop loading
      }
    };

    ///////////////////////////////////////////////////////////////////
    ///////////////////////////END FETCHING DATA///////////////////////////////////

    // Watch all relevant Vuex state values
    //////////////////iN CASE THERE IS ANY CHANGE IN THE SEARCHING PARAMETERS , VUEX WILL BE UPDATED INSTANTLY
    watch(
      [pickupLocation, pickupDate, pickupTime, dropoffLocation, dropoffDate, dropoffTime],
      () => {
        loading.value = true;
        fetchCars();
      }
    );

    //////////////////////////////////////////////////////////
    //////////////////////////FILTER THE DATA ////////////////
    ////NOTE ::  By default, there is a applied filter, defined in vuex modules filter

    const filteredCars = computed(() => {
      return cars.value.filter((car) => {
        const matchesPrice = car.car.price_per_day <= priceRange.value;
        const matchesType = carType.value ? car.car.type === carType.value : true;
        const matchesEngineType = engineType.value
          ? car.car.engine_type === engineType.value
          : true;

        const matchesSeats = car.car.seats >= seats.value;
        const matchesBags = car.car.bags >= bags.value;
        const matchesDoors = car.car.doors >= doors.value;

        return (
          matchesPrice &&
          matchesType &&
          matchesEngineType &&
          matchesSeats &&
          matchesBags &&
          matchesDoors
        );
      });
    });

    /////////////////////////////////////////////////////////////////////////////////////
    ////////////////////PaginatedCars is used in the template show the cars list///////////////////////////////////////

    const PaginatedCars = computed(() => {
      return filteredCars.value.slice(slicestart.value, sliceend.value);
    });

    const nextPage = () => {
      slicestart.value += 5;
      sliceend.value += 5;
    };

    const prevPage = () => {
      slicestart.value -= 5;
      sliceend.value -= 5;
    };

    ////////////////nextPage and prevPage used to paginate cars list, 5 by 5 //////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////

    onMounted(() => {}), onMounted(fetchCars);

    return {
      PaginatedCars,
      nextPage,
      prevPage,
      cars,
      slicestart,
      sliceend,
      filteredCars,
      selectedPastDates,
      selectedpickupAfterDropoff,
      loading,
    };
  },
};
</script>

<style></style>
