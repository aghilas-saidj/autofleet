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
                :to="`/management/car/${id}/availability`"
                class="button is-primary ml-2 mt-2 mb-1 has-text-white"
                >Manage availability</router-link
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
              <p>Location has been Deleted</p>
            </div>
          </div>

          <div class="notification-container" style="pointer-events: none">
            <div v-if="pickupFormIsEmpty" class="notification is-danger has-text-white">
              <p>Please complete pickup name/address</p>
            </div>
          </div>

          <div class="notification-container" style="pointer-events: none">
            <div v-if="dropoffFormIsEmpty" class="notification is-danger has-text-white">
              <p>Please complete dropoff name/address</p>
            </div>
          </div>

          <div class="notification-container" style="pointer-events: none">
            <div v-if="isAdded" class="notification is-success has-text-white">
              <p>New location add</p>
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

          <div class="columns">
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
            <div class="column is-6">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">Add pickup</p>
                  <hr
                    style="
                      background-color: #f5f5f5;
                      border: none;
                      display: block;
                      height: 2px;
                      margin: 1.5rem 0;
                    "
                  />

                  <label class="subtitle is-6">Pickup location's name</label>
                  <input
                    class="input is-primary is-small has-text-black"
                    type="text"
                    placeholder="Add new pickup location"
                    v-model="newPickupName"
                  />

                  <label class="subtitle is-6">Pickup Address</label>
                  <input
                    class="input is-primary is-small has-text-black"
                    type="text"
                    placeholder="Add new dropoff location"
                    v-model="newPickupAddress"
                  />

                  <button
                    @click="addNewPickup"
                    class="button is-primary is-small has-text-white mt-1"
                  >
                    Add pickup location
                  </button>
                </div>
              </div>
            </div>

            <div class="column is-6">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">Add dropoff</p>
                  <hr
                    style="
                      background-color: #f5f5f5;
                      border: none;
                      display: block;
                      height: 2px;
                      margin: 1.5rem 0;
                    "
                  />
                  <label class="subtitle is-6">Dropoff location's name</label>
                  <input
                    class="input is-primary is-small has-text-black"
                    type="text"
                    placeholder="Add new dropoff location"
                    v-model="newDropoffName"
                  />

                  <label class="subtitle is-6">Dropoff Address</label>
                  <input
                    class="input is-primary is-small has-text-black"
                    type="text"
                    placeholder="Add new dropoff location"
                    v-model="newDropoffAddress"
                  />

                  <button
                    @click="addNewDropoff"
                    class="button is-primary is-small has-text-white mt-1"
                  >
                    Add dropoff location
                  </button>
                </div>
              </div>
            </div>

            <div class="column is-6">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">Pickups</p>
                  <div
                    class="box has-background-white"
                    v-for="pickup in [...pickups].reverse()"
                    :key="pickup.id"
                  >
                    <div>
                      <p>Name: {{ pickup.location.name }}</p>
                      <p>Address: {{ pickup.location.address }}</p>
                    </div>

                    <button
                      @click="deletePickup(pickup.id)"
                      class="button is-small is-danger has-text-white mr-1"
                      type="button"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="column is-6">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">Dropoffs</p>
                  <div
                    class="box has-background-white"
                    v-for="dropoff in [...dropoffs].reverse()"
                    :key="dropoff.id"
                  >
                    <div>
                      <p>Name: {{ dropoff.location.name }}</p>
                      <p>Address: {{ dropoff.location.address }}</p>
                    </div>

                    <button
                      @click="deleteDropoff(dropoff.id)"
                      class="button is-small is-danger has-text-white mr-1"
                      type="button"
                    >
                      Delete
                    </button>
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
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import dayjs from "dayjs";
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

    const newPickupName = ref("");
    const newPickupAddress = ref("");

    const newDropoffName = ref("");
    const newDropoffAddress = ref("");

    const dropoffs = ref([]);
    const pickups = ref([]);

    const isDeleted = ref(false);
    const isAdded = ref(false);
    const route = useRoute(); // Get the current route object
    const id = route.params.id; // Extract the `id` parameter from the URL
    const router = useRouter();
    const carDetails = ref([]);

    const pickupFormIsEmpty = ref(false);
    const dropoffFormIsEmpty = ref(false);

    const addNewPickup = async () => {
      if (!newPickupAddress.value || !newPickupName.value) {
        incomletePickupForm();
        return;
      }

      const checkNewPickupAddress = newPickupAddress.value.trim();
      const checkNewPickupName = newPickupName.value.trim();

      // Validate reason (must be a string with a max length of 100 characters)
      if (checkNewPickupAddress === "" || checkNewPickupAddress.length > 100) {
        alert("Invalid pickup address. It must be between 1 and 100 characters.");
        return;
      }

      // Validate reason (must be a string with a max length of 100 characters)
      if (checkNewPickupName === "" || checkNewPickupName.length > 100) {
        alert("Invalid pickup name. It must be between 1 and 100 characters.");
        return;
      }

      try {
        const response = await axios.post(
          `${config.API_BASE_URL}/management/${route.params.id}/addpickup`,
          {
            name: newPickupName.value,
            address: newPickupAddress.value,
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
      }
    };

    const addNewDropoff = async () => {
      if (!newDropoffAddress.value || !newDropoffName.value) {
        incomleteDropoffForm();
        return;
      }

      const checkNewDropoffAddress = newDropoffAddress.value.trim();
      const checkNewDropoffName = newDropoffName.value.trim();

      // Validate reason (must be a string with a max length of 100 characters)
      if (checkNewDropoffAddress === "" || checkNewDropoffAddress.length > 100) {
        alert("Invalid pickup address. It must be between 1 and 100 characters.");
        return;
      }

      // Validate reason (must be a string with a max length of 100 characters)
      if (checkNewDropoffName === "" || checkNewDropoffName.length > 100) {
        alert("Invalid pickup name. It must be between 1 and 100 characters.");
        return;
      }

      try {
        const response = await axios.post(
          `${config.API_BASE_URL}/management/${route.params.id}/adddropoff`,
          {
            name: newDropoffName.value,
            address: newDropoffAddress.value,
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
        if (error.response.status === 403) {
          if (error.response.data.message === "Unauthorized - Admins only") {
            console.log("Unauthorized - Admins only");
            router.push("/login");
            // Optionally redirect the user to a different page, like login or a 403 page
          }
        } else {
          // console.error("Error fetching data:", error.response.data.message);
          console.error("Error fetching data:", error.response.data.message);
        }

        console.log("Adding new dropoff incomplete");
      }
    };

    const fetchCarData = async (id) => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/management/cars/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });

        carDetails.value = response.data;

        return response;
      } catch (error) {
        if (error.response.status === 403) {
          if (error.response.data.message === "Unauthorized - Admins only") {
            console.log("Unauthorized - Admins only");
            router.push("/login");
            // Optionally redirect the user to a different page, like login or a 403 page
          }
        } else {
          console.error("Error fetching data:", error.response.data.message);
        }

        console.log("Getting car's data incomplete");
      }
    };

    const fetchlocationsData = async (id) => {
      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/${id}/pickupsanddropoffsbycarId`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        pickups.value = response.data.original.pickups;
        dropoffs.value = response.data.original.dropoffs;

        return response;
      } catch (error) {
        if (error.response.status === 403) {
          if (error.response.data.message === "Unauthorized - Admins only") {
            console.log("Unauthorized - Admins only");
            router.push("/login");
            // Optionally redirect the user to a different page, like login or a 403 page
          }
        } else {
          //  console.error("Error fetching data:", error.response.data.message);
          console.error("Error fetching data:", error.response.data.message);
        }

        console.log("Getting location incomlete");
      } finally {
        loading.value = false; // Stop loading
      }
    };

    const formatDate = (dateString) => {
      return dayjs(dateString).format("YYYY-MM-DD HH:mm");
    };

    const deletePickup = async (id) => {
      const isConfirmed = confirm(
        "Are you sure you want to remove this pickup location?"
      );

      if (!isConfirmed) return;

      const Delete = await axios.delete(
        `${config.API_BASE_URL}/management/deletepickup/${id}`,
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

    const deleteDropoff = async (id) => {
      const isConfirmed = confirm(
        "Are you sure you want to remove this pickup location?"
      );

      if (!isConfirmed) return;

      const Delete = await axios.delete(
        `${config.API_BASE_URL}/management/deletepropoff/${id}`,
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

    const deleteStatus = () => {
      // Set Updated to true
      isDeleted.value = true;

      fetchlocationsData(id);

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isDeleted.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    const incomletePickupForm = () => {
      // Set Updated to true

      pickupFormIsEmpty.value = true;

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        pickupFormIsEmpty.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    const incomleteDropoffForm = () => {
      // Set Updated to true

      dropoffFormIsEmpty.value = true;

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        dropoffFormIsEmpty.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    const additionStatus = () => {
      // Set Updated to true
      isAdded.value = true;
      newPickupName.value = "";
      newPickupAddress.value = "";

      newDropoffName.value = "";
      newDropoffAddress.value = "";

      fetchlocationsData(id);
      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isAdded.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    onMounted(() => {
      fetchCarData(id);
      fetchlocationsData(id);
    });

    return {
      carDetails,
      addNewPickup,
      addNewDropoff,
      id,
      formatDate,
      deletePickup,
      deleteDropoff,
      isDeleted,
      isAdded,
      pickups,
      dropoffs,
      newPickupName,
      newPickupAddress,

      newDropoffName,
      newDropoffAddress,

      pickupFormIsEmpty,
      dropoffFormIsEmpty,

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
