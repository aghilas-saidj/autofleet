<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="column is-9-tablet is-10-desktop">
        <div class="custom-container" style="min-height: 100vh">
          <div class="notification-container" style="pointer-events: none">
            <div
              v-if="isCanceledsuccssefully"
              class="notification is-success has-text-white"
            >
              <p>Booking has been canceled</p>
            </div>
          </div>

          <div class="notification-container" style="pointer-events: none">
            <div
              v-if="BookingHasAlreadyBeenCanceled"
              class="notification is-danger has-text-white"
            >
              <p>Booking has already been canceled</p>
            </div>
          </div>

          <div class="card">
            <div class="card-content">
              <div class="columns is-multiline is-gapless is-centered">
                <div class="is-flex">
                  <div class="card mr-3">
                    <div class="card-content">
                      <p class="subtitle is-7">Total bookings</p>
                      <span
                        class="tag is-link is-light subtitle is-7"
                        style="color: #3850b7 !important"
                        >{{ allBookingsCount }}</span
                      >
                    </div>
                  </div>

                  <div class="card mr-3">
                    <div class="card-content">
                      <p class="subtitle is-7">Ongoing bookings</p>
                      <span
                        class="tag is-link is-light subtitle is-7"
                        style="color: #3850b7 !important"
                        >{{ ongoingBookingsCount }}</span
                      >
                    </div>
                  </div>

                  <div class="card mr-3">
                    <div class="card-content">
                      <p class="subtitle is-7">Upcoming bookings</p>
                      <span
                        class="tag is-link is-light subtitle is-7"
                        style="color: #3850b7 !important"
                        >{{ newBookingsCount }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>

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

          <div class="card">
            <div class="card-content">
              <div class="columns is-multiline">
                <div class="column is-12">
                  <div class="tabs is-boxed is-centered">
                    <ul>
                      <li :class="{ 'is-active': activeTable === 'all-bookings' }">
                        <a
                          @click="showTable('all-bookings')"
                          class="has-background-white"
                        >
                          <span>All bookings</span>
                        </a>
                      </li>
                      <li :class="{ 'is-active': activeTable === 'ongoing-bookings' }">
                        <a
                          @click="showTable('ongoing-bookings')"
                          class="has-background-white"
                        >
                          <span>Ongoing bookings</span>
                        </a>
                      </li>
                      <li :class="{ 'is-active': activeTable === 'new-bookings' }">
                        <a
                          @click="showTable('new-bookings')"
                          class="has-background-white"
                        >
                          <span>Upcoming bookings</span>
                        </a>
                      </li>
                    </ul>
                  </div>

                  <div
                    id="all-bookings"
                    v-show="activeTable === 'all-bookings'"
                    class="table-container"
                  >
                    <table
                      class="table is-fullwidth has-background-white"
                      style="border-radius: 20px"
                    >
                      <thead>
                        <tr>
                          <th>Booking ID</th>
                          <th>Car ID</th>
                          <th>Customer email</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Pickup location</th>
                          <th>Dropoff location</th>
                          <th>Reference code</th>

                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="booking in AllBookingsPaginated" :key="booking.id">
                          <td>{{ booking.id }}</td>
                          <td>{{ booking.car_id }}</td>
                          <td>{{ booking.email_address }}</td>
                          <td>{{ booking.start_date }}</td>
                          <td>{{ booking.end_date }}</td>
                          <td>{{ booking.pickuplocation }}</td>
                          <td>{{ booking.dropofflocation }}</td>

                          <td>{{ booking.reference_code }}</td>

                          <td>
                            <p
                              v-if="booking.status === 'confirmed'"
                              class="has-text-success"
                            >
                              {{ booking.status }}
                            </p>

                            <p
                              v-if="booking.status === 'pending'"
                              class="has-text-warning"
                            >
                              {{ booking.status }}
                            </p>

                            <p
                              v-if="booking.status === 'canceled'"
                              class="has-text-danger"
                            >
                              {{ booking.status }}
                            </p>
                          </td>
                          <td>
                            <!-- <button class="button is-small is-light mr-1 mb-1">Edit</button> -->
                            <button
                              v-if="booking.status !== 'canceled'"
                              @click="cancelBooking(booking.id)"
                              class="button is-small is-danger mr-1 has-text-white"
                            >
                              Cancel
                            </button>

                            <button
                              v-if="booking.status === 'canceled'"
                              class="button is-small"
                              title="Disabled button"
                              disabled
                            >
                              Cancel
                            </button>
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
                            :disabled="sliceend >= data.length"
                          >
                            Next
                          </button>
                        </div>

                        <!-- Add more rows as needed -->
                      </tbody>
                    </table>
                  </div>

                  <div
                    id="ongoing-bookings"
                    v-show="activeTable === 'ongoing-bookings'"
                    class="table-container"
                  >
                    <table
                      class="table is-fullwidth has-background-white"
                      style="border-radius: 20px"
                    >
                      <thead>
                        <tr>
                          <th>Booking ID</th>
                          <th>Car ID</th>
                          <th>Customer email</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Pickup location</th>
                          <th>Dropoff location</th>
                          <th>Reference code</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="booking in OngoingBookingsPaginated" :key="booking.id">
                          <td>{{ booking.id }}</td>
                          <td>{{ booking.car_id }}</td>
                          <td>{{ booking.email_address }}</td>
                          <td>{{ booking.start_date }}</td>
                          <td>{{ booking.end_date }}</td>
                          <td>{{ booking.pickuplocation }}</td>
                          <td>{{ booking.dropofflocation }}</td>
                          <td>{{ booking.reference_code }}</td>

                          <td>
                            <p
                              v-if="booking.status === 'confirmed'"
                              class="has-text-success"
                            >
                              {{ booking.status }}
                            </p>

                            <p
                              v-if="booking.status === 'pending'"
                              class="has-text-warning"
                            >
                              {{ booking.status }}
                            </p>

                            <p
                              v-if="booking.status === 'canceled'"
                              class="has-text-danger"
                            >
                              {{ booking.status }}
                            </p>
                          </td>
                          <td class="">
                            <!-- <button class="button is-small is-light mr-1 mb-1">Edit</button> -->
                            <button
                              v-if="booking.status !== 'canceled'"
                              @click="cancelBooking(booking.id)"
                              class="button is-small is-danger mr-1 has-text-white"
                            >
                              Cancel
                            </button>

                            <button
                              v-if="booking.status === 'canceled'"
                              class="button is-small"
                              title="Disabled button"
                              disabled
                            >
                              Cancel
                            </button>
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
                            :disabled="sliceend >= ongoingBookings.length"
                          >
                            Next
                          </button>
                        </div>
                        <!-- Add more rows as needed -->
                      </tbody>
                    </table>
                  </div>

                  <div
                    id="new-bookings"
                    v-show="activeTable === 'new-bookings'"
                    class="table-container"
                  >
                    <table
                      class="table is-fullwidth has-background-white"
                      style="border-radius: 20px"
                    >
                      <thead>
                        <tr>
                          <th>Booking ID</th>
                          <th>Car ID</th>
                          <th>Customer email</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Pickup location</th>
                          <th>Dropoff location</th>
                          <th>Reference code</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="booking in NewBookingsPaginated" :key="booking.id">
                          <td>{{ booking.id }}</td>
                          <td>{{ booking.car_id }}</td>
                          <td>{{ booking.email_address }}</td>
                          <td>{{ booking.start_date }}</td>
                          <td>{{ booking.end_date }}</td>
                          <td>{{ booking.pickuplocation }}</td>
                          <td>{{ booking.dropofflocation }}</td>
                          <td>{{ booking.reference_code }}</td>

                          <td>
                            <p
                              v-if="booking.status === 'confirmed'"
                              class="has-text-success"
                            >
                              {{ booking.status }}
                            </p>

                            <p
                              v-if="booking.status === 'pending'"
                              class="has-text-warning"
                            >
                              {{ booking.status }}
                            </p>

                            <p
                              v-if="booking.status === 'canceled'"
                              class="has-text-danger"
                            >
                              {{ booking.status }}
                            </p>
                          </td>
                          <td class="">
                            <!-- <button class="button is-small is-light mr-1 mb-1">Edit</button> -->
                            <button
                              v-if="booking.status !== 'canceled'"
                              @click="cancelBooking(booking.id)"
                              class="button is-small is-danger mr-1 has-text-white"
                            >
                              Cancel
                            </button>

                            <button
                              v-if="booking.status === 'canceled'"
                              class="button is-small"
                              title="Disabled button"
                              disabled
                            >
                              Cancel
                            </button>
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
                            :disabled="sliceend >= newBookings.length"
                          >
                            Next
                          </button>
                        </div>
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
import { ref, onMounted, computed } from "vue";
import axios from "axios";

import ManagementMenu from "../../components/ManagementMenu.vue";
import ManagementNavBar from "../../components/ManagementNavBar.vue";
import FooterElement from "../../components/FooterElement.vue";

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

    const data = ref([]);
    const today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format
    const slicestart = ref(0);
    const sliceend = ref(10);
    const isCanceledsuccssefully = ref(false);
    const BookingHasAlreadyBeenCanceled = ref(false);

    const activeTable = ref("all-bookings"); // Default active table

    function showTable(tableId) {
      slicestart.value = 0;
      sliceend.value = 10;
      activeTable.value = tableId;
    }

    // Function to fetch data using Axios
    const fetchData = async () => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/management/bookings`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });
        data.value = response.data;
      } catch (error) {
        handleUnauthorizedError(error);
      } finally {
        loading.value = false; // Stop loading
      }
    };

    // Computed property for ongoing bookings
    const ongoingBookings = computed(() =>
      data.value.filter(
        (booking) => booking.start_date < today && booking.end_date > today
      )
    );
    // Computed property for new bookings
    const newBookings = computed(() =>
      data.value.filter((booking) => booking.start_date > today)
    );

    const AllBookingsPaginated = computed(() => {
      return data.value.slice(slicestart.value, sliceend.value);
    });

    const OngoingBookingsPaginated = computed(() => {
      return ongoingBookings.value.slice(slicestart.value, sliceend.value);
    });

    const NewBookingsPaginated = computed(() => {
      return newBookings.value.slice(slicestart.value, sliceend.value);
    });

    // Get count of ongoing bookings
    const allBookingsCount = computed(() => data.value.length);

    const ongoingBookingsCount = computed(() => ongoingBookings.value.length);

    // Get count of new booking
    const newBookingsCount = computed(() => newBookings.value.length);

    // Methods for pagination
    const nextPage = () => {
      slicestart.value += 10;
      sliceend.value += 10;
    };

    const prevPage = () => {
      slicestart.value -= 10;
      sliceend.value -= 10;
    };

    ///////////////////////////////////

    const cancelBooking = async (id) => {
      // Show confirmation dialog
      const isConfirmed = confirm(
        "Are you sure you want to cancel the booking? By clicking 'Yes', the booking will be canceled and it's irreversible."
      );

      if (isConfirmed) {
        try {
          const response = await axios.get(
            `${config.API_BASE_URL}/management/bookings/cancel/${id}`,
            {
              headers: {
                Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
              },
            }
          );

          // If the response is empty or falsy, throw an error
          if (!response || response.status !== 200) {
            throw new Error("Failed to cancel the booking.");
          }

          cacellatibookingCancellationSuccessed();
        } catch (Exception) {
          // Handle error
          //   console.error("Error during booking cancellation:", error);

          bookingCancellationFailed();
          //Use Log here
        }
      } else {
        console.log("Booking cancellation aborted.");
      }
    };

    const cacellatibookingCancellationSuccessed = () => {
      // Set Updated to true

      isCanceledsuccssefully.value = true;
      fetchData();
      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isCanceledsuccssefully.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    const bookingCancellationFailed = () => {
      // Set Updated to true
      BookingHasAlreadyBeenCanceled.value = true;
      fetchData();
      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        BookingHasAlreadyBeenCanceled.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    // Call the function inside onMounted
    onMounted(() => {
      fetchData();
    });

    return {
      cancelBooking,
      data,
      ongoingBookings,
      newBookings,
      activeTable,
      showTable,
      AllBookingsPaginated,
      OngoingBookingsPaginated,
      NewBookingsPaginated,
      nextPage,
      prevPage,
      allBookingsCount,
      ongoingBookingsCount,
      newBookingsCount,
      isCanceledsuccssefully,
      BookingHasAlreadyBeenCanceled,
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
