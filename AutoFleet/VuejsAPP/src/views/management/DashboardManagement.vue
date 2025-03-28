<template>
  <div>
    <ManagementNavBar />

    <div class="columns">
      <div class="column is-3-tablet is-2-desktop">
        <ManagementMenu />
      </div>

      <div class="column is-9-tablet is-10-desktop">
        <div class="custom-container" style="min-height: 100vh">
          <!--Container here -->
          <div class="card">
            <div class="card-content">
              <div class="field">
                <label class="label" style="color: #4a4a4a !important"
                  ><font-awesome-icon icon="calendar-alt" /> Period</label
                >
                <div class="control">
                  <div class="select">
                    <select
                      v-model="selectedTimeRange"
                      style="background-color: white; color: black"
                    >
                      <option>All time</option>
                      <option>Current year</option>
                      <option>Current month</option>
                      <option>Current week</option>
                      <option>Current day</option>
                      <!-- Add more car types as needed -->
                    </select>
                  </div>
                </div>
              </div>

              {{ selectedTimeRange }}

              <div class="columns">
                <div class="column is-4">
                  <div class="card">
                    <div class="card-content">
                      <p class="subtitle is-6">Revenue</p>
                      <span
                        class="tag is-link is-light subtitle is-5"
                        style="color: #3850b7 !important"
                        >$ {{ Revenue }}</span
                      >
                    </div>
                  </div>
                </div>

                <div class="column is-4">
                  <div class="card">
                    <div class="card-content">
                      <p class="subtitle is-6">Expenses</p>
                      <span
                        class="tag is-danger is-light subtitle is-5"
                        style="color: #cc0f35 !important"
                        >$ {{ Expenses }}</span
                      >

                      <div
                        v-if="loading"
                        style="
                          display: flex;
                          justify-content: center;
                          align-items: center;
                        "
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
                    </div>
                  </div>
                </div>

                <div class="column is-4">
                  <div class="card">
                    <div class="card-content">
                      <p class="subtitle is-6">Net</p>
                      <span
                        class="tag is-success is-light subtitle is-5"
                        style="color: #257953 !important"
                        >$ {{ Net }}</span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr
            style="
              background-color: #f5f5f5;
              border: none;
              display: block;
              height: 2px;
              margin: 1.5rem 0;
            "
          />

          <div class="columns">
            <div class="column is-7">
              <div class="card">
                <div class="card-content">
                  <div class="field">
                    <label class="label" style="color: #4a4a4a !important">
                      <font-awesome-icon icon="coins" /> Revenue</label
                    >
                  </div>

                  <div>
                    <div class="tabs is-boxed">
                      <ul>
                        <li :class="{ 'is-active': activeTable === 'Current-year' }">
                          <a
                            @click="showTable('Current-year')"
                            class="has-background-white"
                          >
                            <span class="icon is-small"></span>
                            <span>Current year</span>
                          </a>
                        </li>
                        <li :class="{ 'is-active': activeTable === 'Current-month' }">
                          <a
                            @click="showTable('Current-month')"
                            class="has-background-white"
                          >
                            <span class="icon is-small"
                              ><i class="fas fa-music" aria-hidden="true"></i
                            ></span>
                            <span>Current month</span>
                          </a>
                        </li>
                        <li :class="{ 'is-active': activeTable === 'Current-week' }">
                          <a
                            @click="showTable('Current-week')"
                            class="has-background-white"
                          >
                            <span class="icon is-small"
                              ><i class="fas fa-film" aria-hidden="true"></i
                            ></span>
                            <span>Current week</span>
                          </a>
                        </li>
                        <li :class="{ 'is-active': activeTable === 'Current-day' }">
                          <a
                            @click="showTable('Current-day')"
                            class="has-background-white"
                          >
                            <span class="icon is-small"
                              ><i class="far fa-file-alt" aria-hidden="true"></i
                            ></span>
                            <span>Current day</span>
                          </a>
                        </li>
                      </ul>
                    </div>

                    <div v-show="activeTable === 'Current-year'">
                      <apexchart
                        :options="chartOptions"
                        :series="yearchartData"
                      ></apexchart>
                    </div>

                    <div v-show="activeTable === 'Current-month'">
                      <apexchart
                        :options="chartOptions"
                        :series="monthchartData"
                      ></apexchart>
                    </div>

                    <div v-show="activeTable === 'Current-week'">
                      <apexchart
                        :options="chartOptions"
                        :series="weekchartData"
                      ></apexchart>
                    </div>

                    <div v-show="activeTable === 'Current-day'">
                      <apexchart
                        :options="chartOptions"
                        :series="daychartData"
                      ></apexchart>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="column is-5">
              <div
                class="card"
                style="
                  box-shadow: none;
                  border-radius: 0;
                  height: 100%;
                  background-color: white;
                "
              >
                <div
                  class="card-content is-flex is-flex-direction-column is-align-items-center is-justify-content-center"
                  style="height: 100%"
                >
                  <div class="card mb-4" style="width: 100%">
                    <div class="card-content">
                      <p class="tag is-light subtitle is-6">All bookings</p>
                      <span
                        class="tag is-link is-light subtitle is-6"
                        style="color: #3850b7 !important"
                      >
                        <div v-if="operationalData">
                          {{ operationalData.count_all_bookings.original }}
                        </div>
                      </span>

                      <router-link
                        to="/management/bookings"
                        class="button is-primary is-small has-text-white"
                        type="button"
                        >View</router-link
                      >
                    </div>
                  </div>

                  <div class="card mb-4" style="width: 100%">
                    <div class="card-content">
                      <p class="tag is-light subtitle is-6">Ongoing bookings</p>
                      <span
                        class="tag is-link is-light subtitle is-6"
                        style="color: #3850b7 !important"
                      >
                        <div v-if="operationalData">
                          {{ operationalData.count_ongoing_bookings.original }}
                        </div>
                      </span>
                      <router-link
                        to="/management/bookings"
                        class="button is-primary is-small has-text-white"
                        type="button"
                        >View</router-link
                      >
                    </div>
                  </div>

                  <div class="card mb-4" style="width: 100%">
                    <div class="card-content">
                      <p class="tag is-light subtitle is-6">Upcoming bookings</p>
                      <span
                        class="tag is-link is-light subtitle is-6"
                        style="color: #3850b7 !important"
                      >
                        <div v-if="operationalData">
                          {{ operationalData.count_future_bookings.original }}
                        </div>
                      </span>
                      <router-link
                        to="/management/bookings"
                        class="button is-primary is-small has-text-white"
                        type="button"
                        >View</router-link
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <hr
            style="
              background-color: #f5f5f5;
              border: none;
              display: block;
              height: 2px;
              margin: 1.5rem 0;
            "
          />

          <div class="columns is-centered">
            <div class="column is-2">
              <div class="card" style="height: 100%">
                <div class="card-content">
                  <p class="subtitle is-7">Total cars</p>
                  <span
                    class="tag is-link is-light subtitle is-6"
                    style="color: #3850b7 !important"
                  >
                    <div v-if="fleetData">
                      {{ fleetData.total_cars }}
                    </div>
                  </span>
                  <router-link
                    to="/management/cars"
                    class="button is-primary is-small has-text-white"
                    type="button"
                    >View</router-link
                  >
                </div>
              </div>
            </div>

            <div class="column is-2">
              <div class="card" style="height: 100%">
                <div class="card-content">
                  <p class="subtitle is-7">Maintenance</p>
                  <span
                    class="tag is-link is-light subtitle is-6"
                    style="color: #3850b7 !important"
                  >
                    <div v-if="fleetData">
                      {{ fleetData.cars_under_maintenance }}
                    </div></span
                  >
                  <router-link
                    to="/management/carsmaintenance"
                    class="button is-primary is-small has-text-white"
                    type="button"
                    >View</router-link
                  >
                </div>
              </div>
            </div>

            <div class="column is-2">
              <div class="card" style="height: 100%">
                <div class="card-content">
                  <p class="subtitle is-7">Operative cars</p>
                  <span
                    class="tag is-link is-light subtitle is-6"
                    style="color: #3850b7 !important"
                  >
                    <div v-if="fleetData">
                      {{ fleetData.operative_cars }}
                    </div></span
                  >
                </div>
              </div>
            </div>

            <div class="column is-2">
              <div class="card" style="height: 100%">
                <div class="card-content">
                  <p class="subtitle is-7">Rented cars</p>
                  <span
                    class="tag is-link is-light subtitle is-6"
                    style="color: #3850b7 !important"
                  >
                    <div v-if="fleetData">
                      {{ fleetData.rented_Cars }}
                    </div></span
                  >
                </div>
              </div>
            </div>

            <div class="column is-2">
              <div class="card" style="height: 100%">
                <div class="card-content">
                  <p class="subtitle is-7">On stock</p>
                  <span
                    class="tag is-link is-light subtitle is-6"
                    style="color: #3850b7 !important"
                    ><div v-if="fleetData">
                      {{ fleetData.on_stock_cars }}
                    </div></span
                  >
                </div>
              </div>
            </div>
          </div>

          <hr
            style="
              background-color: #f5f5f5;
              border: none;
              display: block;
              height: 2px;
              margin: 1.5rem 0;
            "
          />

          <div class="card" style="box-shadow: none; border-radius: 0">
            <div class="card-content">
              <p
                class="tag is-link is-light subtitle is-7"
                style="color: #3850b7 !important"
              >
                All customers
              </p>
              <span
                class="tag is-link is-light subtitle is-7"
                style="color: #3850b7 !important"
                ><div v-if="customerData">
                  {{ customerData.number_of_all_customers.original.email_count }}
                </div></span
              >

              <router-link
                to="/management/customers"
                class="button is-primary is-small has-text-white"
                type="button"
                >View</router-link
              >
            </div>
          </div>

          <div class="columns is-multiline">
            <div class="column is-6">
              <div class="card" style="height: 100%">
                <div class="card-content">
                  <p
                    class="tag is-link is-light subtitle is-7"
                    style="color: #3850b7 !important"
                  >
                    New customers
                  </p>
                  <span
                    class="tag is-link is-light subtitle is-7"
                    style="color: #3850b7 !important"
                  >
                    <div v-if="customerData">
                      {{ customerData.number_of_new_customers.original }}
                    </div>
                  </span>

                  <div class="table-container">
                    <table class="table is-fullwidth is-narrow has-background-white">
                      <thead>
                        <tr>
                          <th>
                            <abbr title="Position" style="color: #4a4a4a !important"
                              >Pos</abbr
                            >
                          </th>
                          <th>
                            <abbr
                              title="Only for authenticated users"
                              style="color: #4a4a4a !important"
                              >User ID</abbr
                            >
                          </th>
                          <th>
                            <abbr title="Email address" style="color: #4a4a4a !important"
                              >Email</abbr
                            >
                          </th>
                          <th>
                            <abbr title="Phone number" style="color: #4a4a4a !important"
                              >Phone</abbr
                            >
                          </th>

                          <th style="color: #4a4a4a !important">
                            <abbr title="Phone number">start date</abbr>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(booking, index) in newpaginatedBookings"
                          :key="booking.id"
                        >
                          <th style="color: #4a4a4a !important">{{ index + 1 }}</th>
                          <td style="color: #4a4a4a !important">
                            {{ booking.user_id }}
                          </td>
                          <td style="color: #4a4a4a !important">
                            {{ booking.email_address }}
                          </td>
                          <td style="color: #4a4a4a !important">
                            {{ booking.phone_number }}
                          </td>

                          <td style="color: #4a4a4a !important">
                            {{ booking.start_date }}
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <button
                      class="button is-small mr-2"
                      @click="newnextPage"
                      :disabled="newend >= new_customers.length"
                    >
                      Next
                    </button>
                    <button
                      class="button is-small"
                      @click="newprevPage"
                      :disabled="newstart <= 0"
                    >
                      Previous
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="column is-6">
              <div class="card" style="height: 100%">
                <div class="card-content">
                  <p
                    class="tag is-link is-light subtitle is-7"
                    style="color: #3850b7 !important"
                  >
                    Ongoing customers
                  </p>

                  <span
                    class="tag is-link is-light subtitle is-7"
                    style="color: #3850b7 !important"
                  >
                    <div v-if="customerData">
                      {{ customerData.number_of_ongoing_customers.original }}
                    </div>
                  </span>

                  <div class="table-container">
                    <table class="table is-fullwidth is-narrow has-background-white">
                      <thead>
                        <tr>
                          <th>
                            <abbr title="Position" style="color: #4a4a4a !important"
                              >Pos</abbr
                            >
                          </th>
                          <th style="color: #4a4a4a !important">
                            <abbr title="Only for authenticated users">User ID</abbr>
                          </th>
                          <th style="color: #4a4a4a !important">
                            <abbr title="Email address">Email</abbr>
                          </th>
                          <th style="color: #4a4a4a !important">
                            <abbr title="Phone number">Phone</abbr>
                          </th>

                          <th style="color: #4a4a4a !important">
                            <abbr title="Phone number">start date</abbr>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(booking, index) in paginatedBookings"
                          :key="booking.id"
                        >
                          <th style="color: #4a4a4a !important">{{ index + 1 }}</th>
                          <td style="color: #4a4a4a !important">
                            {{ booking.user_id }}
                          </td>
                          <td style="color: #4a4a4a !important">
                            {{ booking.email_address }}
                          </td>
                          <td style="color: #4a4a4a !important">
                            {{ booking.phone_number }}
                          </td>

                          <td style="color: #4a4a4a !important">
                            {{ booking.start_date }}
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <button
                      class="button is-small mr-2"
                      @click="nextPage"
                      :disabled="end >= ongoing_customers.length"
                    >
                      Next
                    </button>
                    <button
                      class="button is-small"
                      @click="prevPage"
                      :disabled="start <= 0"
                    >
                      Previous
                    </button>
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
//import { useRouter } from "vue-router"; // Import Vue Router

