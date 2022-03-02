import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const state = {
  expenses: [],
  expense: {
    submission_id: null,
    expense_type: null,
    expense_value: null,
    expense_category: null,
  },
  expense_types: [],
  expense_categories: [],
  enabled_expense_categories: [],
  filtered_expense_types: [],
  filtered_expenses: [],
  current_expense_category: null,
  previous_expense_category: null,
  next_expense_category: null,
};

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
};
