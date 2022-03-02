import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const state = {
  credit_accounts: [],
  credit_account: {
    debt_type: null,
    creditor: null,
    account_number: null,
    monthly_payment: null,
    interest_rate: null,
    balance_owed: null,
    past_due: null,
  },
  credit_account_debt_types: [],
};

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
};
