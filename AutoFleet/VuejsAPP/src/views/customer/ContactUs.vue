<template>
  <div>
    <!-- Navbar -->
    <NavBar />

    <div class="container" style="min-height: 100vh">
      <div class="columns">
        <div class="column">
          <div class="card" style="max-width: 500px; height: 100% !important">
            <div class="card-content">
              <form @submit.prevent="validateForm">
                <div class="field">
                  <label class="label has-text-black">Name</label>
                  <div class="control">
                    <input
                      v-model="name"
                      class="input has-text-black"
                      type="text"
                      placeholder="Text input"
                    />
                  </div>
                  <div v-if="errors.name">{{ errors.name }}</div>
                </div>

                <div class="field">
                  <label class="label has-text-black">Phone number</label>
                  <div class="control has-icons-left has-icons-right">
                    <input
                      v-model="phonenumber"
                      class="input has-text-black"
                      type="numeric"
                      placeholder="Text input"
                    />
                    <span class="icon is-small is-left">
                      <i class="fas fa-user"></i>
                    </span>
                    <span class="icon is-small is-right">
                      <i class="fas fa-check"></i>
                    </span>
                  </div>
                  <div v-if="errors.phone">{{ errors.phone }}</div>
                </div>

                <div class="field">
                  <label class="label has-text-black">Email</label>
                  <div class="control has-icons-left has-icons-right">
                    <input
                      v-model="emailaddress"
                      class="input has-text-black"
                      type="email"
                      placeholder="Email input"
                      value="hello@"
                    />
                    <span class="icon is-small is-left">
                      <i class="fas fa-envelope"></i>
                    </span>
                    <span class="icon is-small is-right">
                      <i class="fas fa-exclamation-triangle"></i>
                    </span>
                  </div>

                  <div v-if="errors.email">{{ errors.email }}</div>
                </div>

                <div class="field">
                  <label class="label has-text-black">Message</label>
                  <div class="control">
                    <textarea
                      v-model="messagetext"
                      class="textarea has-text-black has-background-white"
                      placeholder="Textarea"
                    ></textarea>
                  </div>
                  <div v-if="errors.message">{{ errors.message }}</div>
                </div>

                <div class="field is-grouped">
                  <div class="control">
                    <button @click="sendEmail" class="button is-primary has-text-white">
                      Submit
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <FooterElement />
  </div>
</template>

<script>
import NavBar from "../../components/NavBar.vue";
import FooterElement from "../../components/FooterElement.vue";
import axios from "axios";
import { ref, computed } from "vue";
import config from "@/config";

export default {
  components: {
    NavBar,
    FooterElement,
  },
  setup() {
    const name = ref("");
    const phonenumber = ref("");
    const emailaddress = ref("");
    const messagetext = ref("");
    // Handle form submission

    const errors = ref({});

    // Validation functions
    const validateName = computed(() => {
      return name.value.trim().length >= 3
        ? ""
        : "Name must be at least 3 characters long";
    });

    const validatePhone = computed(() => {
      return /^[0-9]{10}$/.test(phonenumber.value)
        ? ""
        : "Enter a valid 7-digit phone number";
    });

    const validateEmail = computed(() => {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailaddress.value)
        ? ""
        : "Enter a valid email address";
    });

    const validateMessage = computed(() => {
      return messagetext.value.trim().length > 5
        ? ""
        : "Message must be at least 5 characters long";
    });

    // Check form before submitting
    const validateForm = () => {
      errors.value = {
        name: validateName.value,
        phone: validatePhone.value,
        email: validateEmail.value,
        message: validateMessage.value,
      };

      // Check if there are no errors
      if (
        !errors.value.name &&
        !errors.value.phone &&
        !errors.value.email &&
        !errors.value.message
      ) {
        alert("Form submitted successfully!");
      }
    };

    // Function to send email
    const sendEmail = async () => {
      try {
        validateForm();
        const response = await axios.post(`${config.API_BASE_URL}/sendemail`, {
          email: emailaddress.value,
          name: name.value,
          phone: phonenumber.value,
          message: messagetext.value,
        });

        console.log(response.data);

        if (response) {
          // Handle success (e.g., display a success message)
          alert("Email sent successfully!");
        } else {
          // Handle failure (e.g., display an error message)
          alert("Failed to send email.");
        }
      } catch (error) {
        //console.error("Error sending email:", error);
        alert("There was an error sending the email.");
      }
    };

    return {
      NavBar,
      name,
      phonenumber,
      emailaddress,
      messagetext,
      sendEmail,
      errors,
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
