<template>
  <div>
    <!-- Navbar -->
    <NavBar />

    <!--START :: Return to the previous page -->

    <div class="button is-white is-small">
      <router-link to="/cars" class="">
        <span class="icon">
          <font-awesome-icon icon="arrow-left" style="margin-right: 0.5rem" />
        </span>

        <span>View All Cars</span></router-link
      >
    </div>
    <!-- END -->

    <!-- START :: Price Breakdown section, right side(on-desktop), bottom (on-mobile) -->

    <div class="column is-narrow is-hidden-tablet is-hidden-de">
      <div
        @click="scrollToBottom"
        class="button has-text-weight-bold has-text-white is-primary scroll-to-bottom is-small"
        style="position: sticky; bottom: 0px"
      >
        <span>Price Breakdown</span>
        <span class="icon">
          <i class="fas fa-arrow-right"></i>
        </span>
      </div>
    </div>
    <!-- END -->

    <div class="container" style="min-height: 100vh">
      <div class="columns if-flex">
        <div class="column is-9">
          <div
            v-if="loading"
            style="
              display: flex;
              justify-content: center;
              align-items: center;
              height: 100vh;
            "
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

          <!-- START :: In case The user had access to the unavailable car page, a warning message will be showed -->

          <div class="notification is-danger" v-if="unavailableDates">
            <p class="title is-6" style="color: white !important">
              This car is unavailable for the selected dates.
            </p>

            <router-link to="/cars" class="button is-primary has-text-white ml-2">
              <span>Change dates</span></router-link
            >
          </div>

          <!-- END -->

          <!-- START :: Car details are shown below.-->

          <div v-if="carDetails && carDetails.car" class="card is-flex">
            <div class="card-content">
              <div class="columns is-flex">
                <!-- Image Section -->
                <div class="column is-5-mobile is-3-tablet is-3-desktop">
                  <figure class="image is-256x256">
                    <img
                      :src="`https://carrentalsystemimages.s3.eu-north-1.amazonaws.com/${carDetails.car.image_path}`"
                      alt="Car Image"
                    />
                  </figure>
                  <span class="tag is-link is-light has-text-weight-bold">{{
                    carDetails.car.transmission
                  }}</span>
                  <span class="tag is-primary is-light has-text-weight-bold">{{
                    carDetails.car.type
                  }}</span>
                  <!-- <p class="subtitle is-6  has-text-weight-bold">⭐⭐⭐☆☆</p> -->
                </div>

                <!-- Details Section -->
                <div class="column is-7-mobile is-9-tablet is-9-desktop">
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
                        <p
                          class="title is-5 has-text-weight-bold"
                          style="
                            display: flex;
                            align-items: center;
                            color: #4a4a4a !important;
                          "
                        >
                          {{ carDetails.car.name }}
                        </p>

                        <div>
                          <p
                            class="subtitle is-size-7 has-text-weight-bold"
                            style="
                              display: flex;
                              align-items: center;
                              color: #4a4a4a !important;
                            "
                          >
                            <font-awesome-icon
                              icon="suitcase"
                              style="margin-right: 0.5rem"
                            />
                            {{ carDetails.car.bags }} bag(s)
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
                            />
                            {{ carDetails.car.doors }} doors
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
                            {{ carDetails.car.seats }} seats
                          </p>

                          <div>
                            <p
                              v-if="carDetails.car.airconditioning === 1"
                              class="subtitle is-size-7 has-text-weight-bold"
                              style="
                                display: flex;
                                align-items: center;
                                color: #4a4a4a !important;
                              "
                            >
                              <font-awesome-icon
                                icon="fan"
                                style="margin-right: 0.5rem"
                              />
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
                              <font-awesome-icon
                                icon="cogs"
                                style="margin-right: 0.5rem"
                              />
                              {{ carDetails.car.engine_type }}
                            </p>

                            <p
                              v-if="carDetails.car.is_unlimited_mileage === 1"
                              class="subtitle is-size-7 has-text-weight-bold"
                              style="
                                display: flex;
                                align-items: center;
                                color: #4a4a4a !important;
                              "
                            >
                              <font-awesome-icon
                                icon="road"
                                style="margin-right: 0.5rem"
                              />
                              Unlimited Mileage
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div
                      class="column is-6"
                      style="
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        text-align: center;
                      "
                    >
                      <br />
                      <br />
                    </div>
                  </div>
                </div>
              </div>

              <hr style="background-color: #f5f5f5 !important" />

              <div class="columns is-multiline">
                <div
                  class="column is-9"
                  v-if="carDetails.car.description !== 'undefined'"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Description
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    {{ carDetails.car.description }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div
                  class="column is-9"
                  v-if="carDetails.car.fuel_policy !== 'undefined'"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Fuel policy
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    {{ carDetails.car.fuel_policy }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div
                  class="column is-9"
                  v-if="carDetails.car.refundable_security_deposit !== 0"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Refundable security deposite
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    $ {{ carDetails.car.refundable_security_deposit }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div
                  class="column is-9"
                  v-if="carDetails.car.included_insurance !== 'undefined'"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Included insurance
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    {{ carDetails.car.included_insurance }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div
                  class="column is-9"
                  v-if="carDetails.car.Theft_Protection !== 'undefined'"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Theft protection
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    {{ carDetails.car.Theft_Protection }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div
                  class="column is-9"
                  v-if="carDetails.car.roadside_assistance !== 'undefined'"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Roadside assistance
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    {{ carDetails.car.roadside_assistance }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div
                  class="column is-9"
                  v-if="carDetails.car.third_party_liability !== 'undefined'"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Third party liability
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    {{ carDetails.car.third_party_liability }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div
                  class="column is-9"
                  v-if="carDetails.car.collision_damage_waiver !== 'undefined'"
                >
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    collition damage waiver
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    {{ carDetails.car.collision_damage_waiver }}
                  </p>
                  <hr style="background-color: #f5f5f5 !important" />
                </div>

                <div class="column is-9">
                  <p
                    class="subtitle is-6 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    You should bring with you
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Identification document
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Drive licence
                  </p>
                  <p
                    class="subtitle is-7 has-text-weight-bold"
                    style="color: #4a4a4a !important"
                  >
                    Security deposit by cash
                  </p>

                  <hr style="background-color: #f5f5f5 !important" />
                  <section
                    v-if="carDetails && carDetails.car"
                    class="hero"
                    style="background-color: #eee"
                  >
                    <div
                      class="hero-body"
                      v-if="carDetails.car.cancellation_policy !== 'undefined'"
                    >
                      <p
                        class="subtitle is-6 has-text-weight-bold"
                        style="color: #4a4a4a !important"
                      >
                        Cancellation policy
                      </p>
                      <p
                        class="subtitle is-7 has-text-weight-bold"
                        style="color: #4a4a4a !important"
                      >
                        {{ carDetails.car.cancellation_policy }}
                      </p>
                    </div>
                  </section>

                  <hr style="background-color: #f5f5f5 !important" />

                  <div v-if="carDetails && carDetails.car">
                    <div
                      v-if="carDetails.car.better_to_know !== 'undefined'"
                      class="subtitle is-6 has-text-weight-bold"
                      style="color: #4a4a4a !important"
                    >
                      Good to know:

                      <p
                        class="subtitle is-7 has-text-weight-bold"
                        style="color: #4a4a4a !important"
                      >
                        {{ carDetails.car.better_to_know }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- END car details-->
        </div>

        <div class="column is-3 card-container">
          <div
            v-if="carDetails && carDetails.car"
            id="price-breakdown"
            class="card"
            style="position: sticky; top: 20px"
          >
            <!-- START :: If the user does not select a specific pickup or dropoff location, he will be asked to select one location (where the specified vehicle is available)..-->

            <div
              v-if="pickupLocation === 'any' || dropoffLocation === 'any'"
              class="notification is-warning"
            >
              To proceed with your booking, please choose pickup and drop-off locations
              where this car is available.
              <br />

              <div
                v-if="pickupsLocations && pickupsLocations.length > 0"
                class="select ml-1 full-width"
              >
                <select v-model="pickupLocation" class="has-text-black full-width">
                  <option value="" disabled>Select a pickup location</option>
                  <option
                    v-for="(location, index) in pickupsLocations"
                    :key="index"
                    :value="location.name"
                  >
                    {{ location.name }}
                  </option>
                </select>
              </div>

              <div
                v-if="dropoffsLocations && dropoffsLocations.length > 0"
                class="select ml-1 full-width"
              >
                <select v-model="dropoffLocation" class="has-text-black full-width">
                  <option value="" disabled>Select a dropoff location</option>
                  <option
                    v-for="(location, index) in dropoffsLocations"
                    :key="index"
                    :value="location.name"
                  >
                    {{ location.name }}
                  </option>
                </select>
              </div>
            </div>

            <!-- END -->

            <!-- START :: Info about prices and periods.-->

            <div class="card-content">
              Price breakdown

              <div>
                <div class="column is-9">
                  <p class="subtitle is-7" style="color: #4a4a4a !important">
                    Price per day:
                  </p>
                  <p class="title is-4" style="color: #4a4a4a !important">
                    ${{ carDetails.car.price_per_day }}
                  </p>

                  <hr style="background-color: #f5f5f5 !important" />

                  <p class="subtitle is-7" style="color: #4a4a4a !important">Duration:</p>
                  <p class="title is-6" style="color: #4a4a4a !important">
                    {{ carDetails.totalPrice.original.booking_period.days }} Days ,
                    {{ carDetails.totalPrice.original.booking_period.h }} hours,
                    {{ carDetails.totalPrice.original.booking_period.m }} minutes
                  </p>

                  <hr style="background-color: #f5f5f5 !important" />

                  <div>
                    <p class="subtitle is-7" style="color: #4a4a4a !important">
                      Total Price:
                    </p>
                    <p class="title is-4" style="color: #4a4a4a !important">
                      ${{ carDetails.totalPrice.original.total_price }}
                    </p>

                    <router-link
                      to="/checkout"
                      class="button has-text-white"
                      :class="[
                        { 'is-disabled': isButtonDisabled || unavailableDates },
                        {
                          'is-primary': !(isButtonDisabled || unavailableDates),
                          'is-light': isButtonDisabled || unavailableDates,
                        },
                      ]"
                      :style="{
                        pointerEvents:
                          isButtonDisabled || unavailableDates ? 'none' : 'auto',
                      }"
                    >
                      Pay now
                    </router-link>
                  </div>
                </div>
              </div>
            </div>

            <!-- END -->
          </div>
        </div>
      </div>
    </div>

    <br />

    <div class="card">
      <FooterElement />
    </div>
  </div>
</template>

<script>
import { ref, onMounted, watch, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios"; // Make sure you have axios installed
import NavBar from "../../components/NavBar.vue";
import FooterElement from "../../components/FooterElement.vue";
import config from "@/config";

import ProgressBar from "@/components/ProgressBar.vue";

export default {
  components: {
    NavBar,
    FooterElement,
    ProgressBar,
  },

  setup() {
    const loading = ref(true);

    const route = useRoute();
    const router = useRouter();

    const id = route.params.id;

    const isAuth = ref(localStorage.getItem("Authentication_status") === "true");

    const unavailableDates = ref(false);

    const dropoffsLocations = ref([]);

    const pickupsLocations = ref([]);

    //START :: get data from localStorage.

    const pickupLocation = ref(localStorage.getItem("pickupLocation") || "any");
    const pickupDate = ref(localStorage.getItem("pickupDate") || "");
    const pickupTime = ref(localStorage.getItem("pickupTime") || "");
    const dropoffLocation = ref(localStorage.getItem("dropoffLocation") || "any");
    const dropoffDate = ref(localStorage.getItem("dropoffDate") || "");
    const dropoffTime = ref(localStorage.getItem("dropoffTime") || "");
    //END.

    const carID = ref(id);
    const carDetails = ref(null);

    //START :: Function to fetch data from Laravel API

    const fetchCarDetails = async (
      id,
      pickup,
      dropoff,
      pickupLocation,
      dropoffLocation
    ) => {
      let apiUrl = "";
      const token = localStorage.getItem("token"); // Get token from localStorage

      //START :: There are 2 different API endpoints, one is for guests , other is for the autheticated users,
      // Check if the user is authenticated
      if (localStorage.getItem("Authentication_status") === "true") {
        // Authenticated users: Use authenticated API
        apiUrl = `${config.API_BASE_URL}/cars/${id}/${pickup}/${dropoff}/${pickupLocation}/${dropoffLocation}`;
      } else {
        // Guest users: Use guest API
        apiUrl = `${config.API_BASE_URL}/guest/cars/${id}/${pickup}/${dropoff}/${pickupLocation}/${dropoffLocation}`;
      }

      //END

      try {
        // Make the API request
        let response = await axios.get(apiUrl, {
          headers: token ? { Authorization: `Bearer ${token}` } : {},
        });

        carDetails.value = response.data;

        // If the user attempts to access the car details page for a car that is unavailable at the selected location,
        // they will be redirected to the car search page to view available options.

        if (response.data["message"] === "Car not available at the selected locations") {
          localStorage.setItem("pickupLocation", "any");
          localStorage.setItem("dropoffLocation", "any");
          router.push("/cars");
        }

        //END

        if (response.data.confirmation.original === false) {
          unavailableDates.value = true;
        }

        carDetails.value = response.data; // Store the fetched data

        // After you get the response data
        dropoffsLocations.value = response.data.dropoffsLocations.filter(
          (value, index, self) =>
            index ===
            self.findIndex(
              (t) => t.name === value.name // Filter based on the 'name' property
            )
        );

        pickupsLocations.value = response.data.PickupLocations.filter(
          (value, index, self) =>
            index ===
            self.findIndex(
              (t) => t.name === value.name // Filter based on the 'name' property
            )
        );

        //  console.log(response.data);
      } catch (error) {
        localStorage.setItem("Authentication_status", "false");
        console.error("Error fetching car details:", error);

        // Recursive call to fetch the car details again if an error occurs
        //await fetchCarDetails(id, pickup, dropoff, pickupLocation, dropoffLocation);
      } finally {
        loading.value = false; // Stop loading
      }
    };

    onMounted(async () => {
      const fromDate = pickupDate.value;
      const toDate = dropoffDate.value;
      const pickup = `${fromDate} ${pickupTime.value}`;
      const dropoff = `${toDate} ${dropoffTime.value}`;
      localStorage.setItem("carID", carID.value);

      fetchCarDetails(id, pickup, dropoff, pickupLocation.value, dropoffLocation.value);
    });

    const scrollToBottom = () => {
      const priceBreakdown = document.getElementById("price-breakdown");
      if (priceBreakdown) {
        priceBreakdown.scrollIntoView({
          behavior: "smooth",
        });
      }
    };

    const updatePickupLocation = () => {
      localStorage.setItem("pickupLocation", pickupLocation.value);
    };

    // You can also watch for changes to selectedPickupLocation to automatically update localStorage
    watch(pickupLocation, (newValue) => {
      localStorage.setItem("pickupLocation", newValue);
    });

    const updateDropoffLocation = () => {
      localStorage.setItem("dropoffLocation", dropoffLocation.value);
    };

    // You can also watch for changes to selectedPickupLocation to automatically update localStorage
    watch(dropoffLocation, (newValue) => {
      localStorage.setItem("dropoffLocation", newValue);
    });

    const isButtonDisabled = computed(() => {
      return pickupLocation.value === "any" || dropoffLocation.value === "any";
    });

    return {
      id,
      pickupLocation,
      pickupDate,
      pickupTime,
      dropoffLocation,
      dropoffDate,
      dropoffTime,
      carDetails,
      scrollToBottom,
      dropoffsLocations,
      pickupsLocations,
      updateDropoffLocation,
      updatePickupLocation,
      isButtonDisabled,
      isAuth,
      unavailableDates,
      loading,
    };
  },
};
</script>

<style>
body {
  background-color: white;
}

.image {
  display: flex;
  justify-content: center;
  align-items: center;
}

.image img {
  object-fit: cover;
  width: 100%;
  height: 100%;
  border-radius: 8px;
}

.card-content {
  padding: 1rem;
}

.card {
  box-shadow: 0 0.5em 1em -0.125em rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.02) !important; /* Force priority */
  border-radius: 0.25rem;
  background-color: white !important; /* Force priority */

  display: flex;
  flex-direction: column; /* Ensures content stacks vertically */
  width: 100%; /* Full width */

  color: #4a4a4a !important;
  max-width: 100%;
  position: relative;
}

input {
  background-color: white !important; /* Force priority */
}
select {
  background-color: white !important; /* Force priority */
}

.card {
  margin-top: 1%;
}

.search-section {
  margin-top: 1%;
}

.search-section {
  margin-top: 1%;
}

.search-properties {
  margin-top: 1%;
}
.container {
  margin-top: 1%;
}

.full-width {
  width: 100%; /* Makes the element take the full width of its container */
}

.select {
  margin-bottom: 1rem; /* Adds some spacing between the dropdowns */
}
</style>
