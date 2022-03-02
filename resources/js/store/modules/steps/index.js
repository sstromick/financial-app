import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const state = {
    steps: [],
    enabled_steps: [],
    disabled_steps: [],
    current_step: null,
    previous_step: null,
    next_step: null,
    completed_steps: [],
    incomplete_steps: [],
    progress: 0,
};

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
};
