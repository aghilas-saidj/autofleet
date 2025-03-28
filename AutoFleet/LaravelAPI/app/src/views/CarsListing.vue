<template>
  <v-app app>
  
    <v-app-bar app>
      <TopBar />
    </v-app-bar>


    <v-navigation-drawer
      app
      :temporary="isMobile"
      :permanent="!isMobile"
    >
      <SideBar />
    </v-navigation-drawer>

    <v-main app>
  
      <v-content>
    <CarFilter/>
    <CarList />
  
  
  </v-content>
  </v-main>
  </v-app>
  </template>
  
  
  <script>
  
  import { computed } from "vue";
  import { useDisplay } from 'vuetify'; // Ensure this line is present

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
  

      const { mdAndDown } = useDisplay(); // Vuetify's breakpoint detection

      const isMobile = computed(() => mdAndDown.value);


  

  
      return {
            isMobile,
          };
          }
  }
  </script>