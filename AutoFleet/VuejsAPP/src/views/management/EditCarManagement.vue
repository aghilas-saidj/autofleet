<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="custom-container" style="min-height: 100vh">
        <div class="columns if-flex">
          <div class="column is-12">
            <hr
              style="
                background-color: #f5f5f5;
                border: none;
                display: block;
                height: 2px;
                margin: 1.5rem 0;
              "
            />

            <router-link
              :to="`/management/cars`"
              class="button is-primary has-text-white mt-1 mb-2"
              >View available cars</router-link
            >
            <router-link
              :to="`/management/carsmaintenance`"
              class="button is-warning has-text-white ml-2 mt-1 mb-2"
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

                    <div class="box has-background-white">
                      <label class="file-label">
                        <input
                          class="file-input"
                          type="file"
                          name="image"
                          @change="handleFileUpload"
                        />
                        <div class="button is-primary is-small has-text-white">
                          Change a picture
                        </div>
                      </label>
                      <span class="file-name has-text-black subtitle is-7">
                        {{ fileName || "No file selected" }}
                      </span>
                    </div>

                    <span class="tag is-link is-light has-text-weight-bold">
                      <input
                        class="input is-link has-text-black is-small"
                        type="text"
                        v-model="newTransmission"
                      />
                    </span>
                    <span class="tag is-primary is-light has-text-weight-bold mt-2">
                      <input
                        class="input is-primary has-text-black is-small"
                        type="text"
                        v-model="newType"
                      />
                    </span>
                    <!-- <p class="subtitle is-6  has-text-weight-bold">⭐⭐⭐☆☆</p> -->
                  </div>

                  <!-- Details Section -->
                  <div class="column is-7-mobile is-9-tablet is-9-desktop">
                    <div class="columns">
                      <div
                        class="column is-12-mobile is-12-tablet is-12-desktop"
                        style="
                          display: flex;
                          flex-direction: column;
                          align-items: center;
                          text-align: center;
                          gap: 0.5rem;
                        "
                      >
                        <div>
                          <input
                            class="input has-text-black is-small"
                            type="text"
                            v-model="newName"
                          />

                          <hr
                            style="
                              background-color: #f5f5f5;
                              border: none;
                              display: block;
                              height: 2px;
                              margin: 1.5rem 0;
                            "
                          />

                          <p>
                            $
                            <input
                              class="input has-text-black is-small"
                              type="number"
                              v-model="newPricePerDay"
                              style="width: 100px; text-align: center"
                            />
                            per day
                          </p>
                          <hr
                            style="
                              background-color: #f5f5f5;
                              border: none;
                              display: block;
                              height: 2px;
                              margin: 1.5rem 0;
                            "
                          />
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
                              <input
                                class="input has-text-black is-small"
                                type="number"
                                v-model="newBags"
                                style="width: 80px; text-align: center"
                              />
                              bag(s)
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
                              <input
                                class="input has-text-black is-small"
                                type="number"
                                v-model="newDoors"
                                style="width: 80px; text-align: center"
                              />
                              doors
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
                              <input
                                class="input has-text-black is-small"
                                type="number"
                                v-model="newSeats"
                                style="width: 80px; text-align: center"
                              />
                              seats
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
                                  icon="fan"
                                  style="margin-right: 0.5rem"
                                />
                                Air Conditioning :
                                <label class="radio has-text-black mr-2">
                                  <input
                                    type="radio"
                                    name="air_conditioning"
                                    :value="1"
                                    v-model="newAirconditioning"
                                  />
                                  Yes
                                </label>
                                <label class="radio has-text-black">
                                  <input
                                    type="radio"
                                    name="air_conditioning"
                                    :value="0"
                                    v-model="newAirconditioning"
                                  />
                                  No
                                </label>
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
                                <input
                                  class="input has-text-black is-small"
                                  type="text"
                                  v-model="newEngineType"
                                  style="width: 100px; text-align: center"
                                />
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
                                  icon="road"
                                  style="margin-right: 0.5rem"
                                />
                                Unlimited Mileage :

                                <label class="radio has-text-black mr-2">
                                  <input
                                    type="radio"
                                    name="Unlimited_Mileage"
                                    :value="1"
                                    v-model="newUnlimitedMileage"
                                  />
                                  Yes
                                </label>
                                <label class="radio has-text-black">
                                  <input
                                    type="radio"
                                    name="Unlimited_Mileage"
                                    :value="0"
                                    v-model="newUnlimitedMileage"
                                  />
                                  No
                                </label>
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
                      <input
                        class="input has-text-black is-small"
                        type="text"
                        v-model="newDescription"
                      />
                    </p>
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
                      <input
                        class="input has-text-black is-small"
                        type="text"
                        v-model="newFuelPolicy"
                      />
                    </p>
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
                      <input
                        class="input has-text-black is-small"
                        type="number"
                        v-model="newRefundableSecurityDeposite"
                      />
                    </p>
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
                      <input
                        class="input has-text-black is-small"
                        type="text"
                        v-model="newIncludedInsurance"
                      />
                    </p>
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

                  <div class="column is-9">
                    <p
                      class="subtitle is-6 has-text-weight-bold"
                      style="color: #4a4a4a !important"
                    >
                      Theft Protection
                    </p>
                    <p
                      class="subtitle is-7 has-text-weight-bold"
                      style="color: #4a4a4a !important"
                    >
                      <input
                        class="input has-text-black is-small"
                        type="text"
                        v-model="newTheftProtection"
                      />
                    </p>
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
                      <input
                        class="input has-text-black is-small"
                        type="text"
                        v-model="newRoadsideAssistance"
                      />
                    </p>
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
                      <input
                        class="input has-text-black is-small"
                        type="text"
                        v-model="newThirdPartyLiability"
                      />
                    </p>
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
                      <input
                        class="input has-text-black is-small"
                        type="text"
                        v-model="newCollitionDamageWaiver"
                      />
                    </p>
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

                    <hr
                      style="
                        background-color: #f5f5f5;
                        border: none;
                        display: block;
                        height: 2px;
                        margin: 1.5rem 0;
                      "
                    />
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
                          <input
                            class="input has-text-black is-small"
                            type="text"
                            v-model="newCancellationPolicy"
                          />
                        </p>
                      </div>
                    </section>

                    <hr
                      style="
                        background-color: #f5f5f5;
                        border: none;
                        display: block;
                        height: 2px;
                        margin: 1.5rem 0;
                      "
                    />
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
                        <input
                          class="input has-text-black is-small"
                          type="text"
                          v-model="newGoodToKnow"
                        />
                      </p>
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
                    <div v-if="Updated" class="hero is-success has-text-white">
                      Car details have been updated
                    </div>
                    <button @click="save(id)" class="button is-primary has-text-white">
                      Save
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

    const Updated = ref(false);
    const route = useRoute(); // Get the current route object
    const id = route.params.id; // Extract the `id` parameter from the URL
    const carDetails = ref([]);

    const newName = ref();
    const newBags = ref(0);
    const newDoors = ref(0);
    const newSeats = ref(0);
    const newAirconditioning = ref(0);
    const newUnlimitedMileage = ref(0);
    const newEngineType = ref();
    const newTransmission = ref();
    const newType = ref();
    const newPricePerDay = ref();
    const newTheftProtection = ref();
    const newThirdPartyLiability = ref();
    const newRoadsideAssistance = ref();

    const newDescription = ref();
    const newFuelPolicy = ref();
    const newRefundableSecurityDeposite = ref(0);
    const newIncludedInsurance = ref();
    const newCollitionDamageWaiver = ref();
    const newCancellationPolicy = ref();
    const newGoodToKnow = ref();

    const file = ref(null);
    const fileName = ref("");

    const fetchData = async (id) => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/management/cars/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });

        carDetails.value = response.data;

        newName.value = response.data.car.name;
        newBags.value = response.data.car.bags;
        newDoors.value = response.data.car.doors;
        newSeats.value = response.data.car.seats;
        newTransmission.value = response.data.car.transmission;
        newType.value = response.data.car.type;
        newTheftProtection.value = response.data.car.Theft_Protection;
        newPricePerDay.value = response.data.car.price_per_day;
        newRoadsideAssistance.value = response.data.car.roadside_assistance;
        newThirdPartyLiability.value = response.data.car.third_party_liability;
        newAirconditioning.value = response.data.car.airconditioning;
        newEngineType.value = response.data.car.engine_type;
        newUnlimitedMileage.value = response.data.car.is_unlimited_mileage;
        newDescription.value = response.data.car.description;
        newFuelPolicy.value = response.data.car.fuel_policy;
        newRefundableSecurityDeposite.value =
          response.data.car.refundable_security_deposit;
        newIncludedInsurance.value = response.data.car.included_insurance;
        newCollitionDamageWaiver.value = response.data.car.collision_damage_waiver;
        newCancellationPolicy.value = response.data.car.cancellation_policy;
        newGoodToKnow.value = response.data.car.better_to_know;

        return response;
      } catch (error) {
        handleUnauthorizedError(error);
        console.log("Getting data incomplete");
      } finally {
        loading.value = false; // Stop loading
      }
    };

    function isEmpty(value) {
      return value === null || value === undefined || value === "";
    }

    const save = async (id) => {
      ///////////////////////////////////////////////////

      ///////////////////////////////////////////////////

      if (
        typeof newName.value !== "string" ||
        newName.value.length <= 3 ||
        newName.value.length >= 70
      ) {
        alert("Invalid name. The name must be a string between 3 and 70 characters.");
        return;
      }

      ////////////////////////////////////////

      const price = parseFloat(newPricePerDay.value);

      // Check if the value is a valid positive float number
      if (isNaN(price) || price < 0 || price > 10000) {
        alert("Invalid price. The price must be a positive number.");
        return;
      }

      ////////////////////////////////////////////

      const bags = parseInt(newBags.value, 10);

      // Check if the value is a valid number between 1 and 19
      if (typeof newBags.value !== "number" || isNaN(bags) || bags < 0 || bags > 20) {
        alert(
          "Invalid number of bags. It should be a number greater than 0 and less than 20."
        );
        return;
      }

      ////////////////////////////////////////////////

      const doors = parseInt(newDoors.value, 10);

      // Check if the value is a valid number between 1 and 19
      if (typeof newDoors.value !== "number" || isNaN(doors) || doors < 0 || doors > 20) {
        alert(
          "Invalid number of doors. It should be a number greater than 0 and less than 20."
        );
        return;
      }

      ////////////////////////////////////////////////

      const seats = parseInt(newSeats.value, 10);

      // Check if the value is a valid number between 1 and 19
      if (typeof newSeats.value !== "number" || isNaN(seats) || seats < 0 || seats > 20) {
        alert(
          "Invalid number of seats. It should be a number greater than 0 and less than 20."
        );
        return;
      }

      ////////////////////////////////////////////////

      const SecurityDeposite = parseFloat(newRefundableSecurityDeposite.value);

      // Check if the value is a valid positive float number
      if (
        typeof SecurityDeposite !== "number" ||
        isNaN(SecurityDeposite) ||
        SecurityDeposite > 100000
      ) {
        alert(
          "Invalid Security Deposite. The Security Deposite must be a positive number 0-100000."
        );
        return;
      }

      ////////////////////////////////////////////

      if (typeof newEngineType.value !== "string" && newEngineType.value.length > 11) {
        alert("Invalid engine type. It must be a string with less than 11 characters.");
        return;
      }

      /////////////////////////////////////////////////////

      if (
        typeof newTransmission.value !== "string" &&
        newTransmission.value.length > 11
      ) {
        alert(
          "Invalid transmission type. It must be a string with less than 11 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (typeof newType.value !== "string" && newType.value.length > 11) {
        alert("Invalid type type. It must be a string with less than 11 characters.");
        return;
      }

      ///////////////////////////////
      ///////////////////////////////
      /////////////////////////////////////////////////////
      ////////////////////////////////////
      if (
        typeof newDescription.value !== "string" ||
        newDescription.value.length < 10 ||
        newDescription.value.length > 200
      ) {
        alert("Invalid description type. It must be a string with 10 - 200 characters.");
        return;
      }

      /////////////////////////////////////////////////////

      if (newTheftProtection.value.length > 200) {
        alert(
          "Invalid theft protection type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (newThirdPartyLiability.value.length > 200) {
        alert(
          "Invalid third party liability type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (newRoadsideAssistance.value.length > 200) {
        alert(
          "Invalid roadside assistance type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (newFuelPolicy.value.length > 200) {
        alert(
          "Invalid fuel policy type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (newIncludedInsurance.value.length > 200) {
        alert(
          "Invalid included insurance type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (newCollitionDamageWaiver.value.length > 200) {
        alert(
          "Invalid collition damage waiver type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (newCancellationPolicy.value.length > 200) {
        alert(
          "Invalid cancellation policy type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (newGoodToKnow.value.length > 200) {
        alert(
          "Invalid good to know type. It must be a string with less than 200 characters."
        );
        return;
      }
      ///////////////////////

      if (newAirconditioning.value === 1) {
        newAirconditioning.value = 1;
      } else {
        newAirconditioning.value = 0;
      }

      if (newUnlimitedMileage.value === 1) {
        newUnlimitedMileage.value = 1;
      } else {
        newUnlimitedMileage.value = 0;
      }

      /////////////////////////////////

      try {
        if (!id) {
          console.error("❌ Car ID is missing!");
          return;
        }

        const fields = [
          newTheftProtection,
          newRoadsideAssistance,
          newThirdPartyLiability,
          newEngineType,
          newFuelPolicy,
          newIncludedInsurance,
          newCollitionDamageWaiver,
          newCancellationPolicy,
          newGoodToKnow,
        ];

        fields.forEach((field) => {
          if (isEmpty(field.value)) {
            field.value = "undefined";
          }
        });

        let updatedData = {
          name: newName.value ?? null,
          bags: newBags.value ?? null,
          doors: newDoors.value ?? null,
          seats: newSeats.value ?? null,
          airconditioning: newAirconditioning.value ?? null,
          engine_type: newEngineType.value ?? null,
          is_unlimited_mileage: newUnlimitedMileage.value ?? null,
          transmission: newTransmission.value ?? null,
          type: newType.value ?? null,
          price_per_day: newPricePerDay.value ?? null,
          Theft_Protection: newTheftProtection.value ?? null,
          third_party_liability: newThirdPartyLiability.value ?? null,
          roadside_assistance: newRoadsideAssistance.value ?? null,
          description: newDescription.value ?? null,
          fuel_policy: newFuelPolicy.value ?? null,
          refundable_security_deposit: newRefundableSecurityDeposite.value ?? null,
          included_insurance: newIncludedInsurance.value ?? null,
          collision_damage_waiver: newCollitionDamageWaiver.value ?? null,
          cancellation_policy: newCancellationPolicy.value ?? null,
          better_to_know: newGoodToKnow.value ?? null,
        };

        // Loop through the object and delete keys with null values

        const update = await axios.post(
          `${config.API_BASE_URL}/management/cars/${id}`, // Replace with your API endpoint
          updatedData,

          {
            headers: {
              "Content-Type": "application/json",
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        if (update) {
          updateStatus();
          fetchData(id);
        }
      } catch (error) {
        handleUnauthorizedError(error);
        console.log("Saving data  incomplete");
      }
    };

    const updateStatus = () => {
      // Set Updated to true
      Updated.value = true;

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        Updated.value = false;
      }, 4000); // 4000ms = 4 seconds
    };

    const handleFileUpload = (event) => {
      file.value = event.target.files[0];
      fileName.value = file.value ? file.value.name : "No file selected";
      submitImage(id);
    };

    ///////////////////////////////

    const submitImage = async (id) => {
      try {
        const formData = new FormData();

        if (file.value) {
          formData.append("image", file.value);
        }

        const response = await axios.post(
          `${config.API_BASE_URL}/management/cars/${id}`,
          formData,

          {
            headers: {
              "Content-Type": "multipart/form-data",
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        if (response) {
          console.log("Image added");
        }

        alert("Car added successfully!");
        fetchData(id);
      } catch (error) {
        handleUnauthorizedError(error);
        alert("Failed to add car.");
      }
    };

    /////////////////////////////////////////////////////////////

    onMounted(() => {
      fetchData(id);
    });

    return {
      carDetails,
      newName,
      newBags,
      newDoors,
      newSeats,
      newAirconditioning,
      newEngineType,
      newUnlimitedMileage,
      newTransmission,
      newThirdPartyLiability,
      newType,
      newTheftProtection,
      newRoadsideAssistance,
      newPricePerDay,
      newDescription,
      newFuelPolicy,
      newRefundableSecurityDeposite,
      newIncludedInsurance,
      newCollitionDamageWaiver,
      newCancellationPolicy,
      newGoodToKnow,
      id,
      save,
      Updated,
      handleFileUpload,
      fileName,
      loading,
      submitImage,
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
