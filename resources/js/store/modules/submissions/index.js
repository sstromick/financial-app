import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const state = {
  submission: {
      user_id: "",
      first_name: "",
      last_name: "",
      submission_type: "",
      reason: "",
  },
  submission_reasons: [],
  submission_bankruptcy_disclosure: false,
};

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
};
