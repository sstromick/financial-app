const STEPS_UPDATED = (state, payload) => {
    state.steps = payload;
};

const RESTORE_STEPS_STATE = (state, payload) => {
    state.steps = payload.steps;
    state.enabled_steps = payload.enabled_steps;
    state.disabled_steps = payload.disabled_steps;
    state.completed_steps = payload.completed_steps;
    state.incomplete_steps = payload.incomplete_steps;
    state.progress = payload.progress;

    state.next_step = payload.next_step;
    state.previous_step = payload.previous_step;
    state.current_step = payload.current_step;

    state.completed_required_enabled_steps =
        payload.completed_required_enabled_steps;
    state.incomplete_required_enabled_steps =
        payload.incomplete_required_enabled_steps;
};

const ENABLED_STEPS_UPDATED = (state, enabled_steps) => {
    state.enabled_steps = enabled_steps;
};

const DISABLED_STEPS_UPDATED = (state, disabled_steps) => {
    state.disabled_steps = disabled_steps;
};

const CURRENT_STEP_UPDATED = (state, current_step) => {
    state.current_step = current_step;
};

const PREVIOUS_STEP_UPDATED = (state, previous_step) => {
    state.previous_step = previous_step;
};

const NEXT_STEP_UPDATED = (state, next_step) => {
    state.next_step = next_step;
};

const CURRENT_STEP_INDEX_UPDATED = (state, current_index) => {
    state.current_index = current_index;
};

const COMPLETED_STEPS_UPDATED = (state, payload) => {
    state.completed_steps = payload;
};

const INCOMPLETE_STEPS_UPDATED = (state, payload) => {
    state.incomplete_steps = payload;
};

const STEPS_PROGRESS_UPDATED = (state, progress) => {
    state.progress = progress;
};

const COMPLETED_REQUIRED_ENABLED_STEPS_UPDATED = (state, payload) => {
    state.completed_required_enabled_steps = payload;
};

const INCOMPLETE_REQUIRED_ENABLED_STEPS_UPDATED = (state, payload) => {
    state.incomplete_required_enabled_steps = payload;
};

const RESET_STEPS_PROGRESS = state => {
    state.progress = 0;
    state.completed_steps = null;
    for (let index = 0; index < state.steps.length; index++) {
        state.steps[index].completed = false;
    }
};

export default {
    STEPS_UPDATED,
    ENABLED_STEPS_UPDATED,
    DISABLED_STEPS_UPDATED,

    CURRENT_STEP_UPDATED,
    PREVIOUS_STEP_UPDATED,
    NEXT_STEP_UPDATED,
    CURRENT_STEP_INDEX_UPDATED,
    COMPLETED_STEPS_UPDATED,
    INCOMPLETE_STEPS_UPDATED,
    STEPS_PROGRESS_UPDATED,
    RESTORE_STEPS_STATE,
    COMPLETED_REQUIRED_ENABLED_STEPS_UPDATED,
    INCOMPLETE_REQUIRED_ENABLED_STEPS_UPDATED,
    RESET_STEPS_PROGRESS
};
