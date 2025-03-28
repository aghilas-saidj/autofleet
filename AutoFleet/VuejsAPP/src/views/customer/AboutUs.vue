<template>
  <div>
    <!-- Navbar -->
    <NavBar />

    <div class="container" style="min-height: 100vh">
      <div class="columns">
        <div class="column">
          <div class="card" style="max-width: 500px; height: 100% !important">
            <div class="card-content">
              <!-- Hero Section -->
              <section class="hero bg-gray-100 py-8 px-4">
                <p class="title is-5 text-3xl font-bold text-center mb-4">About Us</p>
                <p class="text-center text-gray-600 max-w-xl mx-auto">
                  Welcome to CarRental, your trusted partner for seamless car rental
                  experiences. We aim to simplify your journey with our easy-to-use
                  platform and exceptional service.
                </p>
              </section>

              <hr style="background-color: #f5f5f5 !important" />

              <!-- Services Section -->
              <section class="services py-8 px-4 bg-white">
                <h2 class="title is-6 text-2xl font-semibold text-center mb-4">
                  Our Services
                </h2>
                <ul class="list-disc max-w-lg mx-auto text-gray-700">
                  <li>Wide range of vehicles to suit your needs</li>
                  <li>Affordable rental plans with flexible options</li>
                  <li>24/7 customer support for hassle-free travel</li>
                  <li>Convenient pickup and drop-off locations</li>
                </ul>
              </section>
              <hr style="background-color: #f5f5f5 !important" />

              <hr style="background-color: #f5f5f5 !important" />

              <!-- Vision and Mission Section -->
              <section class="vision py-8 px-4 bg-white">
                <h2 class="title is-6 text-2xl font-semibold text-center mb-4">
                  Our Vision and Mission
                </h2>
                <p class="text-gray-700 max-w-lg mx-auto text-center">
                  Our mission is to make car rental as simple and stress-free as possible.
                  We envision a world where transportation is accessible to everyone,
                  everywhere.
                </p>
              </section>
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

export default {
  components: {
    NavBar,
    FooterElement,
  },
  setup() {
    return {
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
