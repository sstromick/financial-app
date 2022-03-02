import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const state = {
  payment: {
    id: null,
    submission_id: null,
    uid: null,
    approved: null,
  }
};

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
};
