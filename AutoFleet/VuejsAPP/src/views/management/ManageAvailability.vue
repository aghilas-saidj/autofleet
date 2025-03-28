<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="column is-9-tablet is-10-desktop">
        <div class="custom-container" style="min-height: 100vh">
          <div class="card">
            <div class="card-content">
              <router-link
                :to="`/management/cars`"
                class="button is-primary has-text-white ml-2 mt-2 mb-1"
                >View available cars</router-link
              >
              <router-link
                :to="`/management/carsmaintenance`"
                class="button is-warning has-text-white ml-2 mt-2 mb-1"
                >View under maintenance cars</router-link
              >

              <router-link
                :to="`/management/car/${id}/locations`"
                class="button is-primary ml-2 mt-2 mb-1 has-text-white"
                >Manage locations</router-link
              >
              <hr
                style="
                  background-color: #f5f5f5;
                  border: none;
                  display: block;
                  height: 2px;
                  margin: 1.5rem 0;
                "
              />
            </div>
          </div>

          <div class="notification-container" style="pointer-events: none">
            <div v-if="isDeleted" class="notification is-success has-text-white">
              <p>Availability has been Deleted</p>
            </div>
          </div>

          <div class="notification-container" style="pointer-events: none">
            <div v-if="isAdded" class="notification is-success has-text-white">
              <p>New availability add</p>
            </div>

            <div v-if="unvalidDates" class="notification is-danger has-text-white">
              <p>You cannot select dates in the past</p>
            </div>
          </div>

          <div class="columns is-multiline">
            <div class="column is-3">
              <div v-if="carDetails && carDetails.car" class="">
                <figure class="image is-256x256">
                  <img
                    :src="`https://carrentalsystemimages.s3.eu-north-1.amazonaws.com/${carDetails.car.image_path}`"
                    alt="Car Image"
                  />
                </figure>
              </div>
            </div>

            <div
              v-if="loading"
              style="display: flex; justify-content: center; align-items: center"
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

            <div class="column is-3">
              <div v-if="carDetails && carDetails.car" class="">
                <p
                  class="subtitle is-6"
                  style="display: flex; align-items: center; color: #4a4a4a !important"
                >
                  ID : {{ carDetails.car.id }}
                </p>
                <p
                  class="subtitle is-6"
                  style="display: flex; align-items: center; color: #4a4a4a !important"
                >
                  Name : {{ carDetails.car.name }}
                </p>
              </div>
            </div>
          </div>

          <div class="columns is-multiline">
            <div class="column is-4">
              <div class="box has-background-white">
                <VueDatePicker
                  v-model="date"
                  :range="true"
                  inline
                  placeholder="Add new availability"
                  @update:modelValue="addNewAvailability(id)"
                />
              </div>
            </div>

            <div class="column is-4">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">Availability</p>
                  <div
                    class="box has-background-white"
                    v-for="availability in [...carAvailability].reverse()"
                    :key="availability.id"
                  >
                    <div>
                      <p>From: {{ formatDate(availability.available_from) }}</p>
                      <p>To: {{ formatDate(availability.available_to) }}</p>
                    </div>

                    <button
                      @click="deleteAvailability(availability.id)"
                      class="button is-danger is-small has-text-white mr-1"
                      type="button"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="column is-4">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">Unavailability</p>
                  <div class="notification is-warning">
                    Users cannot book on the dates below (Unavailable dates) as they have
                    already been booked
                  </div>

                  <div
                    class="box has-background-white"
                    v-for="unavailability in [...carUnavailability].reverse()"
                    :key="unavailability.id"
                  >
                    <div>
                      <p>From: {{ unavailability.unavailable_from }}</p>
                      <p>To: {{ unavailability.unavailable_to }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <FooterElement />
  </div>
</template>

<script>
import ManagementMenu from "../../components/ManagementMenu.vue";
import ManagementNavBar from "../../components/ManagementNavBar.vue";
import FooterElement from "../../components/FooterElement.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import dayjs from "dayjs";

import { handleUnauthorizedError } from "@/utils/auth";

import config from "@/config";
import ProgressBar from "@/components/ProgressBar.vue";

export default {
  components: {
    ManagementMenu,
    ManagementNavBar,
    FooterElement,
    VueDatePicker,
    ProgressBar,
  },

  setup() {
    const loading = ref(true);

    const date = ref([]);
    const carAvailability = ref([]);
    const carUnavailability = ref([]);
    const isDeleted = ref(false);
    const isAdded = ref(false);
    const route = useRoute(); // Get the current route object
    const id = route.params.id; // Extract the `id` parameter from the URL
    const carDetails = ref([]);
    const unvalidDates = ref(false);

    ////////////////////////////////////////////////////////////////

    const isPastDate = (date) => {
      const today = new Date();
      today.setHours(0, 0, 0, 0); // Reset time to start of the day
      const selectedDate = new Date(date); // Convert input to Date object

      return selectedDate < today; // Check if it's in the past
    };

    const addNewAvailability = async (id) => {
      if (date?.value?.[0]) {
        if (isPastDate(date.value[0])) {
          console.log("Invalid date: You cannot select a past date.");
          pastDates();
          return;
        } else {
          console.log("Valid date.");
        }
      } else {
        console.log("No date selected.");
      }

      try {
        const response = await axios.post(
          `${config.API_BASE_URL}/management/addcaravailability`,
          {
            car_id: id,
            available_from: formatDate(date.value[0]),
            available_to: formatDate(date.value[1]),
          },

          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        if (response) {
          additionStatus();
        }

        return response;
      } catch (error) {
        handleUnauthorizedError(error);

        console.log("Unexpected error");
      }
    };

    ////////////////////////////////////////////////////////////////

    const fetchCarData = async (id) => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/management/cars/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });

        carDetails.value = response.data;

        // console.log(carDetails.value);

        return response;
      } catch (error) {
        handleUnauthorizedError(error);
        console.log("Unexpected error");
      }
    };

    ////////////////////////////////////////////////////////////////

    const fetchAvailabilityData = async (id) => {
      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/getavailabilitybycarid/${id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        carAvailability.value = response.data;

        return response;
      } catch (error) {
        handleUnauthorizedError(error);

        console.log("Unexpected error");
      } finally {
        loading.value = false; // Stop loading
      }
    };

    ////////////////////////////////////////////////////////////////

    const fetchUnavailabilityData = async (id) => {
      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/getunavailability/${id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        carUnavailability.value = response.data;

        return response;
      } catch (error) {
        handleUnauthorizedError(error);

        console.log("Unexpected error");
      }
    };

    ////////////////////////////////////////////////////////////////

    const formatDate = (dateString) => {
      return dayjs(dateString).format("YYYY-MM-DD HH:mm");
    };

    ////////////////////////////////////////////////////////////////

    const deleteAvailability = async (id) => {
      const isConfirmed = confirm("Are you sure you want to remove this availability?");

      if (!isConfirmed) return;

      const Delete = await axios.delete(
        `${config.API_BASE_URL}/management/removecaravailability/${id}`,
        {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        }
      );

      if (Delete) {
        deleteStatus();
      }
    };

    ////////////////////////////////////////////////////////////////

    const deleteStatus = () => {
      // Set Updated to true
      isDeleted.value = true;

      fetchAvailabilityData(id);

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isDeleted.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    ////////////////////////////////////////////////////////////////

    const additionStatus = () => {
      // Set Updated to true
      isAdded.value = true;
      date.value = [];
      fetchAvailabilityData(id);

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isAdded.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    ////////////////////////////////////////////////////////////////////////////////

    const pastDates = () => {
      // Set Updated to true
      unvalidDates.value = true;
      date.value = [];
      fetchAvailabilityData(id);

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        unvalidDates.value = false;
      }, 4000); // 4000ms = 4 seconds
    };

    ////////////////////////////////////////////////////////////////

    onMounted(() => {
      fetchCarData(id);
      fetchAvailabilityData(id);
      fetchUnavailabilityData(id);
    });

    return {
      carDetails,
      date,
      carAvailability,
      addNewAvailability,
      id,
      carUnavailability,
      formatDate,
      deleteAvailability,
      isDeleted,
      isAdded,
      unvalidDates,
      loading,
    };
  },
};
</script>

