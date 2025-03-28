<template>
  <div>
    <!-- Navbar -->
    <NavBar />

    <div class="container" style="min-height: 100vh">
      <div class="columns">
        <div class="column">
          <div class="card" style="max-width: 500px; height: 100% !important">
            <div class="card-content">
              <p class="subtitle is-size-5 has-text-weight-bold">Sign in</p>

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
                    <font-awesome-icon icon="envelope" /> Email address</label
                  >
                  <input
                    v-model="email"
                    class="input"
                    type="email"
                    placeholder="Email address"
                    style="width: 100%; color: #4a4a4a"
                  />
                  <span class="icon is-small is-left"> </span>
                </p>
              </div>
              <div class="field">
                <p class="control has-icons-left">
                  <label for="" class="subtitle is-size-7 has-text-weight-bold">
                    <font-awesome-icon icon="lock" /> Password</label
                  >

                  <input
                    v-model="password"
                    class="input"
                    type="password"
                    placeholder="Password"
                    style="width: 100%; color: #4a4a4a"
                  />
                </p>
              </div>
              <div class="field">
                <p class="control">
                  <button @click="handleSubmit" class="button is-success has-text-white">
                    Sign in
                  </button>
                </p>

                <div v-if="Message" class="notification is-success">
                  {{ Message }}
                </div>

                <div v-if="errorMessage" class="notification is-danger">
                  {{ errorMessage }}
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
import { useRouter } from "vue-router"; // Import Vue Router
import NavBar from "../../src/components/NavBar.vue";
import FooterElement from "../../src/components/FooterElement.vue";

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

    const email = ref("");
    const password = ref("");
    const errorMessage = ref("");
    const Message = ref("");

    // Handle form submission
    const handleSubmit = async () => {
      errorMessage.value = "";
      if (email.value && password.value) {
        try {
          loading.value = true;
          const response = await axios.post(`${config.API_BASE_URL}/login`, {
            email: email.value,
            password: password.value,
          });

          Message.value = "Login successful, please wait ... ";

          // Handle the successful response here
          // console.log("Login successful:", response.data);

          // Optionally store the token or redirect the user
          localStorage.setItem("token", response.data.token);
          localStorage.setItem("Authentication_status", "true");
          localStorage.setItem("userID", response.data.id);

          if (response.data.role === "admin") {
            localStorage.setItem("IsAdmin", "true");
            router.push("/management/dashboard");
          } else {
            router.push("/");
          }
        } catch (error) {
          // Handle error (e.g., incorrect credentials)
          //console.error("Login failed:", error.response.data);

          errorMessage.value = "Email or Password is incorrect";
        } finally {
          loading.value = false; // Stop loading
        }
      } else {
        // console.log("Please fill out all fields.");
        errorMessage.value = "Please fill out all fields.";
      }
    };

    onMounted(() => {
      const auth = localStorage.getItem("Authentication_status");

      if (auth === "true") {
        router.push({ path: "/", replace: true });
      }
    });

    return {
      email,
      password,
      handleSubmit,
      errorMessage,
      Message,
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
