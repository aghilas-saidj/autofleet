<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="column is-9-tablet is-10-desktop">
        <div class="custom-container" style="min-height: 100vh">
          <div class="card">
            <div class="card-content">
              <router-link
                :to="`/management/addexpense`"
                class="button is-primary mr-3 has-text-white"
                type="button"
                >Add new expense</router-link
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

              <div class="notification-container" style="pointer-events: none">
                <div v-if="isDeleted" class="notification is-success has-text-white">
                  <p>Expense has been Deleted</p>
                </div>
              </div>

              <p class="tag subtitle is-7 has-background-white">Number Expenses</p>
              <span class="tag is-link is-light subtitle is-7">{{ expensesNumber }}</span>
              <br />

              <!-- <p class="tag subtitle is-7 has-background-white">Total expenses</p>
              <span class="tag is-danger is-light subtitle is-7">$364</span> -->
              <hr
                style="
                  background-color: #f5f5f5;
                  border: none;
                  display: block;
                  height: 2px;
                  margin: 1.5rem 0;
                "
              />
            </div>
          </div>

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

          <div class="columns is-multiline">
            <div class="column is-12">
              <div class="card">
                <div class="card-content">
                  <div class="table-container">
                    <table
                      class="table is-fullwidth has-background-white"
                      style="border-radius: 20px"
                    >
                      <thead>
                        <tr>
                          <th>Pos</th>
                          <th>Amount</th>
                          <th>Reason</th>
                          <th>Created on</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="expense in PaginatedExpenses" :key="expense.id">
                          <td>{{ expense.id }}</td>
                          <td>
                            <p class="tag is-light">$ {{ expense.amount }}</p>
                          </td>
                          <td>{{ expense.reason }}</td>
                          <td>{{ new Date(expense.created_at).toLocaleDateString() }}</td>
                          <td class="">
                            <router-link
                              :to="`/management/expense/${expense.id}`"
                              class="button is-small has-background-grey-light has-text-black mr-1"
                              >Edit</router-link
                            >

                            <!-- <button class="button is-small is-light mr-1 mb-1">Edit</button> -->
                            <button
                              @click="deleteExpense(expense.id)"
                              class="button is-small is-danger mr-1 has-text-white"
                            >
                              Delete
                            </button>
                          </td>
                        </tr>
                        <div class="is-flex">
                          <button
                            class="button is-small mr-1"
                            @click="prevPage"
                            :disabled="slicestart <= 0"
                          >
                            Previous
                          </button>

                          <button
                            class="button is-small"
                            @click="nextPage"
                            :disabled="sliceend >= expenses.length"
                          >
                            Next
                          </button>
                        </div>
                        <!-- Add more rows as needed -->
                      </tbody>
                    </table>
                  </div>
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
import ManagementMenu from "../../components/ManagementMenu.vue";
import ManagementNavBar from "../../components/ManagementNavBar.vue";
import FooterElement from "../../components/FooterElement.vue";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

import { handleUnauthorizedError } from "@/utils/auth";

import config from "@/config";
import ProgressBar from "@/components/ProgressBar.vue";

export default {
  components: {
    ManagementMenu,
    ManagementNavBar,
    FooterElement,
    ProgressBar,
  },

  setup() {
    const loading = ref(true);

    const expenses = ref([]); // Store payments data

    const expensesNumber = ref(0);
    const slicestart = ref(0);
    const sliceend = ref(10);
    const isDeleted = ref(false);

    const fetchExpenses = async () => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/management/expenses`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });

        expenses.value = response.data;
        expensesNumber.value = expenses.value.length; // Count elements
      } catch (error) {
        handleUnauthorizedError(error);
        console.error("Unexpected error");
      } finally {
        loading.value = false; // Stop loading
      }
    };

    const PaginatedExpenses = computed(() => {
      return expenses.value.slice(slicestart.value, sliceend.value);
    });

    const nextPage = () => {
      slicestart.value += 10;
      sliceend.value += 10;
    };

    const prevPage = () => {
      slicestart.value -= 10;
      sliceend.value -= 10;
    };

    const deleteExpense = async (id) => {
      const isConfirmed = confirm("Are you sure you want to delete this expense?");

      if (!isConfirmed) return;

      const Delete = await axios.delete(
        `${config.API_BASE_URL}/management/expenses/${id}`,
        {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        }
      );

      if (Delete) {
        deleteStatus();
      }
    };

    const deleteStatus = () => {
      // Set Updated to true
      isDeleted.value = true;
      fetchExpenses();

      // After 4 seconds, set Updated back to false
      setTimeout(() => {
        isDeleted.value = false;
      }, 2000); // 4000ms = 4 seconds
    };

    onMounted(fetchExpenses);

    return {
      expenses,
      expensesNumber,
      PaginatedExpenses,
      nextPage,
      prevPage,
      deleteExpense,
      isDeleted,
      slicestart,
      sliceend,
      loading,
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
