<template>
  <div>
    <NavBar />

    <div class="button is-white is-small">
      <router-link :to="`/car/${carID}`" class="">
        <span class="icon">
          <font-awesome-icon icon="arrow-left" style="margin-right: 0.5rem" />
        </span>

        <span>View car details</span></router-link
      >
    </div>

    <div class="container" style="min-height: 100vh">
      <div class="columns">
        <div
          class="column is-6"
          style="display: flex; justify-content: center; align-items: center"
        >
          <div class="card" style="width: 100%">
            <div v-if="loading" style="">
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

            <div v-if="carDetails && carDetails.car" class="card-content">
              <figure class="image" style="max-width: 50%">
                <img
                  :src="`https://carrentalsystemimages.s3.eu-north-1.amazonaws.com/${carDetails.car.image_path}`"
                  alt="Car Image"
                />
              </figure>
              <p class="subtitle is-7" style="color: #555">
                <span class="is-info is-light subtitle is-7" style="color: #555"
                  >Total:</span
                >
              </p>
              <span class="tag is-info is-light subtitle is-6" style="color: #555"
                >${{ carDetails.totalPrice.original.total_price }}</span
              >
              <p class="subtitle is-7">From</p>
              <span class="tag is-info is-light subtitle is-7" style="color: #555"
                >{{ pickupDate }} {{ pickupTime }}</span
              >
              <span class="tag is-info is-light subtitle is-7" style="color: #555">{{
                pickupLocation
              }}</span>
              <p class="subtitle is-7">To</p>
              <span class="tag is-info is-light subtitle is-7" style="color: #555"
                >{{ dropoffDate }} {{ dropoffTime }}</span
              >
              <span class="tag is-info is-light subtitle is-7" style="color: #555">{{
                dropoffLocation
              }}</span>
            </div>
          </div>
        </div>

        <div class="column is-6">
          <div class="card has-background-white">
            <div class="card-content">
              <div class="" v-if="isPaymentError">
                <div class="notification is-danger">
                  <strong>Error</strong>, this car may not be available, please contact
                  example@gmal.com or +23423423423.
                  <hr style="background-color: #f5f5f5 !important" />
                  <router-link
                    v-if="isAuth"
                    to="/cars"
                    class="button is-primary is-small has-text-white"
                  >
                    Return to cars list</router-link
                  >
                </div>
              </div>

              <p class="title is-6 has-text-black">Information</p>

              <form @submit.prevent="handleSubmit">
                <!-- Card Number -->

                <label for="">Email address</label>
                <input
                  v-model="emailAddress"
                  class="input stripe-input"
                  type="text"
                  placeholder="Text input"
                  style="background-color: white; color: black; border: solid #e8e8e8 1px"
                  required
                />

                <p class="has-text-danger" v-if="isEmailAddressError">
                  Email address invalid
                </p>

                <label for="">Phone number</label>

                <input
                  v-model="phoneNumber"
                  class="input stripe-input is-gray"
                  type="text"
                  placeholder="Text input"
                  style="background-color: white; color: black; border: solid #e8e8e8 1px"
                  required
                />

                <p class="has-text-danger" v-if="isPhoneNumberError">
                  Phone number address invalid
                </p>
                <hr style="background-color: #f5f5f5 !important" />
                <p class="title is-6 has-text-black">Payment details</p>
                <div class="card">
                  <div class="card-content">
                    <div id="card-element"></div>
                    <div v-if="error" class="error">{{ error }}</div>
                  </div>
                </div>

                <button
                  class="button is-primary has-text-white has-text-weight-bold"
                  type="submit"
                  :disabled="isProcessing"
                >
                  {{ isProcessing ? "Processing..." : "Pay Now" }}
                </button>
              </form>
              <p v-if="message" :class="{ success: success, error: !success }">
                {{ message }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <FooterElement />
  </div>
</template>

<script>
import { loadStripe } from "@stripe/stripe-js";
import { ref, onMounted } from "vue";
import axios from "axios"; // Make sure you have axios installed
import { useRouter } from "vue-router"; // Make sure this import is present
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

    const router = useRouter(); // Use useRouter hook correctly
    const isAuth = ref(localStorage.getItem("Authentication_status") === "true");

    const stripePublicKey =
      "pk_test_51NryUVBtGhm1Lp3cQvHSzyrVdIGP17nfPWvtIADwaRWPtsOr2fXPPGIfDh0m5y4UC2stZn1M8u2C8Oa4MrDXEQO900nODgkYxx"; // Replace with your Stripe public key
    const stripe = ref(null);
    const elements = ref(null);

    const isProcessing = ref(false);
    const message = ref("");
    const success = ref(false);

    const carDetails = ref(null);
    const tolatPrice = ref(0);

    const carID = ref(localStorage.getItem("carID") || "");
    const processing = ref(false);
    const error = ref(null);
    const cardElement = ref(null); // Define cardElement here

    const emailAddress = ref();
    const phoneNumber = ref();
    const isPaymentError = ref(false);
    const isEmailAddressError = ref(false);
    const isPhoneNumberError = ref(false);

    onMounted(async () => {
      stripe.value = await loadStripe(stripePublicKey);
      elements.value = stripe.value.elements();

      // Create a card element and mount it to the DOM
      const card = elements.value.create("card");
      card.mount("#card-element");

      // Store the card element for later use
      cardElement.value = card;

      //######################

      const fromDate = pickupDate.value; // From Date
      const toDate = dropoffDate.value; // To Date
      const pickup = `${fromDate} ${pickupTime.value}`;
      const dropoff = `${toDate} ${dropoffTime.value}`;
      const carID = ref(localStorage.getItem("carID") || "");

      try {
        // Use the `id` extracted from the route parameters
        const response = await axios.get(
          `${config.API_BASE_URL}/guest/cars/${carID.value}/${pickup}/${dropoff}/${pickupLocation.value}/${dropoffLocation.value}`
        );
        carDetails.value = response.data; // Store the fetched data
        tolatPrice.value = response.data.totalPrice.original.total_price;
      } catch (error) {
        console.error("Error fetching car details:", error);
      } finally {
        loading.value = false; // Stop loading
      }
    });

    const handleSubmit = async () => {
      processing.value = true;
      error.value = null;
      try {
        // Create a payment method using the card element
        const {
          paymentMethod,
          error: paymentError,
        } = await stripe.value.createPaymentMethod({
          type: "card",
          card: cardElement.value, // Use the card element here
        });

        //   console.log(paymentMethod);
        //  console.log(paymentError);

        if (paymentError) {
          error.value = paymentError.message;
          processing.value = false;
          return;
        }

        const token = localStorage.getItem("token"); // Get the token from localStorage

        const url = isAuth.value
          ? `${config.API_BASE_URL}/checkout`
          : `${config.API_BASE_URL}/guest/checkout`;

        // Send Payment Request to Laravel Backend

        localStorage.setItem("paymentMethodID", paymentMethod.id);
        const response = await fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify({
            paymentMethodId: paymentMethod.id, // Send the Payment Method ID
            emailAddress: emailAddress.value,
            phoneNumber: phoneNumber.value,
            from: `${pickupDate.value} ${pickupTime.value}`,
            to: `${dropoffDate.value} ${dropoffTime.value}`,
            pickuplocation: pickupLocation.value,
            dropofflocation: dropoffLocation.value,
            car_id: carID.value,
            price: tolatPrice.value,
          }),
        });

        if (!response.ok) {
          const errorData = await response.json();
          error.value = errorData.message || "An error occurred during the request.";
          return;
        }

        const responseText = await response.text();
        if (responseText === "payment_false") {
          isPaymentError.value = true;
          return;
        } else {
          isPaymentError.value = false;
        }

        if (responseText === "email_address_false") {
          isEmailAddressError.value = true;
          return;
        } else {
          isEmailAddressError.value = false;
        }

        if (responseText === "phone_number_false") {
          isPhoneNumberError.value = true;
          return;
        } else {
          isPhoneNumberError.value = false;
        }

        router.push({ name: "PaymentProcess" });
      } catch (err) {
        console.log("The error is :: ", err);
        error.value = "Payment failed. Please try again.";
      } finally {
        processing.value = false;
      }
    };

    const pickupLocation = ref(localStorage.getItem("pickupLocation") || "any");
    const pickupDate = ref(localStorage.getItem("pickupDate") || "");
    const pickupTime = ref(localStorage.getItem("pickupTime") || "");
    const dropoffLocation = ref(localStorage.getItem("dropoffLocation") || "any");
    const dropoffDate = ref(localStorage.getItem("dropoffDate") || "");
    const dropoffTime = ref(localStorage.getItem("dropoffTime") || "");

    // Method to confirm logout
    const confirmLogout = () => {
      const confirmed = window.confirm("Are you sure you want to log out?");
      if (confirmed) {
        logout();
      }
    };

    // Method to process logout
    const logout = () => {
      // Remove items from localStorage
      localStorage.removeItem("token");
      localStorage.removeItem("Authentication_status");
      localStorage.removeItem("userID");

      // Redirect to login page after logout
      router.push({ name: "LoginPage" });
    };

    return {
      isProcessing,
      message,
      success,
      handleSubmit,
      carDetails,
      pickupLocation,
      pickupDate,
      pickupTime,
      dropoffLocation,
      dropoffDate,
      dropoffTime,
      carID,
      isAuth,
      confirmLogout,
      emailAddress,
      phoneNumber,
      isPaymentError,
      isEmailAddressError,
      isPhoneNumberError,
      NavBar,
      error,
      loading,
    };
  },
};
</script>

<style>
/* Add custom styling */
.stripe-input {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 4px;
  margin-bottom: 10px;
}

.success {
  color: green;
}

.error {
  color: red;
}

.card {
  box-shadow: 0 0.5em 1em -0.125em rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.02) !important; /* Force priority */
  border-radius: 0.25rem;
  background-color: white !important; /* Force priority */
}
</style>
const isPaymentError = ref(false); const isEmailAddressError = ref(false); const
isPhoneNumberError = ref(false);
