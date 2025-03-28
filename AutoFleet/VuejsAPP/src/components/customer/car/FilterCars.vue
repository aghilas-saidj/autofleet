<template>
  <div>
    <div v-if="!isMobile || showFilter" class="">
      <div class="card has-background-white is-focused">
        <div class="card-content">
          <h3 class="title is-6" style="color: #363636 !important">
            <i class="fas fa-filter"></i><font-awesome-icon icon="filter" /> Filter
          </h3>

          <hr style="background-color: #f5f5f5 !important" />

          <div class="field">
            <label class="label" style="color: #363636 !important">
              <font-awesome-icon icon="car" /> Type</label
            >
            <div class="control">
              <div class="select">
                <select v-model="carType" style="color: #4a4a4a">
                  <option value="">Any</option>
                  <option v-for="type in carTypes" :key="type" :value="type">
                    {{ type }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <hr style="background-color: #f5f5f5 !important" />

          <div class="field">
            <label for="priceRange">Max Price (per day):</label>
            <input type="range" v-model="priceRange" min="10" max="150" id="priceRange" />
            <span>{{ priceRange }}</span>
          </div>
          <hr style="background-color: #f5f5f5 !important" />

          <div class="field">
            <label class="label" style="color: #363636 !important">
              <font-awesome-icon icon="user" /> Seats</label
            >
            <div class="control">
              <input
                v-model="seats"
                style="color: #4a4a4a"
                type="number"
                min="1"
                max="7"
                value="5"
                class="input"
                id="seatsInput"
              />
            </div>
          </div>
          <hr style="background-color: #f5f5f5 !important" />

          <div class="field">
            <label class="label" style="color: #363636 !important">
              <font-awesome-icon icon="suitcase" /> Bags</label
            >
            <div class="control">
              <input
                v-model="bags"
                style="color: #4a4a4a"
                type="number"
                min="0"
                max="5"
                value="2"
                class="input"
                id="bagsInput"
              />
            </div>
          </div>
          <hr style="background-color: #f5f5f5 !important" />

          <div class="field">
            <label class="label" style="color: #363636 !important"
              ><font-awesome-icon icon="door-open" style="margin-right: 0.5rem" />
              Doors</label
            >
            <div class="control">
              <input
                v-model="doors"
                style="color: #4a4a4a"
                type="number"
                min="2"
                max="5"
                value="4"
                class="input"
                id="doorsInput"
              />
            </div>
          </div>
          <hr style="background-color: #f5f5f5 !important" />

          <div class="field">
            <label class="label" style="color: #363636 !important"
              ><font-awesome-icon icon="cogs" /> Engine Type</label
            >
            <div class="control">
              <div class="select">
                <select v-model="engineType" style="color: #4a4a4a">
                  <option value="">Any</option>
                  <option v-for="type in engineTypes" :key="type" :value="type">
                    {{ type }}
                  </option>
                </select>
              </div>
            </div>
          </div>
          <hr style="background-color: #f5f5f5 !important" />

          <hr style="background-color: #f5f5f5 !important" />

          <button
            v-if="isMobile"
            @click="toggleFilter"
            class="button is-primary has-text-white is-small"
          >
            Apply Filters
          </button>
        </div>
      </div>
    </div>

    <div class="column is-9 has-background-white">
      <button
        v-if="isMobile"
        @click="toggleFilter"
        class="button is-primary has-text-white is-small"
      >
        <font-awesome-icon icon="filter" /> Filter
      </button>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useStore } from "vuex";

export default {
  setup() {
    const store = useStore();

    const isMobile = ref(false);
    const showFilter = ref(false);
    // Getters
    // Computed properties with `get` and `set` to update Vuex automatically
    const carType = computed({
      get: () => store.state.filter.carType,
      set: (value) => store.commit("filter/SET_CAR_TYPE", value),
    });

    const priceRange = computed({
      get: () => store.state.filter.priceRange,
      set: (value) => store.commit("filter/SET_PRICE_RANGE", Number(value)),
    });

    const seats = computed({
      get: () => store.state.filter.seats,
      set: (value) => store.commit("filter/SET_SEATS", value),
    });

    const bags = computed({
      get: () => store.state.filter.bags,
      set: (value) => store.commit("filter/SET_BAGS", value),
    });

    const doors = computed({
      get: () => store.state.filter.doors,
      set: (value) => store.commit("filter/SET_DOORS", value),
    });

    const engineType = computed({
      get: () => store.state.filter.engineType,
      set: (value) => store.commit("filter/SET_ENGINE_TYPE", value),
    });

    const carTypes = computed(() => store.state.filter.carTypes);
    const engineTypes = computed(() => store.state.filter.engineTypes);

    const toggleFilter = () => {
      showFilter.value = !showFilter.value;
    };

    const checkIfMobile = () => {
      isMobile.value = window.innerWidth <= 768; // Adjust the mobile breakpoint as needed
    };

    // Check if mobile when component is mounted
    onMounted(() => {
      checkIfMobile();
      window.addEventListener("resize", checkIfMobile);
    });

    // Cleanup event listener when the component is unmounted
    onUnmounted(() => {
      window.removeEventListener("resize", checkIfMobile);
    });

    return {
      isMobile,
      showFilter,
      carType,
      carTypes,
      priceRange,
      seats,
      bags,
      doors,
      engineType,
      engineTypes,
      toggleFilter,
    };
  },
};
</script>