<style>
.table-container {
  overflow-x: auto;
}

.card-content {
  padding: 1rem;
}

.card {
  box-shadow: 0 0.5em 1em -0.125em rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.02) !important; /* Force priority */
  border-radius: 0.25rem;
  background-color: #e1e1e126 !important; /* Force priority */

  display: flex;
  flex-direction: column; /* Ensures content stacks vertically */

  color: #4a4a4a !important;
  position: relative;
  height: 100%;
}

.subtitle {
  color: #4a4a4a !important;
}

.title {
  color: #4a4a4a !important;
}

.menu-element {
  background-color: hsl(229.1, 53.1%, 53.1%) !important;
  color: rgb(255, 255, 255) !important;
}

.menu-element:hover {
  background-color: rgb(255, 255, 255) !important;
  color: rgb(0, 0, 0) !important;
}

th {
  color: black !important;
}

td {
  color: black !important;
}

.custom-container {
  width: 100%;
  max-width: 1000px;
  margin: 0 auto; /* Center the content horizontally */
  padding: 0 20px; /* Optional: Add some padding for spacing */
}

/* Ensure full width on mobile */
@media (max-width: 768px) {
  .custom-container {
    width: 100%; /* Allow full width on small screens */
    max-width: 100%; /* Remove the max-width constraint on mobile */
    padding: 0; /* Optional: Remove padding for mobile */
  }
}
</style>
