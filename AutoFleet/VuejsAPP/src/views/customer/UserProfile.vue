<template>
  <div>
    <!-- Navbar -->
    <NavBar />

    <div class="custom-container">
      <div class="columns is-multiline">
        <div class="column is-12">
          <div class="card">
            <div class="card-content">
              <div v-if="userInfo">
                <div class="is-flex">
                  <p class="tag is-info is-light" style="color: #296fa8">
                    Full name :
                    <span class="tag is-info is-light" style="color: #296fa8">
                      {{ userInfo.name }}
                    </span>
                  </p>
                  <button type="button" class="button is-light is-small ml-2">
                    Edit
                  </button>
                </div>

                <div class="is-flex">
                  <p class="tag is-info is-light" style="color: #296fa8">
                    Email address :
                    <span class="tag is-info is-light" style="color: #296fa8">
                      {{ userInfo.email }}
                    </span>
                  </p>
                  <button type="button" class="button is-light is-small ml-2">
                    Edit
                  </button>
                </div>

                <div class="is-flex">
                  <p class="tag is-info is-light" style="color: #296fa8">
                    Role :
                    <span class="tag is-info is-light" style="color: #296fa8">
                      {{ userInfo.role }}
                    </span>
                  </p>
                </div>
              </div>

              <div v-else>
                <p>Loading user info...</p>
              </div>

              <button
                type="button"
                class="button is-small is-danger has-text-weight-bold has-text-white mt-2"
                @click="toggleForm"
              >
                Change Password
              </button>

              <div v-if="showForm" class="card Form">
                <div class="card-content">
                  <div class="field">
                    <label class="label is-small has-text-black">New password</label>
                    <div class="control">
                      <input
                        class="input is-small has-text-black is-primary"
                        type="text"
                        placeholder="Text input"
                        v-model="newPassword"
                      />
                    </div>
                  </div>

                  <div class="field">
                    <label class="label is-small has-text-black">Confirm password</label>
                    <div class="control">
                      <input
                        class="input is-small has-text-black is-primary"
                        type="text"
                        placeholder="Text input"
                        v-model="confirmPassword"
                      />
                    </div>
                  </div>

                  <button
                    type="button"
                    class="button is-small is-primary has-text-weight-bold has-text-white is small"
                    @click="submitPasswordChange"
                  >
                    submit
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="column is-12">
          <div class="">
            <div class="card-content">
              <div class="notification has-text-white" style="background-color: #3e8ed0">
                In case you need need to cancel or to adjust your rental, please
                <strong> contact a support</strong>
                <br />
                <div
                  @click="contactSupport"
                  class="button is-primary has-text-weight-bold has-text-white"
                >
                  Contact support
                </div>
              </div>
            </div>
          </div>

          <div class="column">
            <div class="card">
              <div class="card-content">
                <p class="title" style="color: #363636">List of my rentals</p>
                <div class="table-container" style="overflow-x: auto">
                  <table class="table is-fullwidth is-narrow has-background-white">
                    <thead>
                      <tr>
                        <th style="color: #363636">Booking ID</th>
                        <th style="color: #363636">Total price</th>
                        <th style="color: #363636">From</th>
                        <th style="color: #363636">To</th>
                        <th style="color: #363636">Pickup Location</th>
                        <th style="color: #363636">Dropoff Location</th>
                        <th style="color: #363636">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Loop through bookings and display each row -->
                      <tr v-for="booking in bookings" :key="booking.id">
                        <td style="color: #363636">{{ booking.id }}</td>
                        <td style="color: #363636">{{ booking.total_price }}</td>
                        <td style="color: #363636">
                          {{ booking.start_date }}
                        </td>
                        <td style="color: #363636">{{ booking.end_date }}</td>
                        <td style="color: #363636">{{ booking.pickuplocation }}</td>
                        <td style="color: #363636">{{ booking.dropofflocation }}</td>
                        <td style="color: #363636">{{ booking.status }}</td>
                      </tr>
                    </tbody>
                  </table>
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
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import NavBar from "../../components/NavBar.vue";
import FooterElement from "../../components/FooterElement.vue";
import config from "@/config";

export default {
  components: {
    NavBar,
    FooterElement,
  },
  setup() {
    const oldPassword = ref("");
    const email = ref("");
    const newPassword = ref("");
    const confirmPassword = ref("");
    const showForm = ref(false);

    const profile = ref(null); // Stores profile details
    const error = ref(null); // Stores error message
    const userInfo = ref(null); // Store user info here
    const bookings = ref(null); // Store user info here
    const router = useRouter();

    const isAuth = ref(localStorage.getItem("Authentication_status") === "true");

    const fetchProfile = async () => {
      const token = localStorage.getItem("token"); // Get the token from localStorage
      const userID = localStorage.getItem("userID"); // Get the token from localStorage

      console.log(userID);
      try {
        const response = await axios.get(`${config.API_BASE_URL}/profile/${userID}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        profile.value = response.data; // Store the response data in profile
        userInfo.value = response.data.userInfo; // Store the userInfo from the response
        email.value = response.data.userInfo.email;
        bookings.value = response.data.bookings; // Store the bookings from the response
        console.log(response.data.bookings);

        console.log(response.data.userInfo);

        console.log(profile.value);
        error.value = null; // Clear any previous error
      } catch (err) {
        error.value = err.response ? err.response.data.message : err.message;
      }
    };

    onMounted(() => {
      if (isAuth.value !== true) {
        // Redirect to the guest cars API URL within the app
        router.push("/cars");
      }

      fetchProfile();
    });

    const supportDetails = ref({
      email: "support@example.com",
      phone: "+123456789",
    });

    // Method to display the support contact details
    const contactSupport = () => {
      alert(
        `Support Email: ${supportDetails.value.email}\nSupport Phone: ${supportDetails.value.phone}`
      );
    };

    const toggleForm = () => {
      showForm.value = !showForm.value;
    };

    const submitPasswordChange = async () => {
      const token = localStorage.getItem("token"); // Get token from localStorage
      if (!token) {
        alert("Authentication token not found.");
        return;
      }

      try {
        await axios.post(
          `${config.API_BASE_URL}/resetpassword`,
          {
            email: email.value, // Replace with logic to retrieve the email
            old_password: oldPassword.value,
            password: newPassword.value,
            password_confirmation: confirmPassword.value,
          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        alert("Password changed successfully!");
        showForm.value = false; // Hide the form after success
      } catch (error) {
        console.log(error.response.data);
        console.log(token);
        alert(
          error.response?.data?.status || "An error occurred while changing the password."
        );
      }
    };

    return {
      userInfo,
      profile,
      error,
      fetchProfile,
      bookings,
      contactSupport,
      showForm,
      oldPassword,
      newPassword,
      confirmPassword,
      toggleForm,
      submitPasswordChange,
      email,
      NavBar,
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

/* Make the table horizontally scrollable on smaller screens */
</style>
