<template>
  <div>
    <!-- Navbar -->
    <NavBar />

    <div class="container" style="min-height: 100vh">
      <div class="columns">
        <div class="column">
          <div class="card" style="max-width: 500px; height: 100% !important">
            <div class="card-content">
              <p class="subtitle is-size-5 has-text-weight-bold">Sign up</p>

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

              <hr style="background-color: #f5f5f5 !important" />

              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <label for="" class="subtitle is-size-7 has-text-weight-bold">
                    <font-awesome-icon icon="user" style="margin-right: 0.5rem" /> Full
                    name</label
                  >
                  <input
                    v-model="form.name"
                    class="input"
                    type="text"
                    placeholder="Full name"
                    style="width: 100%; color: #4a4a4a"
                  />
                </p>
              </div>

              <div class="field">
                <p class="control has-icons-left has-icons-right">
                  <label for="" class="subtitle is-size-7 has-text-weight-bold">
                    <font-awesome-icon icon="envelope" style="margin-right: 0.5rem" />
                    Email address</label
                  >
                  <input
                    v-model="form.email"
                    class="input"
                    type="email"
                    placeholder="Email address"
                    style="width: 100%; color: #4a4a4a"
                  />
                </p>
              </div>

              <div class="field">
                <p class="control has-icons-left">
                  <label for="" class="subtitle is-size-7 has-text-weight-bold">
                    <font-awesome-icon icon="lock" style="margin-right: 0.5rem" />
                    Password</label
                  >

                  <input
                    v-model="form.password"
                    class="input"
                    type="password"
                    placeholder="Password"
                    style="width: 100%; color: #4a4a4a"
                  />
                </p>
              </div>

              <div class="field">
                <p class="control has-icons-left">
                  <label for="" class="subtitle is-size-7 has-text-weight-bold">
                    <font-awesome-icon icon="lock" style="margin-right: 0.5rem" />Confirm
                    your password</label
                  >

                  <input
                    v-model="form.confirmPassword"
                    class="input"
                    type="password"
                    placeholder="Password"
                    style="width: 100%; color: #4a4a4a"
                  />
                </p>
              </div>

              <div class="field">
                <p class="control">
                  <button class="button is-success has-text-white" @click="handleSubmit">
                    Sign up
                  </button>
                </p>
              </div>

              <div v-if="successMessage" class="notification is-success">
                {{ successMessage }}
              </div>
              <!-- Display error message -->
              <div v-if="errorMessage" class="notification is-danger">
                {{ errorMessage }}
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
import { useRouter } from "vue-router"; // Import Vue Router
import NavBar from "../components/NavBar.vue";
import FooterElement from "../components/FooterElement.vue";

import config from "@/config";
import ProgressBar from "@/components/ProgressBar.vue";

export default {
  components: {
    NavBar,
    FooterElement,
    ProgressBar,
  },
  setup() {
    const loading = ref(false);

    const router = useRouter(); // Initialize the router

    // Define form as a reactive object
    const form = ref({
      name: "",
      email: "",
      password: "",
      confirmPassword: "",
    });

    const errorMessage = ref("");
    const successMessage = ref("");

    // Handle form submission
    const handleSubmit = async () => {
      errorMessage.value = ""; // Clear previous errors
      successMessage.value = ""; // Clear previous success messages

      // Check if all fields are filled
      if (
        form.value.name &&
        form.value.email &&
        form.value.password &&
        form.value.confirmPassword
      ) {
        try {
          loading.value = true;

          const response = await axios.post(`${config.API_BASE_URL}/register`, {
            name: form.value.name,
            email: form.value.email,
            password: form.value.password,
            password_confirmation: form.value.confirmPassword,
          });

          // Handle the successful response
          successMessage.value = "Registration successful!";

          //  console.log("Registration successful:", response.data);
          localStorage.setItem("token", response.data.token);
          localStorage.setItem("Authentication_status", "true");
          localStorage.setItem("userID", response.data.id);

          router.push("/cars");

          // Optionally store the token or redirect
          // Example: Redirect using Vue Router
        } catch (error) {
          // Handle validation or server errors
          if (error.response?.data?.errors) {
            errorMessage.value = Object.values(error.response.data.errors)
              .flat()
              .join(", ");
          } else {
            errorMessage.value = "An error occurred. Please try again.";
          }
          //   console.error("Registration failed:", error.response?.data || error.message);
        } finally {
          loading.value = false; // Stop loading
        }
      } else {
        errorMessage.value = "All fields are required.";
      }
    };

    onMounted(() => {
      const auth = localStorage.getItem("Authentication_status");

      if (auth === "true") {
        router.push({ path: "/", replace: true });
      }
    });

    return {
      form,
      errorMessage,
      successMessage,
      handleSubmit,
      NavBar,
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
</style>
