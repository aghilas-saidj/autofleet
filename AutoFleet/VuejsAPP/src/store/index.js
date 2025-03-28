import { createStore } from "vuex";
import search from "./modules/search";
import filter from "./modules/filter";


export default createStore({
  modules: {
    search,
    filter,
  },
});
