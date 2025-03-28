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
            :to="`/management/expenses`"
            class="button is-primary has-text-white mt-2 mb-1"
            >View all expenses</router-link
          >

          <hr />
          <div class="notification-container" style="pointer-events: none">
            <div v-if="isEdited" class="notification is-success has-text-white">
              <p>Expense has been edited</p>
            </div>
          </div>
          <div class="columns is-multiline">
            <div class="column is-12 is-flex">
              <div class="field mr-3">
                <label class="label has-text-black">Amount $</label>
                <div class="control">
                  <input
                    style="width: 200px; text-align: center"
                    class="input has-text-black"
                    type="number"
                    placeholder="Text input"
                    v-model="Amount"
                  />
                </div>
              </div>
            </div>

            <div class="column is-12 is-flex">
              <div class="field">
                <label class="label has-text-black">Reason</label>
                <div class="control">
                  <textarea
                    class="textarea has-background-white has-text-black"
                    placeholder="Textarea"
                    v-model="Reason"
                  ></textarea>
                </div>
              </div>
            </div>
          </div>

          <hr />

          <div class="field is-grouped">
            <div class="control">
              <button class="button is-primary has-text-white" @click="editExpense">
                Edit
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
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

import { handleUnauthorizedError } from "@/utils/auth";

import config from "@/config";

export default {
  components: {
    ManagementMenu,
    ManagementNavBar,
    FooterElement,
  },

  setup() {
    const route = useRoute(); // Get the current route object
    const id = route.params.id; // Extract the `id` parameter from the URL
    const Amount = ref();
    const Reason = ref("");

    const isEdited = ref(false);

    const fetchExpenseData = async (id) => {
      try {
        const response = await axios.get(
          `${config.API_BASE_URL}/management/expenses/${id}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        Amount.value = response.data.amount;
        Reason.value = response.data.reason;

        //   console.log("Success:", response.data);
      } catch (error) {
        console.error("Error:", error.response ? error.response.data : error.message);
      }
    };

    const editExpense = async () => {
      // Trim inputs to remove unnecessary spaces
      const amount = Number(Amount.value);
      const reason = Reason.value.trim();

      // Validate amount (must be a number greater than 0)
      if (isNaN(amount) || amount <= 0) {
        alert("Invalid amount. It must be a number greater than 0.");
        return;
      }

      // Validate reason (must be a string with a max length of 100 characters)
      if (reason === "" || reason.length > 100) {
        alert("Invalid reason. It must be between 1 and 100 characters.");
        return;
      }

      if (!id) {
        console.error("Expense ID is missing!");
        return;
      }

      try {
        const response = await axios.put(
          `${config.API_BASE_URL}/management/expenses/${id}`,
          {
            amount: Amount.value,
            reason: Reason.value,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
            },
          }
        );

        if (response) {
          editStatus();
        }

        //   console.log(response);
      } catch (error) {
        handleUnauthorizedError(error);

        console.log("error".error);
      }
    };

    const editStatus = () => {
      // Set Updated to true
      isEdited.value = true;

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isEdited.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    onMounted(() => {
      fetchExpenseData(id);
    });
    return {
      Amount,
      Reason,
      editExpense,
      isEdited,
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
