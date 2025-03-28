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
                :to="`/management/addcar`"
                class="button is-primary mr-3 has-text-white"
                type="button"
                >Add new car</router-link
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
            <div v-if="isTransferred" class="notification is-success has-text-white">
              <p>Car has been transferred to maintenance section</p>
            </div>
          </div>

          <div class="notification-container" style="pointer-events: none">
            <div v-if="isDeleted" class="notification is-success has-text-white">
              <p>Car has been Deleted</p>
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

          <div class="card mb-4 mt-4" v-for="car in PaginatedCars" :key="car.id">
            <div class="card-content is-flex is-flex-wrap-wrap is-align-items-center">
              <!-- Image Section -->
              <figure class="image mr-3">
                <img
                  style="width: 150px; height: auto"
                  :src="`https://carrentalsystemimages.s3.eu-north-1.amazonaws.com/${car.image_path}`"
                  alt="Car image placeholder"
                />
              </figure>

              <!-- Text Information Section -->
              <div class="mr-3">
                <p class="title is-7">{{ car.id }}</p>
                <p class="title is-6">{{ car.name }}</p>
                <p class="subtitle is-7">
                  {{ car.description }}
                </p>
              </div>

              <!-- Buttons Section -->
              <div
                class="buttons are-small ml-auto is-flex is-flex-direction-column is-align-items-end"
              >
                <div>
                  <router-link
                    :to="`/management/cardetails/${car.id}`"
                    class="button is-primary has-text-white mr-1"
                    >View details</router-link
                  >

                  <router-link
                    :to="`/management/editcar/${car.id}`"
                    class="button has-background-grey-light has-text-black mr-1"
                    >Edit</router-link
                  >

                  <router-link
                    :to="`/management/car/${car.id}/availability`"
                    class="button is-link mr-1"
                    >Manage availablity</router-link
                  >

                  <router-link
                    :to="`/management/car/${car.id}/locations`"
                    class="button is-link mr-1"
                    >Manage locations</router-link
                  >

                  <button
                    @click="transfertomaintenance(car.id)"
                    class="button is-warning mr-1"
                    type="button"
                  >
                    Transfer to maintenance
                  </button>
                  <button
                    @click="deleteCar(car.id)"
                    class="button is-danger has-text-white mr-1"
                    type="button"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>

          <button
            class="button is-small mr-2"
            @click="prevPage"
            :disabled="slicestart <= 0"
          >
            Previous
          </button>

          <button
            class="button is-small"
            @click="nextPage"
            :disabled="sliceend >= cars.length"
          >
            Next
          </button>
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
import axios from "axios";
import { onMounted, ref, computed } from "vue";

import { handleUnauthorizedError } from "@/utils/auth";

import config from "@/config";
import ProgressBar from "@/components/ProgressBar.vue";

export default {
  components: {
    ManagementMenu,
    ManagementNavBar,
    FooterElement,
    ProgressBar,
  },

  setup() {
    const loading = ref(true);

    const isTransferred = ref(false);
    const isDeleted = ref(false);
    const cars = ref([]);
    const cardetails = ref([]);

    const slicestart = ref(0);
    const sliceend = ref(5);

    const fetchData = async () => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/management/cars`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });

        cars.value = response.data;

        //  console.log(response);

        return response;
      } catch (error) {
        handleUnauthorizedError(error);
        console.log("Getting cars incomplete");
      } finally {
        loading.value = false; // Stop loading
      }
    };

    const viewdetails = async (id) => {
      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/cars/${id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          } // Use template literal here
        );

        cardetails.value = response.data.car;

        //   console.log(cardetails.value);
      } catch (error) {
        handleUnauthorizedError(error);
        console.log("Getting car's details  incomplete");
      }
    };

    const transfertomaintenance = async (id) => {
      const isConfirmed = confirm(
        "Are you sure you want to trasfer this car to maintenance?"
      );

      if (!isConfirmed) return;

      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/cars/${id}/transfertomaintenance`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        if (response) {
          transferStatus();
        }
      } catch (error) {
        console.log("Transfer to maintenance incomplete");
      }
    };

    const transferStatus = () => {
      // Set Updated to true
      isTransferred.value = true;
      fetchData();

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isTransferred.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    const deleteCar = async (id) => {
      const isConfirmed = confirm("Are you sure you want to delete this car?");

      if (!isConfirmed) return;

      const Delete = await axios.delete(`${config.API_BASE_URL}/management/cars/${id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
        },
      });

      if (Delete) {
        deleteStatus();
      }
    };

    const deleteStatus = () => {
      // Set Updated to true
      isDeleted.value = true;
      fetchData();

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isDeleted.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    const PaginatedCars = computed(() => {
      return cars.value.slice(slicestart.value, sliceend.value);
    });
    const nextPage = () => {
      slicestart.value += 5;
      sliceend.value += 5;
    };

    const prevPage = () => {
      slicestart.value -= 5;
      sliceend.value -= 5;
    };

    onMounted(() => {
      fetchData();
    });

    return {
      cars,
      cardetails,
      viewdetails,
      transfertomaintenance,
      isTransferred,
      deleteCar,
      isDeleted,
      PaginatedCars,
      nextPage,
      prevPage,

      slicestart,
      sliceend,
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
  width: 100%; /* Full width */

  color: #4a4a4a !important;
  max-width: 100%;
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
