import api from "@/api";
import router from "@/router";

const updateSteps = (context, payload) => {
    context.commit("STEPS_UPDATED", payload);
};

const updateCurrentStep = (context, payload) => {
    if (payload.steps && payload.name) {
        const enabledSteps = payload.steps.filter(obj => {
            return obj.enabled === true;
        });

        if (enabledSteps) {
            const index = enabledSteps.findIndex(
                value => value.name === payload.name
            );

            context.commit("CURRENT_STEP_UPDATED", enabledSteps[index]);
        }
    }
};

const updateNextStep = (context, payload) => {
    if (payload.steps && payload.name) {
        const enabledSteps = payload.steps.filter(obj => {
            return obj.enabled === true;
        });

        const index = enabledSteps.findIndex(
            value => value.name === payload.name
        );
        if (index && enabledSteps[index] && enabledSteps[index + 1]) {
            context.commit("NEXT_STEP_UPDATED", enabledSteps[index + 1]);
        }
    }
};

const updatePreviousStep = (context, payload) => {
    if (payload.steps && payload.name) {
        const enabledSteps = payload.steps.filter(obj => {
            return obj.enabled === true;
        });
        const index = enabledSteps.findIndex(
            value => value.name === payload.name
        );
        if (index && enabledSteps[index] && enabledSteps[index - 1]) {
            context.commit("PREVIOUS_STEP_UPDATED", enabledSteps[index - 1]);
        }
    }
};

const updateRelativeSteps = (context, payload) => {
    if (payload.steps && payload.name) {
        const enabledSteps = payload.steps.filter(obj => {
            return obj.enabled === true;
        });

        if (enabledSteps) {
            const enabledIndex = enabledSteps.findIndex(
                value => value.name === payload.name
            );

            let previousEnabledStep;
            let nextEnabledStep;

            if (enabledSteps[enabledIndex]) {
                context.commit("CURRENT_STEP_UPDATED", {
                    index: enabledIndex,
                    name: payload.name,
                    substeps: enabledSteps[enabledIndex].substeps || null,
                    required: enabledSteps[enabledIndex].required,
                    enabled: enabledSteps[enabledIndex].enabled,
                    completed: enabledSteps[enabledIndex].completed
                });

                if (enabledSteps[enabledIndex - 1]) {
                    previousEnabledStep = enabledSteps[enabledIndex - 1];

                    context.commit("PREVIOUS_STEP_UPDATED", {
                        index: enabledIndex - 1,
                        name: previousEnabledStep.name || null,
                        substeps: previousEnabledStep.substeps || null,
                        required: previousEnabledStep.required || null,
                        enabled: previousEnabledStep.enabled || null,
                        completed: previousEnabledStep.completed || null
                    });
                }

                if (enabledSteps[enabledIndex + 1]) {
                    nextEnabledStep = enabledSteps[enabledIndex + 1];

                    context.commit("NEXT_STEP_UPDATED", {
                        index: enabledIndex + 1,
                        name: nextEnabledStep.name || null,
                        substeps: nextEnabledStep.substeps || null,
                        required: nextEnabledStep.required || null,
                        enabled: nextEnabledStep.enabled || null,
                        completed: nextEnabledStep.completed || null
                    });
                }
            }
        }
    }
};

const updateEnabledSteps = (context, payload) => {
    const enabledSteps = payload.filter(obj => {
        return obj.enabled === true;
    });

    context.commit("ENABLED_STEPS_UPDATED", enabledSteps);
};

const updateDisabledSteps = (context, payload) => {
    const disabledSteps = payload.filter(obj => {
        return obj.enabled === false;
    });

    context.commit("DISABLED_STEPS_UPDATED", disabledSteps);
};

const goToNextStep = (context, payload) => {
    if (payload.next_step && payload.next_step.name) {
        router.push({
            name: payload.next_step.name
        });
    }
};

const goToPreviousStep = (context, payload) => {
    if (payload.previous_step && payload.previous_step.substeps) {
        let enabledSubsteps = payload.previous_step.substeps.filter(obj => {
            return obj.enabled === true;
        });

        if (enabledSubsteps && enabledSubsteps.length > 0) {
            let lastSubstep = enabledSubsteps[enabledSubsteps.length - 1];
            router.push({
                name: lastSubstep.name
            });
        } else {
            router.push({
                name: payload.previous_step.name
            });
        }
    } else if (payload.previous_step && payload.previous_step.name) {
        router.push({
            name: payload.previous_step.name
        });
    }
};

const goToStep = (context, payload) => {
    if (payload) {
        if (payload.name) {
            router.push({
                name: payload.name
            });
        } else {
            router.push({
                name: payload
            });
        }
    }
};

