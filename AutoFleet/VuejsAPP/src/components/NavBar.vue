<template>
  <nav
    class="navbar has-background-link"
    role="navigation"
    aria-label="main navigation"
    style="background-color: #485fc7 !important"
  >
    <div class="navbar-brand">
      <div class="navbar-item">
        <a href="/">
          <img
            src="../../public/Efa__1_-removebg-preview.png"
            alt="Logo"
            style="max-height: 50px; width: auto"
          />
        </a>
      </div>

      <a
        role="button"
        class="navbar-burger has-text-white"
        aria-label="menu"
        aria-expanded="false"
        data-target="navbarBasicExample"
        :class="{ 'is-active': isMenuOpen }"
        @click="toggleMenu"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div
      id="navbarBasicExample"
      class="navbar-menu"
      :class="{ 'is-active': isMenuOpen }"
      style="background-color: #485fc7"
    >
      <div class="navbar-start">
        <router-link class="navbar-item has-text-white" to="/">Home</router-link>
        <router-link class="navbar-item has-text-white" to="/aboutus"
          >About us</router-link
        >

        <router-link class="navbar-item has-text-white" to="/contactus"
          >Contact us</router-link
        >

        <router-link class="navbar-item has-text-white" to="/cars">Cars</router-link>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <!-- Check if the user is not authenticated -->
            <router-link
              v-if="!isAuth"
              to="/register"
              class="button is-primary has-text-white"
              ><strong>Sign up</strong></router-link
            >
            <router-link v-if="!isAuth" to="/login" class="button is-light"
              >Log in</router-link
            >

            <router-link
              v-if="isAuth"
              to="/profile"
              class="button is-light has-text-black is-small"
              ><strong> <font-awesome-icon icon="user" class="icon" /></strong
            ></router-link>

            <div
              v-if="isAuth"
              @click="confirmLogout"
              class="button is-danger has-text-white is-small"
            >
              <font-awesome-icon icon="sign-out-alt" class="icon" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { ref } from "vue";
import { useRouter } from "vue-router"; // Vue Router for navigation

export default {
  setup() {
    const router = useRouter(); // Use Vue Router instance
    const isMenuOpen = ref(false);
    const isAuth = ref(localStorage.getItem("Authentication_status") === "true");

    const toggleMenu = () => {
      isMenuOpen.value = !isMenuOpen.value;
    };

    const confirmLogout = () => {
      const confirmed = window.confirm("Are you sure you want to log out?");
      if (confirmed) {
        logout();
      }
    };

    // Method to process logout
    const logout = () => {
      // Remove items from localStorage
      localStorage.removeItem("token");
      localStorage.removeItem("Authentication_status");
      localStorage.removeItem("userID");
      localStorage.removeItem("IsAdmin");

      // Redirect to login page after logout
      router.push({ name: "LoginPage" });
    };

    return {
      isMenuOpen,
      toggleMenu,
      isAuth,
      confirmLogout,
    };
  },
};
</script>
