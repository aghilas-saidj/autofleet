<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="column is-9-tablet is-10-desktop">
        <div class="custom-container" style="min-height: 100vh">
          <router-link
            :to="`/management/users`"
            class="button is-primary has-text-white mt-2 mb-1"
            >View all users</router-link
          >

          <hr />

          <div class="columns is-multiline">
            <div class="column is-12 is-flex">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">User's info</p>

                  <p>Name : {{ name }}</p>
                  <p>Email address : {{ email }}</p>
                  <p>Role : {{ role }}</p>
                  <p>Since : {{ created_at }}</p>
                </div>
              </div>
            </div>

            <hr />
            <div class="column is-12">
              <div class="card">
                <div class="card-content">
                  <p class="title is-5">User's rentals</p>
                  <div class="table-container">
                    <table
                      class="table is-fullwidth has-background-white"
                      style="border-radius: 20px"
                    >
                      <thead>
                        <tr>
                          <th>Booking ID</th>
                          <th>Car ID</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Pickup location</th>
                          <th>Dropoff location</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="rental in PaginatedRentals" :key="rental.id">
                          <td>{{ rental.id }}</td>
                          <td>{{ rental.car_id }}</td>
                          <td>{{ rental.start_date }}</td>
                          <td>{{ rental.end_date }}</td>
                          <td>{{ rental.pickuplocation }}</td>
                          <td>{{ rental.dropofflocation }}</td>

                          <td>
                            <p
                              v-if="rental.status === 'confirmed'"
                              class="has-text-success"
                            >
                              {{ rental.status }}
                            </p>

                            <p
                              v-if="rental.status === 'pending'"
                              class="has-text-warning"
                            >
                              {{ rental.status }}
                            </p>

                            <p
                              v-if="rental.status === 'canceled'"
                              class="has-text-danger"
                            >
                              {{ rental.status }}
                            </p>
                          </td>

                          <td class="">
                            <!-- <button class="button is-small is-light mr-1 mb-1">Edit</button> -->
                          </td>
                        </tr>
                        <div class="is-flex">
                          <button
                            class="button is-small mr-1"
                            @click="prevPage"
                            :disabled="slicestart <= 0"
                          >
                            Previous
                          </button>

                          <button
                            class="button is-small"
                            @click="nextPage"
                            :disabled="sliceend >= rentalsData.length"
                          >
                            Next
                          </button>
                        </div>

                        <!-- Add more rows as needed -->
                      </tbody>
                    </table>
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
import axios from "axios";
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";

import { handleUnauthorizedError } from "@/utils/auth";

import config from "@/config";

export default {
  components: {
    ManagementMenu,
    ManagementNavBar,
    FooterElement,
  },

  setup() {
    const route = useRoute(); // Get the current route object
    const id = route.params.id; // Extract the `id` parameter from the URL
    const name = ref("");
    const email = ref("");
    const role = ref("");
    const created_at = ref("");
    const slicestart = ref(0);
    const sliceend = ref(10);
    const rentalsData = ref([]);

    const userDate = ref([]);

    const fetchUserData = async (id) => {
      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/users/${id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        userDate.value = response.data;

        name.value = response.data.name;
        email.value = response.data.email;
        role.value = response.data.role;

        created_at.value = new Date(response.data.created_at).toLocaleDateString();

        // console.log("Success:", response.data);
      } catch (error) {
        handleUnauthorizedError(error);

        console.error("Unexpected error");
      }
    };

    const fetchRentalsData = async (id) => {
      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/bookings/user/${id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        rentalsData.value = response.data;

        // console.log("Success:", response.data);
      } catch (error) {
        handleUnauthorizedError(error);
        console.error("Unexpected error");
      }
    };

    const PaginatedRentals = computed(() => {
      return rentalsData.value.slice(slicestart.value, sliceend.value);
    });

    const nextPage = () => {
      slicestart.value += 2;
      sliceend.value += 2;
    };

    const prevPage = () => {
      slicestart.value -= 10;
      sliceend.value -= 10;
    };

    onMounted(() => {
      fetchUserData(id);
      fetchRentalsData(id);
    });
    return {
      name,
      email,
      role,
      created_at,
      rentalsData,
      PaginatedRentals,
      nextPage,
      prevPage,
      slicestart,
      sliceend,
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
