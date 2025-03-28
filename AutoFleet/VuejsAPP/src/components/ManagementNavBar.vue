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
        class="navbar-burger"
        aria-label="menu"
        aria-expanded="false"
        data-target="navbarBasicExample"
      >
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
      </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
      <div class="navbar-end">
        <div class="navbar-item">
          <!-- Profile button that navigates to User Profile -->
          <router-link to="/management/profile" class="button is-light">
            <font-awesome-icon icon="user" />
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {};
</script>
