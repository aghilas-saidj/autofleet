import { createApp } from 'vue';
import App from './App.vue';
import 'bulma/css/bulma.css'; // Optional if you're using Bulma
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import VueApexCharts from 'vue3-apexcharts';
import store from "./store";  // Import Vuex store
import router from './router';




import { 
  faSignOutAlt,
    faFilter, 
    faCar, 
    faDoorOpen, 
    faDollarSign, 
    faCouch, 
    faUser, 
    faUsers, 
    faSuitcase, 
    faCogs, 
    faFan, 
    faRoad, 
    faCalendarAlt, 
    faClock, 
    faMapMarkerAlt,
    faArrowLeft,
    faEnvelope,
    faLock,
    faCog,
    faCoins,
  } from '@fortawesome/free-solid-svg-icons';


// Add icons to the library
library.add(
  faSignOutAlt,
  faFilter, 
  faCar, 
  faArrowLeft,
  faDoorOpen, 
  faDollarSign, 
  faCouch, 
  faSuitcase, 
  faCogs, 
  faCog,
  faUser, 
  faUsers, 
  faFan, 
  faRoad, 
  faCalendarAlt, 
  faClock, 
  faMapMarkerAlt,
  faEnvelope,
  faLock,
  faCoins,
);

createApp(App)
  .component('font-awesome-icon', FontAwesomeIcon)
  .component('apexchart', VueApexCharts)
  .use(router)
  .use(store)
  .mount('#app');