import { handleUnauthorizedError } from "@/utils/auth"; // Import the function

import { ref, onMounted, watch, computed } from "vue";
import axios from "axios";
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
    //   const router = useRouter(); // Initialize the router
    const loading = ref(true);

    const start = ref(0);
    const end = ref(10);

    const newstart = ref(0);
    const newend = ref(10);

    //const error = ref(null);
    const financialData = ref();
    const operationalData = ref();
    const fleetData = ref();
    const customerData = ref();
    const ongoing_customers = ref([]);
    const new_customers = ref([]);

    const Revenue = ref();
    const Expenses = ref();
    const Net = ref();
    const dataChart = ref([]);

    const selectedTimeRange = ref("All time"); // Default value
    const selectedTimeRangeForChart = ref("Current year"); // Default value

    const activeTable = ref("Current-year");

    function showTable(tableId) {
      activeTable.value = tableId;
    }

    // Data series for the chart
    const yearchartData = ref([
      {
        name: "Revenue",
        data: [], // Initially empty, will be populated with financial data later
      },
    ]);

    const monthchartData = ref([
      {
        name: "Revenue",
        data: [], // Initially empty, will be populated with financial data later
      },
    ]);

    const weekchartData = ref([
      {
        name: "Revenue",
        data: [], // Initially empty, will be populated with financial data later
      },
    ]);

    const daychartData = ref([
      {
        name: "Revenue",
        data: [], // Initially empty, will be populated with financial data later
      },
    ]);

    // Computed property to slice the ongoing_customers array
    const paginatedBookings = computed(() => {
      return ongoing_customers.value.slice(start.value, end.value);
    });

    // Methods for pagination
    const nextPage = () => {
      start.value += 10;
      end.value += 10;
    };

    const prevPage = () => {
      start.value -= 10;
      end.value -= 10;
    };

    // Computed property to slice the ongoing_customers array
    const newpaginatedBookings = computed(() => {
      return new_customers.value.slice(newstart.value, newend.value);
    });

    // Methods for pagination
    const newnextPage = () => {
      newstart.value += 10;
      newend.value += 10;
    };

    const newprevPage = () => {
      newstart.value -= 10;
      newend.value -= 10;
    };

    watch(selectedTimeRange, (newData) => {
      if (newData === "All time") {
        Revenue.value = financialData.value.total_revenue;
        Expenses.value = financialData.value.total_expenses;
        Net.value = financialData.value.total_net_profit;
      }

      if (newData === "Current year") {
        Revenue.value = financialData.value.yearly_revenue;
        Expenses.value = financialData.value.yearly_expenses;
        Net.value = financialData.value.yearly__net_profit;
      }

      if (newData === "Current month") {
        Revenue.value = financialData.value.monthly_revenue;
        Expenses.value = financialData.value.monthly_expenses;
        Net.value = financialData.value.monthly__net_profit;
      }

      if (newData === "Current week") {
        Revenue.value = financialData.value.weekly_revenue;
        Expenses.value = financialData.value.weekly_expenses;
        Net.value = financialData.value.weekly__net_profit;
      }

      if (newData === "Current day") {
        Revenue.value = financialData.value.daily_revenue;
        Expenses.value = financialData.value.daily_expenses;
        Net.value = financialData.value.daily__net_profit;
      }
    });

    const fetchData = async () => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/dash`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`, // Include token if needed
          },
        });

        financialData.value = response.data.financialData.original;

        operationalData.value = response.data.operationalData.original;

        fleetData.value = response.data.fleetData.original;

        customerData.value = response.data.customerData.original;

        ongoing_customers.value =
          response.data.customerData.original.ongoing_customers.original;

        new_customers.value = response.data.customerData.original.new_customers.original;

        Revenue.value = financialData.value.total_revenue;
        Expenses.value = financialData.value.total_expenses;
        Net.value = financialData.value.total_net_profit;

        dataChart.value = financialData.value;

        yearchartData.value = [
          {
            name: "Revenue",
            data: dataChart.value.yearly_trend_revenue, // Initially empty, will be populated with financial data later
          },
        ];

        monthchartData.value = [
          {
            name: "Revenue",
            data: dataChart.value.monthly_trend_revenue, // Initially empty, will be populated with financial data later
          },
        ];

        weekchartData.value = [
          {
            name: "Revenue",
            data: dataChart.value.weekly_trend_revenue, // Initially empty, will be populated with financial data later
          },
        ];

        daychartData.value = [
          {
            name: "Revenue",
            data: dataChart.value.daily_trend_revenue, // Initially empty, will be populated with financial data later
          },
        ];
      } catch (error) {
        handleUnauthorizedError(error);

        error.value = error.message;
      } finally {
        loading.value = false; // Stop loading
      }
    };

    onMounted(fetchData);

    return {
      financialData,
      operationalData,
      fleetData,
      customerData,
      ongoing_customers,
      new_customers,

      selectedTimeRange,
      Revenue,
      Expenses,
      Net,
      selectedTimeRangeForChart,
      // Data series for the chart

      yearchartData,
      monthchartData,
      weekchartData,
      daychartData,

      showTable,
      activeTable,

      start,
      end,
      paginatedBookings,
      nextPage,
      prevPage,
      newstart,
      newend,
      newpaginatedBookings,
      newnextPage,
      newprevPage,
      loading,
      // Chart configuration
      chartOptions: {
        chart: {
          height: 350,
          type: "line",
          stacked: false,
        },
        markers: {
          size: 1,
        },

        fill: {
          type: "gradient",
        },

        stroke: {
          curve: "smooth",
        },

        title: {
          text: "Revenue Over Time",
          align: "center",
        },
      },
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
  max-width: 1400px !important;
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
