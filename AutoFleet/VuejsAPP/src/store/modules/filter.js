// store/modules/filter.js
export default {
    namespaced: true,
    state: {
      carType: "",
      carTypes: [],
      priceRange: 100,
      seats: 1,
      bags: 1,
      doors: 1,
      engineType: "",
      engineTypes: [],
    },
    mutations: {

      SET_CAR_TYPE(state, value) {
        state.carType = value;
      },
      SET_PRICE_RANGE(state, value) {
        state.priceRange = value;
      },
      SET_SEATS(state, value) {
        state.seats = value;
      },
      SET_BAGS(state, value) {
        state.bags = value;
      },
      SET_DOORS(state, value) {
        state.doors = value;
      },
      SET_ENGINE_TYPE(state, value) {
        state.engineType = value;
      },

      SET_CAR_TYPES(state, value) {
        state.carTypes = value;
      },

      SET_ENGINE_TYPES(state, value) {
        state.engineTypes = value;
      },
    },
    actions: {

      setCarType({ commit }, value) {
        commit("SET_CAR_TYPE", value);
      },
      setPriceRange({ commit }, value) {
        commit("SET_PRICE_RANGE", value);
      },
      setSeats({ commit }, value) {
        commit("SET_SEATS", value);
      },
      setBags({ commit }, value) {
        commit("SET_BAGS", value);
      },
      setDoors({ commit }, value) {
        commit("SET_DOORS", value);
      },
      setEngineType({ commit }, value) {
        commit("SET_ENGINE_TYPE", value);
      },

      setCarTypes({ commit }, value) {
        commit("SET_CAR_TYPES", value);
      },

      setEngineTypes({ commit }, value) {
        commit("SET_ENGINE_TYPES", value);
      },
    },
  };
  