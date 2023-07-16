import { createStore } from 'vuex';

const isLoadingStore = createStore({
  state() {
    return {
      isLoading: false,
    };
  },
  mutations: {
    setIsLoading(state, value) {
      state.isLoading = value;
    },
  },
});

export default isLoadingStore;