// All parent steps
const steps = state => state.steps

// All enabled parent steps
const enabled_steps = state => state.enabled_steps

// All disabled parent steps
const disabled_steps = state => state.disabled_steps

// Route name, index, [substeps]
const current_step = state => state.current_step 

// Route name, index, [substeps]
const previous_step = state => state.previous_step

// Route name, index, [substeps]
const next_step = state => state.next_step


const completed_steps = state => state.completed_steps

const incomplete_steps = state => state.incomplete_steps

const progress = state => state.progress


export default {
    steps,
    enabled_steps,
    disabled_steps,
    current_step,
    previous_step,
    next_step,
    completed_steps,
    incomplete_steps,
    progress
};
