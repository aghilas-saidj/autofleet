<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="container" style="min-height: 100vh">
        <div class="columns if-flex">
          <div class="column is-12">
            <router-link
              v-if="!loading"
              :to="`/management/cars`"
              class="button is-primary has-text-white"
              >View available cars</router-link
            >
            <router-link
              v-if="!loading"
              :to="`/management/carsmaintenance`"
              class="button is-warning has-text-white ml-2"
              >View under maintenance cars</router-link
            >

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
                              class="subtitle is-size-5 has-text-weight-bold"
                              style="
                                display: flex;
                                align-items: center;
                                color: #4a4a4a !important;
                              "
                            >
                              $ {{ carDetails.car.price_per_day }} / day
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
                              <font-awesome-icon
                                icon="user"
                                style="margin-right: 0.5rem"
                              />
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

                        <hr />

                        <router-link
                          :to="`/management/editcar/${carDetails.car.id}`"
                          class="button has-background-grey-light has-text-black mr-1 is-small"
                          >Edit car details</router-link
                        >

                        <router-link
                          :to="`/management/car/${carDetails.car.id}/availability`"
                          class="button is-primary has-text-white is-small has-text-weight-bold"
                          >Add new date availability</router-link
                        >

                        <router-link
                          :to="`/management/car/${carDetails.car.id}/locations`"
                          class="button is-primary has-text-white is-small has-text-weight-bold"
                          >Add location availability</router-link
                        >
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
                  <div class="column is-9">
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

                  <div class="column is-9">
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

                  <div class="column is-9">
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
                      {{ carDetails.car.refundable_security_deposit }}
                    </p>
                    <hr style="background-color: #f5f5f5 !important" />
                  </div>

                  <div class="column is-9">
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

                  <div class="column is-9">
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

                  <div class="column is-9">
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

                  <div class="column is-9">
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

                  <div class="column is-9">
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
                      <div class="hero-body">
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
                        class="subtitle is-6 has-text-weight-bold"
                        style="color: #4a4a4a !important"
                      >
                        Good to know
                      </div>
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
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

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

    const route = useRoute(); // Get the current route object
    const id = route.params.id; // Extract the `id` parameter from the URL

    // const router = useRouter(); // Initialize the router

    const carDetails = ref([]);

    const fetchData = async (id) => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/management/cars/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });

        carDetails.value = response.data;

        //  console.log(carDetails.value);

        return response;
      } catch (error) {
        handleUnauthorizedError(error);
        console.log("Getting car's data incomplete");
      } finally {
        loading.value = false; // Stop loading
      }
    };

    onMounted(() => {
      fetchData(id);
    });

    return { carDetails, loading };
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
