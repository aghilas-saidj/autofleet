<template>
  <div>
    <!-- Button that triggers the modal -->
    <button
      class="button is-primary is-small has-text-white has-text-weight-bold mb-2"
      @click="showModal = true"
    >
      Manage my booking
    </button>

    <!-- Modal -->
    <div class="modal" :class="{ 'is-active': showModal }">
      <div class="modal-background" @click="closeModal"></div>
      <div class="modal-content">
        <div class="box" style="background-color: rgba(0, 46, 255, 0.38) !important">
          <form @submit.prevent="fetchBookingDetails">
            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input
                  class="input has-text-black"
                  type="email"
                  v-model="emailAddress"
                  placeholder="Enter your email"
                  required
                />
              </div>
            </div>
            <div class="field">
              <label class="label">Reference Code</label>
              <div class="control">
                <input
                  class="input has-text-black"
                  type="text"
                  v-model="referenceCode"
                  placeholder="Enter reference code"
                  required
                />
              </div>
            </div>
            <div class="field is-grouped">
              <div class="control">
                <button class="button is-primary has-text-white" type="submit">
                  Submit
                </button>
              </div>
              <div class="control">
                <button
                  class="button is-danger has-text-white"
                  type="button"
                  @click="closeModal"
                >
                  Cancel
                </button>
              </div>
            </div>
            <div v-if="Message" class="notification is-success">
              {{ Message }}
            </div>

            <div v-if="errorMessage" class="notification is-danger">
              {{ errorMessage }}
            </div>
          </form>

          <div v-if="error" class="error">
            <p>Error: {{ error }}</p>
          </div>
        </div>
      </div>
      <button
        class="modal-close is-large"
        aria-label="close"
        @click="closeModal"
      ></button>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import config from "@/config";

export default {
  setup() {
    const showModal = ref(false);
    const emailAddress = ref("");
    const referenceCode = ref("");
    const error = ref(null);
    const router = useRouter(); // Use Vue Router instance

    const errorMessage = ref("");
    const Message = ref("");

    const closeModal = () => {
      showModal.value = false;
    };

    const fetchBookingDetails = async () => {
      try {
        const response = await axios.post(`${config.API_BASE_URL}/getmybooking`, {
          email_address: emailAddress.value,
          reference_code: referenceCode.value,
        });

        console.log(response.data);

        // Check if the response indicates the rental exists
        if (Array.isArray(response.data) && response.data.length > 0) {
          Message.value = "Please wait ...";

          // Navigate to the ManageMyBooking page with the booking details
          router.push({
            name: "ManageMyBooking", // Name of the route for the ManageMyBooking page
            query: { booking: JSON.stringify(response.data[0]) }, // Pass the first booking object as query params
          });
        } else {
          errorMessage.value = "Email or reference code is incorrect";
          throw new Error("Booking not found");
        }
      } catch (err) {
        errorMessage.value = "Email or reference code is incorrect";

        error.value = err.response ? err.response.data.message : err.message;
      }
    };

    return {
      showModal,
      closeModal,
      fetchBookingDetails,
      emailAddress,
      referenceCode,
      errorMessage,
      Message,
      error,
    };
  },
};
</script>
