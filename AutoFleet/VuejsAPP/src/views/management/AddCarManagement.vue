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
            :to="`/management/cars`"
            class="button is-primary has-text-white mt-1 mb-2"
            >View available cars</router-link
          >
          <router-link
            :to="`/management/carsmaintenance`"
            class="button is-warning has-text-white ml-2 mt-1 mb-2"
            >View under maintenance cars</router-link
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

          <article class="message is-info">
            <div class="message-header">
              <p>Info</p>
            </div>
            <div class="message-body">
              <strong>Important Steps:</strong> To make your car available for clients,
              please follow these 3 steps:
              <ul>
                <li><strong>Step 1:</strong> Complete the car details form below.</li>
                <li>
                  <strong>Step 2:</strong> Manage availability by adding the car's
                  available dates and times under the "Manage availability" section. .
                </li>
                <li>
                  <strong>Step 3:</strong> Add the car's pickup and dropoff locations
                  under the "Manage locations" section.
                </li>
              </ul>
              Once all steps are completed, your car will be visible to clients.
            </div>
          </article>

          <hr
            style="
              background-color: #f5f5f5;
              border: none;
              display: block;
              height: 2px;
              margin: 1.5rem 0;
            "
          />

          <div class="file has-name is-boxed">
            <label class="file-label">
              <input
                class="file-input"
                type="file"
                name="image"
                @change="handleFileUpload"
              />
              <span class="file-cta" style="background-color: #00d1b2">
                <span class="file-icon">
                  <i class="fas fa-upload"></i>
                </span>
                <span class="file-label"> Choose a file… </span>
              </span>
              <span class="file-name has-text-black">
                {{ fileName || "No file selected" }}
              </span>
            </label>
          </div>

          <div class="columns is-multiline">
            <div class="column is-12 is-flex">
              <div class="field mr-3">
                <label class="label has-text-black">Name</label>
                <div class="control">
                  <input
                    maxlength="60"
                    style="width: 400px; text-align: center"
                    class="input has-text-black"
                    type="text"
                    placeholder="Text input"
                    v-model="newName"
                  />
                </div>
              </div>

              <div class="field">
                <label class="label has-text-black">Price per day ($)</label>

                <div class="control is-flex">
                  <input
                    style="width: 100px; text-align: center"
                    class="input has-text-black"
                    type="number"
                    placeholder="Text input"
                    v-model="newPricePerDay"
                  />
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
            <div class="column is-3">
              <div class="field">
                <label class="label has-text-black">Bags</label>
                <div class="control">
                  <input
                    style="width: 100px; text-align: center"
                    class="input has-text-black"
                    type="number"
                    placeholder="Text input"
                    v-model="newBags"
                    min="0"
                  />
                </div>
              </div>

              <div class="field">
                <label class="label has-text-black">Doors</label>
                <div class="control">
                  <input
                    style="width: 100px; text-align: center"
                    class="input has-text-black"
                    type="number"
                    placeholder="Text input"
                    v-model="newDoors"
                  />
                </div>
              </div>
            </div>

            <div class="column is-3">
              <div class="field">
                <label class="label has-text-black">Seats</label>
                <div class="control">
                  <input
                    style="width: 100px; text-align: center"
                    class="input has-text-black"
                    type="number"
                    placeholder="Text input"
                    v-model="newSeats"
                  />
                </div>
              </div>

              <div class="field">
                <label class="label has-text-black">Engine type</label>
                <div class="control">
                  <input
                    style="width: 100px; text-align: center"
                    class="input has-text-black"
                    type="text"
                    placeholder="Text input"
                    v-model="newEngineType"
                  />
                </div>
              </div>
            </div>

            <div class="column is-3">
              <div class="field">
                <label class="label has-text-black">Car type</label>
                <div class="control">
                  <input
                    style="width: 100px; text-align: center"
                    class="input has-text-black"
                    type="text"
                    placeholder="Text input"
                    v-model="newType"
                  />
                </div>
              </div>

              <div class="field">
                <label class="label has-text-black">Transmission</label>
                <div class="control">
                  <input
                    style="width: 100px; text-align: center"
                    class="input has-text-black"
                    type="text"
                    placeholder="Text input"
                    v-model="newTransmission"
                  />
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
          <div class="field">
            <label class="label has-text-black">Air Conditioning</label>
            <div class="control">
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
          <div class="field">
            <label class="label has-text-black">Unlimited Mileage</label>
            <div class="control">
              <label class="radio has-text-black mr-2">
                <input
                  type="radio"
                  name="unlimited_mileage"
                  :value="1"
                  v-model="newUnlimitedMileage"
                />
                Yes
              </label>
              <label class="radio has-text-black">
                <input
                  type="radio"
                  name="unlimited_mileage"
                  :value="0"
                  v-model="newUnlimitedMileage"
                />
                No
              </label>
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

          <div class="field">
            <label class="label has-text-black">Description</label>
            <div class="control has-backgound-white has-text-black">
              <textarea
                class="textarea has-text-black"
                placeholder="Textarea"
                style="background-color: #fff"
                v-model="newDescription"
              ></textarea>
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Fuel policy</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newFuelPolicy"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Refundable security deposite</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="number"
                placeholder="Text input"
                v-model="newRefundableSecurityDeposite"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Included insurance</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newIncludedInsurance"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Theft Protection</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newTheftProtection"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Third party liability</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newThirdPartyLiability"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">collition damage waiver</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newCollitionDamageWaiver"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Roadside assistance</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newRoadsideAssistance"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Cancellation policy</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newCancellationPolicy"
              />
            </div>
          </div>

          <div class="field">
            <label class="label has-text-black">Good to know</label>
            <div class="control">
              <input
                class="input has-text-black"
                type="text"
                placeholder="Text input"
                v-model="newGoodToKnow"
              />
            </div>
          </div>

          <div class="field is-grouped">
            <div class="control">
              <button class="button is-primary has-text-white" @click="submitForm">
                Add
              </button>
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
import { ref } from "vue";
import { useRouter } from "vue-router";

