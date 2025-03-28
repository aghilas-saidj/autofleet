<template>
  <div
    class="management-sidebar card"
    style="
      height: 100%;
      margin-top: 0%;
      border-radius: 0%;
      background-color: hsl(229.1, 53.1%, 53.1%) !important;
    "
  >
    <button
      @click="toggleMenu"
      class="button is-primary is-small has-text-white"
      v-if="isMobile || (isMobile && !showMenu)"
    >
      Menu
    </button>
    <div v-if="!isMobile || showMenu" class="card-content">
      <aside class="menu">
        <p class="menu-label" style="color: #bbb">General</p>
        <ul class="menu-list">
          <li>
            <router-link to="/management/dashboard" class="menu-element"
              >Dashboard</router-link
            >
          </li>
        </ul>

        <hr style="background-color: white" />

        <p class="menu-label" style="color: #bbb">Management</p>
        <ul class="menu-list">
          <li>
            <router-link to="/management/bookings" class="menu-element"
              >Bookings</router-link
            >
          </li>
          <li>
            <router-link to="/management/customers" class="menu-element"
              >Customers</router-link
            >
          </li>
          <li>
            <router-link to="/management/cars" class="menu-element">Cars</router-link>
          </li>
          <li>
            <router-link to="/management/carsmaintenance" class="menu-element"
              >Cars under maintenance</router-link
            >
          </li>
        </ul>

        <hr style="background-color: white" />

        <p class="menu-label" style="color: #bbb">Finance</p>
        <ul class="menu-list">
          <li>
            <router-link to="/management/payments" class="menu-element"
              >Payments</router-link
            >
          </li>
          <li>
            <router-link to="/management/expenses" class="menu-element"
              >Expenses</router-link
            >
          </li>
        </ul>

        <hr style="background-color: white" />

        <p class="menu-label" style="color: #bbb">Administration</p>
        <ul class="menu-list">
          <li>
            <router-link to="/management/users" class="menu-element">Users</router-link>
          </li>
        </ul>
      </aside>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";

export default {
  setup() {
    const isMobile = ref(false);
    const showMenu = ref(false);

    // Method to check if the screen is mobile size
    const checkIfMobile = () => {
      isMobile.value = window.innerWidth <= 768; // Adjust the mobile breakpoint as needed
    };

    // Toggle filter visibility for mobile view
    const toggleMenu = () => {
      showMenu.value = !showMenu.value;
    };

    // Check if mobile when component is mounted
    onMounted(() => {
      checkIfMobile();
      window.addEventListener("resize", checkIfMobile);
    });

    // Cleanup event listener when the component is unmounted
    onUnmounted(() => {
      window.removeEventListener("resize", checkIfMobile);
    });

    return {
      isMobile,
      showMenu,
      toggleMenu,
    };
  },
};
</script>

<style>
.menu-element {
  color: white;
  text-decoration: none;
}

.menu-element:hover {
  text-decoration: underline;
}
</style>
