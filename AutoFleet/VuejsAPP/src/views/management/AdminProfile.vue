<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="column column is-9-tablet is-10-desktop">
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
                <button type="button" class="button is-light is-small ml-2">Edit</button>
              </div>

              <div class="is-flex">
                <p class="tag is-info is-light" style="color: #296fa8">
                  Email address :
                  <span class="tag is-info is-light" style="color: #296fa8">
                    {{ userInfo.email }}
                  </span>
                </p>
                <button type="button" class="button is-light is-small ml-2">Edit</button>
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
    </div>

    <FooterElement />
  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import ManagementMenu from "../../components/ManagementMenu.vue";
import ManagementNavBar from "../../components/ManagementNavBar.vue";
import FooterElement from "../../components/FooterElement.vue";

import { handleUnauthorizedError } from "@/utils/auth";

import config from "@/config";

export default {
  components: {
    ManagementMenu,
    ManagementNavBar,
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
        error.value = null; // Clear any previous error
      } catch (error) {
        handleUnauthorizedError(error);
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
        handleUnauthorizedError(error);
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
