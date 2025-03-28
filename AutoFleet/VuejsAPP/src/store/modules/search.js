export default {
    namespaced: true,
    state: {
      pickupLocation: localStorage.getItem("pickupLocation") || "any",
      pickupDate: localStorage.getItem("pickupDate") || "",
      pickupTime: localStorage.getItem("pickupTime") || "",
      dropoffLocation: localStorage.getItem("dropoffLocation") || "any",
      dropoffDate: localStorage.getItem("dropoffDate") || "",
      dropoffTime: localStorage.getItem("dropoffTime") || "",
    },
    mutations: {
      SET_PICKUP_LOCATION(state, value) {
        state.pickupLocation = value;
        localStorage.setItem("pickupLocation", value);
      },
      SET_PICKUP_DATE(state, value) {
        state.pickupDate = value;
        localStorage.setItem("pickupDate", value);
      },
      SET_PICKUP_TIME(state, value) {
        state.pickupTime = value;
        localStorage.setItem("pickupTime", value);
      },
      SET_DROPOFF_LOCATION(state, value) {
        state.dropoffLocation = value;
        localStorage.setItem("dropoffLocation", value);
      },
      SET_DROPOFF_DATE(state, value) {
        state.dropoffDate = value;
        localStorage.setItem("dropoffDate", value);
      },
      SET_DROPOFF_TIME(state, value) {
        state.dropoffTime = value;
        localStorage.setItem("dropoffTime", value);
      },
    },
    actions: {
      updatePickupLocation({ commit }, value) {
        commit("SET_PICKUP_LOCATION", value);
      },
      updatePickupDate({ commit }, value) {
        commit("SET_PICKUP_DATE", value);
      },
      updatePickupTime({ commit }, value) {
        commit("SET_PICKUP_TIME", value);
      },
      updateDropoffLocation({ commit }, value) {
        commit("SET_DROPOFF_LOCATION", value);
      },
      updateDropoffDate({ commit }, value) {
        commit("SET_DROPOFF_DATE", value);
      },
      updateDropoffTime({ commit }, value) {
        commit("SET_DROPOFF_TIME", value);
      },
    },
  };
  