<template>
  <div class="wrapper">
    <!-- Navbar -->
    <NavBar />

    <div class="container">
      <div class="columns">
        <div class="column">
          <div class="card" style="max-width: 500px; height: 100% !important">
            <div class="card-content">
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

              <div v-if="paymentStatus == 'failed'">
                <img
                  src="payment-failed.png"
                  alt="Logo"
                  style="max-height: 50px; width: auto"
                />
                <div>
                  <p class="tag is-danger">payment-failed</p>
                </div>
                <hr style="background-color: #f5f5f5 !important" />

                <router-link
                  :to="`/checkout`"
                  class="button is-primary has-text-weight-bold has-text-white"
                  >Try again</router-link
                >

                <hr style="background-color: #f5f5f5 !important" />
              </div>

              <div v-if="paymentStatus == 'pending'">
                <img
                  src="payment-pending.png"
                  alt="Logo"
                  style="max-height: 50px; width: auto"
                />

                <p>Please Wait ...</p>

                <hr style="background-color: #f5f5f5 !important" />

                <div>
                  <p class="tag is-info has">Price : ${{ paymentAmount }}</p>
                </div>

                <div>
                  <p class="tag is-warning">Status : pending</p>
                </div>

                <div>
                  <p class="tag is-info has">Date : {{ paymentDate }}</p>
                </div>

                <div>
                  <p class="tag is-info has">Payment id : {{ paymentID }}</p>
                </div>
                <hr style="background-color: #f5f5f5 !important" />
              </div>

              <div v-if="paymentStatus == 'completed'" class="center-container">
                <p class="title is-3">Your rental</p>
                <p class="subtitle is-3">has been confirmed</p>

                <div>
                  <img
                    src="payment-success.png"
                    alt="Logo"
                    style="max-height: 50px; width: auto"
                  />
                  <p class="subtitle">PAYMENT COMPLETED</p>
                </div>

                <hr style="background-color: #f5f5f5 !important" />

                <p>Reference details :</p>

                <p class="tag is-info">Email address : {{ emailAddress }}</p>

                <p class="tag is-info">Reference code : {{ referenceCode }}</p>

                <hr style="background-color: #f5f5f5 !important" />

                <div>
                  <p>
                    You rental starts on
                    <span class="tag is-info"> {{ pickupDateAndTime }} </span> at
                    <span class="tag is-info"> {{ pickupLocation }}</span>
                  </p>
                </div>

                <hr />

                <router-link
                  :to="`/`"
                  class="button is-primary has-text-weight-bold has-text-white"
                  >Home</router-link
                >
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
import { ref, onMounted, onUnmounted } from "vue";
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

    const isAuth = ref(localStorage.getItem("Authentication_status") === "true");

    const paymentMethodID = ref(localStorage.getItem("paymentMethodID")); // Retrieve from localStorage
    const paymentStatus = ref(null); // To store the status
    const error = ref(null); // To store errors

    const emailAddress = ref(null);
    const referenceCode = ref(null);
    const pickupDateAndTime = ref(null);
    const pickupLocation = ref(null);
    const paymentAmount = ref(null);
    const paymentDate = ref(null);
    const paymentID = ref(null);
    let intervalId = null;

    const getPaymentStatus = async () => {
      if (!paymentMethodID.value) {
        error.value = "No Payment Method ID found.";
        return;
      }

      try {
        const response = await fetch(`${config.API_BASE_URL}/getpaymentstatus`, {
          method: "POST", // Use POST or GET based on your backend implementation
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({
            payment_method: paymentMethodID.value, // Send the Payment Method ID
          }),
        });

        if (!response.ok) {
          const errorData = await response.json();
          error.value = errorData.message || "Error retrieving payment status.";
          return;
        }
        const data = await response.json();

        emailAddress.value = data.bookingInfo.email_address;
        referenceCode.value = data.bookingInfo.reference_code;
        pickupDateAndTime.value = data.bookingInfo.start_date;
        pickupLocation.value = data.bookingInfo.pickuplocation;

        paymentStatus.value = data.paymentInfo.status; // Assuming the backend returns a "status" field

        paymentAmount.value = data.paymentInfo.amount;
        paymentDate.value = data.paymentInfo.created_at;
        paymentID.value = data.paymentInfo.payment_method;

        //  console.log(paymentStatus.value);

        if (paymentStatus.value === "pending") {
          console.log("please wait ... ");
        }

        if (paymentStatus.value === "completed") {
          clearInterval(intervalId);
          console.log("Payment successed");
        }

        if (paymentStatus.value === "failed") {
          clearInterval(intervalId);
          console.log("Payment failed");
        }
      } catch (err) {
        error.value = "An unexpected error occurred.";
      } finally {
        loading.value = false; // Stop loading
      }
    };
    onMounted(() => {
      intervalId = setInterval(getPaymentStatus, 1000); // 1000 ms = 1 second
    });

    // Clear the interval when the component is unmounted
    onUnmounted(() => {
      if (intervalId) {
        clearInterval(intervalId);
      }
    });

    return {
      isAuth,
      paymentMethodID,
      paymentStatus,
      error,
      getPaymentStatus,

      emailAddress,
      referenceCode,
      pickupDateAndTime,
      pickupLocation,
      paymentAmount,
      paymentDate,
      paymentID,
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

.container {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.center-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}
</style>