const disableSteps = (context, payload) => {
    if (payload.names && payload.steps) {
        let passedSteps = [];
        let steps = payload.steps;

        for (let name of payload.names) {
            // Find the step object
            let step = steps.filter(obj => {
                return obj.name === name;
            });

            if (step && step.length > 0) {
                // Disable the step object
                step[0].enabled = false;
                passedSteps.push(step[0]);
            }
        }

        const disabledSteps = passedSteps.filter(obj => {
            return obj.enabled === false;
        });

        const enabledSteps = steps.filter(obj => {
            return obj.enabled === true;
        });

        context.commit("STEPS_UPDATED", payload.steps);
        context.commit("ENABLED_STEPS_UPDATED", enabledSteps);
        context.commit("DISABLED_STEPS_UPDATED", disabledSteps);
    }
};

const enableSteps = (context, payload) => {
    if (payload.names && payload.steps) {
        let passedSteps = [];
        let steps = payload.steps;

        for (let name of payload.names) {
            // Find the step object
            let step = steps.filter(obj => {
                return obj.name === name;
            });

            if (step && step.length > 0) {
                // Enable the step object
                step[0].enabled = true;
                passedSteps.push(step[0]);
            }
        }

        const disabledSteps = passedSteps.filter(obj => {
            return obj.enabled === false;
        });

        const enabledSteps = steps.filter(obj => {
            return obj.enabled === true;
        });

        context.commit("STEPS_UPDATED", payload.steps);
        context.commit("ENABLED_STEPS_UPDATED", enabledSteps);
        context.commit("DISABLED_STEPS_UPDATED", disabledSteps);
    }
};

const completeStep = (context, payload) => {
    if (payload.name && payload.steps) {
        let steps = payload.steps;

        const step = steps.filter(obj => {
            return obj.name === payload.name;
        });

        if (step && step[0]) {
            step[0].completed = true;
        }

        const completedSteps = steps.filter(obj => {
            return obj.completed === true;
        });

        context.commit("STEPS_UPDATED", steps);
        context.commit("COMPLETED_STEPS_UPDATED", completedSteps);
    }
};

const updateCompletedSteps = (context, payload) => {
    const completedSteps = payload.filter(obj => {
        return obj.completed === true;
    });

    context.commit("COMPLETED_STEPS_UPDATED", completedSteps);
};

const updateIncompleteSteps = (context, payload) => {
    const incompleteSteps = payload.filter(obj => {
        return obj.completed === false;
    });

    context.commit("INCOMPLETE_STEPS_UPDATED", incompleteSteps);
};

//   The steps that are counted toward the percentage
const updateCompletedRequiredEnabledSteps = (context, payload) => {
    const completedRequiredEnabledSteps = payload.filter(obj => {
        return (
            obj.completed === true &&
            obj.enabled === true &&
            obj.required === true
        );
    });

    context.commit(
        "COMPLETED_REQUIRED_ENABLED_STEPS_UPDATED",
        completedRequiredEnabledSteps
    );
};

// The steps that are counted toward the percentage
const updateIncompleteRequiredEnabledSteps = (context, payload) => {
    const incompleteRequiredEnabledSteps = payload.filter(obj => {
        return (
            obj.completed === false &&
            obj.enabled === true &&
            obj.required === true
        );
    });

    context.commit(
        "INCOMPLETE_REQUIRED_ENABLED_STEPS_UPDATED",
        incompleteRequiredEnabledSteps
    );
};

const updateStepsProgress = (context, payload) => {
    let percentage = 0;
    let incomplete = payload.incomplete_required_enabled_steps;
    let completed = payload.completed_required_enabled_steps;

    if (incomplete && incomplete.length === 0) {
        percentage = 100;
    } else if (
        incomplete &&
        incomplete.length > 0 &&
        completed &&
        completed.length > 0
    ) {
        let total = incomplete.length + completed.length;
        percentage = Math.ceil((completed.length / total) * 100);

        if (percentage > 100) {
            percentage = 100;
        }
    }

    context.commit("STEPS_PROGRESS_UPDATED", percentage);
    document.documentElement.style.setProperty("--progress", percentage + "%");
};

const restoreStepsState = (context, payload) => {
    context.commit("RESTORE_STEPS_STATE", payload);
};

const resetStepsProgress = context => {
    context.commit("RESET_STEPS_PROGRESS");
};

export default {
    updateCurrentStep,
    updateSteps,
    updateEnabledSteps,
    updateDisabledSteps,
    updatePreviousStep,
    updateNextStep,
    goToStep,
    goToNextStep,
    goToPreviousStep,
    updateRelativeSteps,
    disableSteps,
    enableSteps,
    completeStep,
    updateStepsProgress,
    restoreStepsState,
    updateIncompleteSteps,
    updateCompletedSteps,
    updateCompletedRequiredEnabledSteps,
    updateIncompleteRequiredEnabledSteps,
    resetStepsProgress
};
