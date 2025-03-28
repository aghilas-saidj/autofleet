<template>
  <div>
    <NavBar />

    <div class="columns is-multiline">
      <div class="container has-background-white">
        <div class="card has-background-white">
          <div class="card-content">
            <div class="columns is-multiline">
              <div class="column i-3">
                <FilterCars />
              </div>
              <div class="column is-9 has-background-white">
                <managemybookingform />

                <SearchCars />

                <ListOfCars />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br />
    <FooterElement />
  </div>
</template>

<script>
import NavBar from "../../components/NavBar.vue";
import FooterElement from "../../components/FooterElement.vue";
import ListOfCars from "../../components/customer/car/ListOfCars.vue";
import SearchCars from "../../components/customer/car/SearchCars.vue";
import FilterCars from "../../components/customer/car/FilterCars.vue";

import managemybookingform from "../../components/customer/booking/ManageMyBookingForm.vue";

export default {
  components: {
    NavBar,
    FooterElement,
    ListOfCars,
    SearchCars,
    managemybookingform,
    FilterCars,
  },

  setup() {
    return {};
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
  width: 100% !important; /* Full width */

  color: #4a4a4a !important;
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

.filter-button {
  display: inline-block;
  margin: 10px;
}

@media (min-width: 769px) {
  .filter-button {
    display: none;
  }
}

.container {
  margin-top: 1%;
}
</style>
