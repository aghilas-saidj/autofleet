<template>
  <div>
    <NavBar />

    <section class="hero is-white">
      <div class="hero-body">
        <p class="title">Book Your Dream Car</p>
        <p class="subtitle">Anytime, Anywhere! 🚗✨</p>
      </div>
    </section>

    <hr style="background-color: #f5f5f5 !important" />

    <div class="container" style="min-height: 100vh">
      <div class="columns multilines">
        <div class="column is-6">
          <div class="card has-background-white" style="height: 100% !important">
            <div class="card-content">
              <div class="columns is-multiline is-flex" style="width: 100%">
                <div
                  class="column is-12 is-flex"
                  style="display: flex; justify-content: center; align-items: center"
                >
                  <div class="columns is-multiline" style="width: 100%">
                    <div class="column is-12">
                      <label for="" style="color: #4a4a4a">
                        <font-awesome-icon icon="map-marker-alt" /> Pickup location</label
                      >
                      <div class="select is-success" style="width: 100%">
                        <select
                          v-model="pickupLocation"
                          class="subtitle is-6"
                          style="width: 100%; color: #4a4a4a"
                        >
                          <option>any</option>
                          <option
                            v-for="location in locations"
                            :key="location.id"
                            :value="location.name"
                          >
                            {{ location.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <div class="column is-12 is-flex" style="width: 100%">
                      <div style="width: 100%; color: #4a4a4a">
                        <label for=""
                          ><font-awesome-icon icon="calendar-alt" /> Pickup date</label
                        ><input
                          v-model="pickupDate"
                          class="input is-success"
                          type="date"
                          style="width: 100%; color: #4a4a4a"
                        />
                      </div>

                      <div>
                        <label for="" style="color: #4a4a4a">
                          <font-awesome-icon icon="clock" /> Time</label
                        >
                        <input
                          v-model="pickupTime"
                          class="is-success input"
                          type="time"
                          style="width: 100%; color: #4a4a4a"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <hr style="background-color: #f5f5f5 !important" />

              <div class="columns is-multiline is-flex" style="width: 100%">
                <div
                  class="column is-12 is-flex"
                  style="display: flex; justify-content: center; align-items: center"
                >
                  <div class="columns is-multiline" style="width: 100%">
                    <div class="column is-12">
                      <label for="" style="color: #4a4a4a"
                        ><font-awesome-icon icon="map-marker-alt" /> Dropoff
                        location</label
                      >
                      <div class="select is-success" style="width: 100%; color: #4a4a4a">
                        <select
                          v-model="dropoffLocation"
                          class="subtitle is-6"
                          style="width: 100%; color: #4a4a4a"
                        >
                          <option>any</option>
                          <option
                            v-for="location in locations"
                            :key="location.id"
                            :value="location.name"
                          >
                            {{ location.name }}
                          </option>
                        </select>
                      </div>
                    </div>

                    <div class="column is-12 is-flex" style="width: 100%; color: #4a4a4a">
                      <div style="width: 100%; color: #4a4a4a">
                        <label for=""
                          ><font-awesome-icon icon="calendar-alt" /> Dropoff date</label
                        ><input
                          v-model="dropoffDate"
                          class="input is-success"
                          type="date"
                          style="width: 100%; color: #4a4a4a"
                        />
                      </div>

                      <div>
                        <label for="" style="color: #4a4a4a"
                          ><font-awesome-icon icon="clock" /> Time</label
                        >
                        <input
                          v-model="dropoffTime"
                          class="is-success input"
                          type="time"
                          style="width: 100%; color: #4a4a4a"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button
                @click="searchCars"
                class="button is-primary has-text-weight-bold has-text-white"
              >
                Search
              </button>
            </div>
          </div>
        </div>

        <div class="column is-6">
          <div class="" style="height: 100% !important">
            <div class="card-image">
              <figure class="image">
                <img src="images/5243041.jpg" alt="Placeholder image" loading="lazy" />
              </figure>
            </div>
            <div class="card-content">
              <div class="media">
                <div class="media-left"></div>
                <div class="media-content"></div>
              </div>

              <!-- <div class="content">
                <p class="subtitle">Book Now & Drive with Confidence!</p>
                <p>Find the perfect car in just a few clicks.</p>
                <p>📍Select Location | 📅 Pick Your Dates | 🚀 Start Your Journey!</p>
                <br />
              </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="columns">
        <!-- Review 1 -->
        <div class="column is-4">
          <div class="card" style="height: 100% !important">
            <div class="card-content">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-48x48">
                    <img class="is-rounded" src="images/man.png" alt="User Avatar" />
                  </figure>
                </div>
                <div class="media-content">
                  <p class="title is-6">Username</p>
                  <p class="subtitle is-7">@username1</p>
                </div>
              </div>
              <div class="content">
                ⭐⭐⭐⭐☆ <br />
                "Great service and very convenient! The car was clean and
                well-maintained."
              </div>
            </div>
          </div>
        </div>

        <!-- Review 2 -->
        <div class="column is-4">
          <div class="card" style="height: 100% !important">
            <div class="card-content">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-48x48">
                    <img class="is-rounded" src="images/boy.png" alt="User Avatar" />
                  </figure>
                </div>
                <div class="media-content">
                  <p class="title is-6">Username</p>
                  <p class="subtitle is-7">@username12</p>
                </div>
              </div>
              <div class="content">
                ⭐⭐⭐⭐⭐ <br />
                "Excellent experience! Smooth booking process and friendly customer
                support."
              </div>
            </div>
          </div>
        </div>

        <!-- Review 3 -->
        <div class="column is-4">
          <div class="card" style="height: 100% !important">
            <div class="card-content">
              <div class="media">
                <div class="media-left">
                  <figure class="image is-48x48">
                    <img class="is-rounded" src="images/woman.png" alt="User Avatar" />
                  </figure>
                </div>
                <div class="media-content">
                  <p class="title is-6">Username</p>
                  <p class="subtitle is-7">@username123</p>
                </div>
              </div>
              <div class="content">
                ⭐⭐⭐⭐☆ <br />
                "Loved the variety of cars available! Will definitely rent again."
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="columns is-vcentered">
        <!-- Column with Image Card -->
        <div class="column is-6">
          <div class="" style="height: 100% !important">
            <div class="card-image">
              <figure class="image">
                <img src="images/7957571.jpg" alt="Car Rental Image" />
              </figure>
            </div>
          </div>
        </div>

        <!-- Column with Text Content -->
        <div class="column is-6">
          <div class="content">
            <h2 class="title is-4">Rent Your Dream Car Today!</h2>
            <p class="subtitle is-6">
              Choose from a wide variety of cars at unbeatable prices. Whether you need a
              luxury ride for a special occasion or an economy car for daily travel, we
              have the perfect vehicle for you.
            </p>
            <button
              @click="scrollToTop"
              class="button is-primary is-medium has-text-white"
            >
              Book Now
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="section has-background-light">
      <h2 class="title is-3 has-text-centered">Why Choose Our Car Rental Service?</h2>

      <div class="container">
        <div class="columns is-multiline">
          <!-- Feature 1 -->
          <div class="column is-4">
            <div class="card" style="height: 100% !important">
              <div class="card-content has-text-centered">
                <span class="icon is-large has-text-primary">
                  <font-awesome-icon icon="car" size="3x" />
                </span>
                <h3 class="title is-5">Wide Selection of Cars</h3>
                <p class="subtitle is-6">
                  From economy to luxury, we have the perfect car for every need.
                </p>
              </div>
            </div>
          </div>

          <!-- Feature 2 -->
          <div class="column is-4">
            <div class="card" style="height: 100% !important">
              <div class="card-content has-text-centered">
                <span class="icon is-large has-text-success">
                  <font-awesome-icon icon="clock" size="3x" />
                </span>
                <h3 class="title is-5">24/7 Customer Support</h3>
                <p class="subtitle is-6">
                  Our support team is always available to assist you.
                </p>
              </div>
            </div>
          </div>

          <!-- Feature 3 -->
          <div class="column is-4">
            <div class="card" style="height: 100% !important">
              <div class="card-content has-text-centered">
                <span class="icon is-large has-text-success">
                  <font-awesome-icon icon="fan" size="3x" />
                </span>
                <h3 class="title is-5">Affordable & Transparent Pricing</h3>
                <p class="subtitle is-6">
                  No hidden fees. Get the best rates with complete transparency.
                </p>
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
import NavBar from "../../components/NavBar.vue";
import FooterElement from "../../components/FooterElement.vue";

import { useRouter } from "vue-router"; // Vue Router for navigation
import { ref, onMounted } from "vue";
import axios from "axios";
import config from "@/config";
import { useStore } from "vuex";

export default {
  components: {
    NavBar,
    FooterElement,
  },
  setup() {
    const router = useRouter(); // Use Vue Router instance
    const store = useStore();

    const pickupLocation = ref("any");
    const pickupDate = ref(getFormattedDate(1));
    const pickupTime = ref("10:00");
    const dropoffLocation = ref("any");
    const dropoffDate = ref(getFormattedDate(3));
    const dropoffTime = ref("10:00");
    const locations = ref([]);

    function getFormattedDate(daysToAdd) {
      const date = new Date();
      date.setDate(date.getDate() + daysToAdd);
      return date.toISOString().split("T")[0]; // Format: YYYY-MM-DD
    }

    const scrollToTop = () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    };

    const searchCars = () => {
      // localStorage.setItem("pickupLocation", pickupLocation.value);
      // localStorage.setItem("pickupDate", pickupDate.value);
      // localStorage.setItem("pickupTime", pickupTime.value);
      // localStorage.setItem("dropoffLocation", dropoffLocation.value);
      // localStorage.setItem("dropoffDate", dropoffDate.value);
      // localStorage.setItem("dropoffTime", dropoffTime.value);

      store.commit("search/SET_PICKUP_LOCATION", pickupLocation.value);
      store.commit("search/SET_PICKUP_DATE", pickupDate.value);
      store.commit("search/SET_PICKUP_TIME", pickupTime.value);
      store.commit("search/SET_DROPOFF_LOCATION", dropoffLocation.value);
      store.commit("search/SET_DROPOFF_DATE", dropoffDate.value);
      store.commit("search/SET_DROPOFF_TIME", dropoffTime.value);

      router.push({
        name: "cars", // Name of the route for the ManageMyRental page
      });
    };

    onMounted(() => {
      fetchLocations();
    });
    // Fetch locations from the API when the component is mounted
    const fetchLocations = async () => {
      try {
        const response = await axios.get(`${config.API_BASE_URL}/locations`);

        locations.value = response.data;
        // Assuming locations.value is your array of location objects
        const uniqueLocations = locations.value.filter(
          (value, index, self) =>
            index ===
            self.findIndex(
              (t) => t.name === value.name // Filter based on the 'name' property
            )
        );
        // Now, `uniqueLocations` contains only unique location names
        locations.value = uniqueLocations; // Update your original array
      } catch (error) {
        console.error("Error fetching locations:", error);
      }
    };

    return {
      NavBar,
      scrollToTop,
      searchCars,
      pickupLocation,
      pickupDate,
      pickupTime,
      dropoffLocation,
      dropoffDate,
      dropoffTime,
      locations,
    };
  },
};
</script>

<style></style>
