import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const state = {
  incomes: [],
  income: null,
  income_types: [],
};

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
};
