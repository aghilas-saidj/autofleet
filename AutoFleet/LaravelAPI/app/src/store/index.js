import { createStore } from 'vuex';

export default createStore({
  state: {
    minprice:null,
    maxprice:null,
    minseats:null,
    from:'',
    to:''
  },

  mutations: {

    setMinPrice(state , newMinPrice)
    {
        state.minprice = newMinPrice;
    },

    setMaxPrice(state , newMaxPrice)
    {
        state.maxprice = newMaxPrice;
    },


    setMinSeats(state , newMinSeats)
    {
        state.minseats = newMinSeats;
    },

    setFrom(state , newFrom)
    {
        state.from = newFrom;
    },

    setTo(state , newTo)
    {
        state.to = newTo;
    },


},

  actions: {
    updateMinPrice({ commit }, newMinPrice) {
      commit('setMinPrice', newMinPrice); // Call mutation to update price
    },

    updateMaxPrice({ commit }, newMaxPrice) {
        commit('setMaxPrice', newMaxPrice); // Call mutation to update price
      },

    updateMinSeats({ commit }, newMinSeats) {
    commit('setMinSeats', newMinSeats); // Call mutation to update price
    },

    updateFrom({ commit }, newFrom) {
    commit('setFrom', newFrom); // Call mutation to update price
    },

    updateTo({ commit }, newTo) {
    commit('setTo', newTo); // Call mutation to update price
    },



  },
  getters: {

  },
});