import { handleUnauthorizedError } from "@/utils/auth";

import config from "@/config";

export default {
  components: {
    ManagementMenu,
    ManagementNavBar,
    FooterElement,
  },

  setup() {
    const router = useRouter();

    const file = ref(null);
    const fileName = ref("");

    const handleFileUpload = (event) => {
      file.value = event.target.files[0];
      fileName.value = file.value ? file.value.name : "No file selected";
    };

    const newName = ref();
    const newBags = ref();
    const newDoors = ref();
    const newSeats = ref();
    const newAirconditioning = ref(0);
    const newEngineType = ref();
    const newUnlimitedMileage = ref(0);
    const newTransmission = ref();
    const newType = ref();
    const newPricePerDay = ref();
    const newDescription = ref();
    const newRefundableSecurityDeposite = ref(0);
    const newTheftProtection = ref();
    const newThirdPartyLiability = ref();
    const newRoadsideAssistance = ref();
    const newFuelPolicy = ref();
    const newIncludedInsurance = ref();
    const newCollitionDamageWaiver = ref();
    const newCancellationPolicy = ref();
    const newGoodToKnow = ref();
    // Submit function
    const submitForm = async () => {
      //console.log(file.value);

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
      if (
        typeof newDescription.value !== "string" ||
        newDescription.value.length < 10 ||
        newDescription.value.length > 200
      ) {
        alert("Invalid description type. It must be a string with 10 - 200 characters.");
        return;
      }

      /////////////////////////////////////////////////////

      if (!isNaN(newTheftProtection.value) && newTheftProtection.value.length > 200) {
        alert(
          "Invalid theft protection type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (
        !isNaN(newThirdPartyLiability.value) &&
        newThirdPartyLiability.value.length > 200
      ) {
        alert(
          "Invalid third party liability type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (
        !isNaN(newRoadsideAssistance.value) &&
        newRoadsideAssistance.value.length > 200
      ) {
        alert(
          "Invalid roadside assistance type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (!isNaN(newFuelPolicy.value) && newFuelPolicy.value.length > 200) {
        alert(
          "Invalid fuel policy type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (!isNaN(newIncludedInsurance.value) && newIncludedInsurance.value.length > 200) {
        alert(
          "Invalid included insurance type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (
        !isNaN(newCollitionDamageWaiver.value) &&
        newCollitionDamageWaiver.value.length > 200
      ) {
        alert(
          "Invalid collition damage waiver type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (
        !isNaN(newCancellationPolicy.value) &&
        newCancellationPolicy.value.length > 200
      ) {
        alert(
          "Invalid cancellation policy type. It must be a string with less than 200 characters."
        );
        return;
      }

      /////////////////////////////////////////////////////

      if (!isNaN(newGoodToKnow.value) && newGoodToKnow.value.length > 200) {
        alert(
          "Invalid good to know type. It must be a string with less than 200 characters."
        );
        return;
      }
      /////////////////////////////////////////////////////

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

      try {
        const formData = new FormData();
        if (file.value) {
          formData.append("image", file.value);
        }

        // Append other form fields
        formData.append("name", newName.value);
        formData.append("bags", newBags.value);
        formData.append("doors", newDoors.value);
        formData.append("seats", newSeats.value);
        formData.append("airconditioning", newAirconditioning.value);
        formData.append("engine_type", newEngineType.value);
        formData.append("is_unlimited_mileage", newUnlimitedMileage.value);
        formData.append("transmission", newTransmission.value);
        formData.append("type", newType.value);
        formData.append("price_per_day", newPricePerDay.value);
        formData.append("Theft_Protection", newTheftProtection.value);
        formData.append("third_party_liability", newThirdPartyLiability.value);
        formData.append("roadside_assistance", newRoadsideAssistance.value);
        formData.append("description", newDescription.value);
        formData.append("fuel_policy", newFuelPolicy.value);
        formData.append(
          "refundable_security_deposit",
          newRefundableSecurityDeposite.value
        );
        formData.append("included_insurance", newIncludedInsurance.value);
        formData.append("collision_damage_waiver", newCollitionDamageWaiver.value);
        formData.append("cancellation_policy", newCancellationPolicy.value);
        formData.append("better_to_know", newGoodToKnow.value);

        const response = await axios.post(
          `${config.API_BASE_URL}/management/cars`,
          formData,

          {
            headers: {
              "Content-Type": "multipart/form-data",
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        // console.log("Success:", response.data);
        alert("Car added successfully!");
        const id = response.data.car.id;
        router.push(`/management/car/${id}/availability`);
      } catch (error) {
        handleUnauthorizedError(error);
        alert("Failed to add car.");
      }
    };

    return {
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
      submitForm,
      handleFileUpload,
      fileName,
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
