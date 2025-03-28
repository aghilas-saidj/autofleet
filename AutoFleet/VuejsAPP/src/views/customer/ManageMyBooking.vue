<template>
  <div>
    <!-- Navbar -->
    <NavBar />

    <div class="container">
      <div class="columns is-multiline">
        <div class="column is-12">
          <div class="button is-white is-small">
            <router-link to="/cars" class="">
              <span class="icon">
                <font-awesome-icon icon="arrow-left" style="margin-right: 0.5rem" />
              </span>

              <span>View All Cars</span></router-link
            >
          </div>

          <div class="">
            <div class="card-content">
              <div class="notification has-text-white" style="background-color: #3e8ed0">
                In case you need need to cancel or to adjust your booking, please
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

          <div class="column is-12">
            <div class="card">
              <div class="card-content">
                <div v-if="bookingDetails">
                  <h2 class="title is-4 has-text-black">Booking Details</h2>
                  <div class="tags">
                    <span class="tag is-warning"
                      >Start Date: {{ bookingDetails.start_date }}</span
                    >
                    <span class="tag is-danger"
                      >End Date: {{ bookingDetails.end_date }}</span
                    >
                    <span class="tag is-link"
                      >Total Price: ${{ bookingDetails.total_price }}</span
                    >
                  </div>

                  <hr />

                  <div class="tags">
                    <span class="tag is-success"
                      >Pickup Location: {{ bookingDetails.pickuplocation }}</span
                    >
                  </div>

                  <div class="tags">
                    <span class="tag is-warning"
                      >Dropoff Location: {{ bookingDetails.dropofflocation }}</span
                    >
                  </div>

                  <hr />

                  <div class="tags mt-4">
                    <span class="tag is-primary"
                      >Reference Code: {{ bookingDetails.reference_code }}</span
                    >
                    <span class="tag is-info"
                      >Email: {{ bookingDetails.email_address }}</span
                    >

                    <span class="tag is-danger"
                      >Phone: {{ bookingDetails.phone_number }}</span
                    >
                  </div>

                  <div class="tags mt-4">
                    <span class="tag is-link"
                      >Additional Info: {{ bookingDetails.additional_info }}</span
                    >
                    <span class="tag is-light">Status: {{ bookingDetails.status }}</span>
                  </div>
                </div>
                <div v-else>
                  <p class="has-text-danger">No booking details found.</p>
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
import { useRoute } from "vue-router";
import NavBar from "../../components/NavBar.vue";
import FooterElement from "../../components/FooterElement.vue";

export default {
  components: {
    NavBar,
    FooterElement,
  },

  setup() {
    const isAuth = ref(localStorage.getItem("Authentication_status") === "true");

    const route = useRoute(); // Access the current route
    const bookingDetails = ref(null);

    onMounted(() => {
      const bookingQuery = route.query.booking;
      if (bookingQuery) {
        bookingDetails.value = JSON.parse(bookingQuery); // Parse the booking details
      }
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

    return { bookingDetails, contactSupport, isAuth, NavBar };
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
