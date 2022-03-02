<template>
    <section class="section pb-4">
        <div class="grid-container mt-2">
            <div
                class="grid-container grid-container--smaller text-center mb-8"
            >
                <h1 class="text-54 weight-100 text-darkGreen">
                    What type of income do you receive?
                </h1>

                <p class="font-book text-25 mb-4">
                    Understanding your income is an important part of creating a
                    budget and plan that works best for you. Select the sources
                    of income you receive below. (You can select more than one!)
                </p>
            </div>

            <ValidationObserver
                tag="form"
                ref="observer"
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form form--blocks mt-4 grid-x grid-margin-x align-center"
            >
                <ValidationProvider
                    name="type"
                    class="w-100"
                    v-slot="{ classes, errors }"
                >
                    <div class="control w-100" :class="classes">
                        <div class="categoryBlockWrapper align-center">
                            <category-block
                                :value="
                                    'Submission' +
                                        it.income_type.replace(/-|\s/g, '')
                                "
                                :image="it.image"
                                :description="it.description"
                                classes="categoryBlock--incomes relative cell small-12 medium-6 medium-large-4"
                                v-for="it in income_types"
                                :key="it.id"
                                field-name="type"
                                v-on:category-clicked="categoryChanged"
                                :label="it.income_type"
                                type="checkbox"
                            ></category-block>
                        </div>
                        <p class="errors-wrapper">{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>

                <div class="form__fieldWrapper cell shrink">
                    <div class="grid-x grid-margin-x mt-5 mb-4">
                        <div class="cell shrink">
                            <button
                                type="button"
                                class="button button--hollow button--stepNav"
                                @click="
                                    $store.dispatch('steps/goToNextStep', {
                                        next_step: next_step
                                    })
                                "
                            >
                                Skip This Step
                            </button>
                        </div>

                        <div class="cell shrink">
                            <button
                                value="submit"
                                name="submit"
                                type="submit"
                                class="button button--stepNav"
                                @submit.prevent="onSubmit($event)"
                            >
                                Continue
                            </button>
                        </div>
                    </div>

                    <div class="w-100 text-center">
                        <back-button></back-button>
                    </div>
                </div>
            </ValidationObserver>

            <div
                v-if="message"
                class="alert text-error text-center my-3 weight-500 text-20"
            >
                {{ message }}
            </div>
        </div>
    </section>
</template>

<script>
import { mapMutations, mapGetters } from "vuex";
import { watchAwaitSelector } from "@/scripts/functions";
export default {
    name: "Incomes",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false
        };
    },
    computed: {},
    methods: {
        categoryChanged(value) {
            this.category = value;
        },
        onSubmit($event) {
            this.saving = true;
            this.message = false;

            // // The checkboxes
            let types = $event.target;

            // Find the incomes object
            let incomes = this.enabled_steps.filter(obj => {
                return obj.name === this.$route.name;
            });

            let incomeSteps = [];

            if (incomes && incomes.length > 0) {
                incomes = incomes[0];

                let completed = false;

                for (let type of types) {
                    // Skip the buttons
                    if (type.nodeName === "INPUT") {
                        // Find the matching "substep" object
                        let typeObj = this.steps.filter(obj => {
                            return obj.name === type.value;
                        });

                        // If there was a match
                        if (typeObj && typeObj.length > 0) {
                            typeObj = typeObj[0];

                            if (type.checked === true) {
                                // Enable it so it can be navigated to using next/back
                                typeObj.enabled = true;
                                incomeSteps.push(typeObj);

                                // Only send out dispatches once
                                if (completed === false) {
                                    this.$store.dispatch("steps/completeStep", {
                                        name: this.$route.name,
                                        steps: this.steps
                                    });

                                    completed = true;
                                }
                            } else {
                                // Disable it so it is skippd
                                typeObj.enabled = false;
                            }
                        }
                    }
                }

                this.$store.dispatch("steps/updateEnabledSteps", this.steps);
                this.$store.dispatch("steps/updateDisabledSteps", this.steps);
                this.$store.dispatch("steps/updateRelativeSteps", {
                    name: this.$route.name,
                    steps: this.steps
                });

                if (incomeSteps.length > 0) {
                    this.submission.selected_incomes = JSON.stringify(
                        incomeSteps
                    );
                    localStorage.setItem(
                        "income-steps",
                        JSON.stringify(incomeSteps)
                    );

                    // All required fields are completed
                    this.$store.dispatch("steps/completeStep", {
                        name: this.$route.name,
                        steps: this.steps
                    });

                    this.$store.dispatch("steps/goToNextStep", {
                        next_step: this.next_step
                    });
                }
            }
        }
    },
    mounted() {
        // Possible income types fetched from income_types table
        this.$store.dispatch("incomes/getIncomeTypes");

        let enabledTypes = JSON.parse(localStorage.getItem("income-steps"));
        if (enabledTypes && enabledTypes.length > 0) {
            // At least one type is selected
            this.$store.dispatch("steps/completeStep", {
                name: this.$route.name,
                steps: this.steps
            });

            for (let type of enabledTypes) {
                let value = type.name;

                watchAwaitSelector(function(elements) {
                    for (let element of elements) {
                        let input = document.querySelector(
                            `.categoryBlock input[value="${value}"]`
                        );

                        if (input) {
                            input.checked = true;
                        }
                    }
                }, `.categoryBlock input[value="${value}"]`);
            }
        }
    }
};
</script>
