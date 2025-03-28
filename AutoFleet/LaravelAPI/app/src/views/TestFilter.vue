<template>
<v-app app>

  <v-app-bar app>
    <TopBar />
  </v-app-bar>

  <v-navigation-drawer v-model="sidebar" app>
      <SideBar />
    </v-navigation-drawer>

  <v-main app>

    <v-content>
  <div>
  <h1>Principal page</h1>

  


  <CarFilter />
  <CarList />

</div>

</v-content>
</v-main>
</v-app>
</template>


<script>

import { ref } from "vue";

import  CarFilter from "../components/CarFilter.vue";
import  CarList  from "../components/CarList.vue";
import  SideBar  from "../components/SideBar.vue";
import  TopBar  from "../components/TopBar.vue";

export default {

  components:{
    CarFilter,
    CarList,
    TopBar,
    SideBar,
  },
  setup() {

    const sidebar = ref(true); // Track the sidebar state

    const toggleSidebar = () => {
      sidebar.value = !sidebar.value; // Toggle sidebar visibility
    };

    return {
          sidebar,
          toggleSidebar,
        };
        }
}
</script>