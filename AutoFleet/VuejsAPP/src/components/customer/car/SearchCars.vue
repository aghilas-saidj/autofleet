<template>
  <div>
    <div
      v-if="showSearchSection"
      class="search-section"
      style="width: 100%; display: flex; justify-content: center; align-items: center"
    >
      <div class="card has-background-white">
        <div class="card-content">
          <div v-if="dateErrorMessage" class="notification is-danger has-text-white">
            <p>The selected date cannot be in the past. Please choose a valid date.</p>
          </div>

          <div class="columns is-multiline is-flex" style="width: 100%">
            <div
              class="column is-12 is-flex"
              style="display: flex; justify-content: center; align-items: center"
            >
              <div class="columns is-multiline" style="width: 100%">
                <div class="column is-12">
                  <label for="" style="color: #4a4a4a">
                    <font-awesome-icon icon="map-marker-alt" /> Pickup location</label
                  >
                  <div class="select is-success" style="width: 100%">
                    <select
                      v-model="pickupLocation"
                      class="subtitle is-6"
                      style="width: 100%; color: #4a4a4a"
                    >
                      <option>any</option>
                      <option
                        v-for="location in locations"
                        :key="location.id"
                        :value="location.name"
                      >
                        {{ location.name }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="column is-12 is-flex" style="width: 100%">
                  <div style="width: 100%; color: #4a4a4a">
                    <label for=""
                      ><font-awesome-icon icon="calendar-alt" /> Pickup date</label
                    ><input
                      v-model="pickupDate"
                      class="input is-success"
                      type="date"
                      style="width: 100%; color: #4a4a4a"
                    />
                  </div>

                  <div>
                    <label for="" style="color: #4a4a4a">
                      <font-awesome-icon icon="clock" /> Time</label
                    >
                    <input
                      v-model="pickupTime"
                      class="is-success input"
                      type="time"
                      style="width: 100%; color: #4a4a4a"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr style="background-color: #f5f5f5 !important" />

          <div class="columns is-multiline is-flex" style="width: 100%">
            <div
              class="column is-12 is-flex"
              style="display: flex; justify-content: center; align-items: center"
            >
              <div class="columns is-multiline" style="width: 100%">
                <div class="column is-12">
                  <label for="" style="color: #4a4a4a"
                    ><font-awesome-icon icon="map-marker-alt" /> Dropoff location</label
                  >
                  <div class="select is-success" style="width: 100%; color: #4a4a4a">
                    <select
                      v-model="dropoffLocation"
                      class="subtitle is-6"
                      style="width: 100%; color: #4a4a4a"
                    >
                      <option>any</option>
                      <option
                        v-for="location in locations"
                        :key="location.id"
                        :value="location.name"
                      >
                        {{ location.name }}
                      </option>
                    </select>
                  </div>
                </div>

                <div class="column is-12 is-flex" style="width: 100%; color: #4a4a4a">
                  <div style="width: 100%; color: #4a4a4a">
                    <label for=""
                      ><font-awesome-icon icon="calendar-alt" /> Dropoff date</label
                    ><input
                      v-model="dropoffDate"
                      class="input is-success"
                      type="date"
                      style="width: 100%; color: #4a4a4a"
                    />
                  </div>

                  <div>
                    <label for="" style="color: #4a4a4a"
                      ><font-awesome-icon icon="clock" /> Time</label
                    >
                    <input
                      v-model="dropoffTime"
                      class="is-success input"
                      type="time"
                      style="width: 100%; color: #4a4a4a"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button
            @click="searchCars"
            class="button is-primary has-text-weight-bold has-text-white"
          >
            Search
          </button>
        </div>
      </div>
    </div>

    <div class="notification-container" style="pointer-events: none">
      <div v-if="showNotification" class="notification is-success has-text-white">
        <p>{{ searchNotification }}</p>
      </div>
    </div>

    <div class="has-background-white">
      <div class="">
        <div class="columns is-multiline">
          <div class="column is-6">
            <div class="card is-flat has-background-white">
              <div class="card-content">
                <p class="subtitle is-7" style="color: #3e8ed0">Pickup</p>

                <p class="title is-5 has-text-weight-bold" style="color: #3e8ed0">
                  <font-awesome-icon icon="calendar-alt" />
                  {{ searchedpickupDate }}
                  <span class="subtitle is-6" style="color: #3e8ed0">
                    <font-awesome-icon icon="clock" />
                    {{ searchedpickupTime }}</span
                  >
                </p>
                <p class="subtitle is-6 has-text-weight-bold" style="color: #3e8ed0">
                  <font-awesome-icon icon="map-marker-alt" />
                  {{ searchedpickupLocation }}
                </p>
              </div>
            </div>
          </div>

          <div class="column is-6">
            <div class="card is-flat">
              <div class="card-content">
                <p class="subtitle is-7" style="color: #3e8ed0">Dropoff</p>

                <p class="title is-5 has-text-weight-bold" style="color: #3e8ed0">
                  <font-awesome-icon icon="calendar-alt" />
                  {{ searcheddropoffDate }}
                  <span class="subtitle is-6" style="color: #3e8ed0"
                    ><font-awesome-icon icon="clock" />
                    {{ searcheddropoffTime }}
                  </span>
                </p>
                <p class="subtitle is-6 has-text-weight-bold" style="color: #3e8ed0">
                  <font-awesome-icon icon="map-marker-alt" />
                  {{ searcheddropoffLocation }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <div
          v-if="!showSearchSection"
          @click="toggleSearchSection"
          class="button is-primary has-text-weight-bold has-text-white"
        >
          Modify booking details
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useStore } from "vuex";
import config from "@/config";

export default {
  setup() {
    const store = useStore();

    const pickupLocation = ref(localStorage.getItem("pickupLocation") || "any");
    const pickupDate = ref(localStorage.getItem("pickupDate") || "");
    const pickupTime = ref(localStorage.getItem("pickupTime") || "");
    const dropoffLocation = ref(localStorage.getItem("dropoffLocation") || "any");
    const dropoffDate = ref(localStorage.getItem("dropoffDate") || "");
    const dropoffTime = ref(localStorage.getItem("dropoffTime") || "");

    const searchNotification = ref("");

    // Search variables to hold the values after search
    const searchedpickupLocation = ref();
    const searchedpickupDate = ref();
    const searchedpickupTime = ref();
    const searcheddropoffLocation = ref();
    const searcheddropoffDate = ref();
    const searcheddropoffTime = ref();

    const locations = ref([]);
    const showSearchSection = ref(false);

    const showNotification = ref(false);
    const dateErrorMessage = ref(false);
    const toggleSearchSection = () => {
      showSearchSection.value = !showSearchSection.value;
    };

    const triggerNotification = () => {
      showNotification.value = true;
      setTimeout(() => {
        showNotification.value = false;
      }, 2000); // Hide after 1 second
    };

    // Fetch locations from the API when the component is mounted
    const fetchLocations = async () => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/locations`);
        locations.value = response.data;

        // Assuming locations.value is your array of location objects
        const uniqueLocations = locations.value.filter(
          (value, index, self) =>
            index ===
            self.findIndex(
              (t) => t.name === value.name // Filter based on the 'name' property
            )
        );

        // Now, `uniqueLocations` contains only unique location names
        locations.value = uniqueLocations; // Update your original array
      } catch (error) {
        console.error("Error fetching locations:");
      }
    };

    // Trigger search action
    const searchCars = () => {
      if (
        pickupDate.value &&
        pickupTime.value &&
        dropoffDate.value &&
        dropoffTime.value &&
        pickupLocation.value &&
        dropoffLocation.value
      ) {
        store.commit("search/SET_PICKUP_LOCATION", pickupLocation.value);
        store.commit("search/SET_PICKUP_DATE", pickupDate.value);
        store.commit("search/SET_PICKUP_TIME", pickupTime.value);
        store.commit("search/SET_DROPOFF_LOCATION", dropoffLocation.value);
        store.commit("search/SET_DROPOFF_DATE", dropoffDate.value);
        store.commit("search/SET_DROPOFF_TIME", dropoffTime.value);

        searchedpickupLocation.value = pickupLocation.value;
        searchedpickupDate.value = pickupDate.value;
        searchedpickupTime.value = pickupTime.value;
        searcheddropoffLocation.value = dropoffLocation.value;
        searcheddropoffDate.value = dropoffDate.value;
        searcheddropoffTime.value = dropoffTime.value;
        showSearchSection.value = !showSearchSection.value;

        searchNotification.value = "Your search criteria have been updated successfully.";
        triggerNotification();
      } else {
        alert("Please fill in all fields.");
      }
    };

    // Fetch data on component mount
    onMounted(() => {
      searchedpickupLocation.value = pickupLocation.value;
      searchedpickupDate.value = pickupDate.value;
      searchedpickupTime.value = pickupTime.value;
      searcheddropoffLocation.value = dropoffLocation.value;
      searcheddropoffDate.value = dropoffDate.value;
      searcheddropoffTime.value = dropoffTime.value;

      fetchLocations();
    });

    return {
      pickupLocation,
      pickupDate,
      pickupTime,
      dropoffLocation,
      dropoffDate,
      dropoffTime,
      searchCars,
      toggleSearchSection,
      showNotification,
      showSearchSection,
      locations,
      searchedpickupLocation,
      searchedpickupDate,
      searchedpickupTime,
      searcheddropoffLocation,
      searcheddropoffDate,
      searcheddropoffTime,
      searchNotification,
      dateErrorMessage,
    };
  },
};
</script>

<style>
.notification-container {
  position: fixed;
  top: 20px;
  right: 20px;
  background-color: #48c77400; /* Vuetify success color */
  color: white;
  padding: 15px 20px;

  z-index: 1000;
  animation: fadeInOut 4s ease-in-out;
}
</style>
