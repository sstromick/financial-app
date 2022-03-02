import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const state = {
  loading: true,
  alert: {
    visible: false,
    message: null,
    type: null
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  getters,
  actions
};
