import { createApp } from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import router from './routers/router'
import store from './store'; // Ensure this points to your Vuex store

loadFonts()

createApp(App)
.use(router)
  .use(vuetify)
  .use(store) // Register Vuex store
  .mount('#app')
