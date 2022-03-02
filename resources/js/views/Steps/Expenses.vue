<template>
    <section class="section pb-4">
        <div class="grid-container mt-2">
            <div class="grid-container grid-container--smaller text-center">
                <h1 class="text-54 weight-100 text-darkGreen">
                    Almost done! Next up: Expenses.
                </h1>

                <p class="font-book text-25">
                    After income and debt, monthly expenses are the third pillar
                    in our understanding of your finances. Below, select all the
                    expenses you incur each month (you can select more than
                    one!)
                </p>
            </div>

            <form
                id="expense-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form form--blocks mt-4 grid-x grid-margin-x grid-margin-y align-center"
            >
                <div class="categoryBlockWrapper align-center">
                    <category-block
                        :value="category.expense_category"
                        :image="category.image"
                        :description="category.description"
                        classes="categoryBlock--expenses relative cell small-12 medium-6 medium-large-4"
                        v-for="category in expense_categories"
                        :key="category.id"
                        field-name="category"
                        v-on:category-clicked="categoryChanged"
                        type="checkbox"
                        :label="category.expense_category"
                    ></category-block>
                </div>

                <div
                    class="form__fieldWrapper display-flex flex-wrap cell shrink"
                >
                    <div class="button-group text-center">
                        <button
                            type="button"
                            class="button button--hollow button--stepNav"
                            @click="skipStep"
                        >
                            Skip This Step
                        </button>
                        <button
                            value="submit"
                            name="submit"
                            type="submit"
                            class="button button--stepNav"
                        >
                            Continue
                        </button>
                    </div>
                    <div class="w-100 text-center">
                        <button
                            type="button"
                            class="weight-600 underline uppercase text-17 text-primary text-center"
                            @click="
                                $store.dispatch('steps/goToPreviousStep', {
                                    previous_step: previous_step
                                })
                            "
                        >
                            Back
                        </button>
                    </div>
                </div>
            </form>
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
import { mapGetters } from "vuex";
import { watchAwaitSelector } from "@/scripts/functions";
export default {
    name: "Expenses",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false
        };
    },
    computed: {},
    methods: {
        skipStep() {
            // Disable this expense create step
            this.$store.dispatch("steps/disableSteps", {
                steps: this.steps,
                name: this.$route.name,
                names: ["ExpensesCreate"]
            });

            // Update steps to adjust for new enabled/disabled steps
            this.$store.dispatch("steps/updateSteps", this.steps);
            this.$store.dispatch("steps/updateRelativeSteps", {
                steps: this.steps,
                name: this.$route.name
            });
            this.$store.dispatch("steps/goToNextStep", {
                next_step: this.next_step
            });
        },
        categoryChanged(value) {
            this.category = value;
        },
        onSubmit($event) {
            this.saving = true;
            this.message = false;

            // The checkboxes
            let types = $event.target;

            // Find the expenses object
            let expenses = this.enabled_steps.filter(obj => {
                return obj.name === this.$route.name;
            });

            let enabledCategories = [];
            if (expenses && expenses.length > 0) {
                expenses = expenses[0];

                for (let type of types) {
                    // Skip the buttons
                    if (type.nodeName === "INPUT" && type.checked === true) {
                        // Get category that matches checked input value
                        let categories = this.expense_categories.filter(obj => {
                            return obj.expense_category === type.value;
                        });

                        if (categories && categories.length > 0) {
                            // Push enabled category to array
                            enabledCategories.push(categories[0]);
                        }
                    }
                }

                if (enabledCategories.length > 0) {
                    this.submission.selected_expenses = JSON.stringify(
                        enabledCategories
                    );
                    localStorage.setItem(
                        "enabled-expense-types",
                        JSON.stringify(enabledCategories)
                    );

                    // At least one category is selected
                    this.$store.dispatch("steps/completeStep", {
                        name: this.$route.name,
                        steps: this.steps
                    });
                    this.$store.dispatch("steps/enableSteps", {
                        steps: this.steps,
                        name: this.$route.name,
                        names: ["ExpensesCreate"]
                    });

                    // Update steps to adjust for new enabled/disabled steps
                    this.$store.dispatch("steps/updateSteps", this.steps);

                    this.$store.dispatch(
                        "expenses/updateEnabledExpenseCategories",
                        enabledCategories
                    );

                    this.$store.dispatch(
                        "expenses/updateRelativeExpenseCategories",
                        {
                            current_expense_category: enabledCategories[0],
                            enabled_expense_categories: enabledCategories
                        }
                    );

                    // Array of expense_types objects
                    let filtered_expense_types = this.expense_types.filter(
                        obj => {
                            return obj.category_id === enabledCategories[0].id;
                        }
                    );

                    this.$store.dispatch(
                        "expenses/updateFilteredExpenseTypes",
                        filtered_expense_types
                    );

                    this.$store.dispatch("expenses/updateFilteredExpenses", {
                        filtered_expense_types: this.filtered_expense_types
                    });

                    this.$router.push({
                        name: "ExpensesCreate",
                        params: {
                            category: enabledCategories[0],
                            types: this.expense_types
                        }
                    });
                } else {
                    this.message = "Please select at least one expense.";
                }
            }
        }
    },
    mounted() {
        this.$store.dispatch("expenses/getExpenses");

        let enabledCategories = JSON.parse(
            localStorage.getItem("enabled-expense-types")
        );

        if (enabledCategories && enabledCategories.length > 0) {
            // At least one category is selected
            this.$store.dispatch("steps/completeStep", {
                name: this.$route.name,
                steps: this.steps
            });

            for (let category of enabledCategories) {
                let value = category.expense_category;

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
