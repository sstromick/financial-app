<template>
    <section class="section py-2 py-4--xxlarge">
        <div class="grid-container mt-2">
            <div class="grid-container grid-container--smaller">
                <div class="grid-x grid-margin-x">
                    <div class="cell small-12">
                        <div class="text-center flex-column flex-center">
                            <img
                                :src="current_expense_category.image"
                                class="mb-2"
                            />
                            <h1 class="text-secondary text-28 weight-500">
                                {{ current_expense_category.expense_category }}
                                Expenses
                            </h1>

                            <div class="text-center">
                                <h2 class="text-54 weight-100 text-darkGreen">
                                    Tell us a little more about your
                                    {{
                                        current_expense_category.expense_category
                                            | lowercase
                                    }}&nbsp;expenses.
                                </h2>

                                <p class="font-book text-25 mb-4">
                                    Common expenses in this category are listed
                                    in the drop-down menu below. Select an
                                    expense and enter in its amount, then click
                                    “add line” to enter in your next expense.
                                    This will let us understand exactly where
                                    your income is being spent each month.
                                </p>
                            </div>
                        </div>

                        <form
                            method="POST"
                            @submit.prevent="onSubmit($event)"
                            class="form form--expense grid-x grid-margin-y w-100"
                        >
                            <input
                                type="hidden"
                                name="submission_id"
                                v-model="submission.id"
                            />

                            <!-- Dynamic Rows -->
                            <div
                                class="grid-x grid-margin-x grid-margin-y mt-6 cell small-12"
                                v-for="(e, i) in filtered_expenses"
                                :key="e.id"
                            >
                                <div
                                    class="form__fieldWrapper display-flex flex-wrap cell small-6 relative"
                                >
                                    <img
                                        class="select-arrow"
                                        svg-inline
                                        src="@img/svg/arrow-down.svg"
                                    />
                                    <select
                                        name="expense_type"
                                        v-model="
                                            filtered_expenses[i].expense_type
                                                .expense_type
                                        "
                                    >
                                        <option value="null" disabled hidden
                                            >Select Expense</option
                                        >
                                        <option
                                            v-for="expense_type in filtered_expense_types"
                                            :key="expense_type.id"
                                            >{{
                                                expense_type.expense_type
                                            }}</option
                                        >
                                    </select>
                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="expense_type"
                                        >Expense Type</label
                                    >
                                </div>

                                <div
                                    class="form__fieldWrapper display-flex flex-wrap cell small-3"
                                >
                                    <input
                                        type="number"
                                        name="expense_value"
                                        placeholder="0"
                                        step="0.00"
                                        min="0"
                                        v-model="
                                            filtered_expenses[i].expense_value
                                        "
                                    />
                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="expense_value"
                                        >Expense Value</label
                                    >
                                </div>

                                <div
                                    :id="'delete-row-' + e.id"
                                    class="form__fieldWrapper display-flex flex-wrap cell small-3"
                                >
                                    <button
                                        type="button"
                                        class=""
                                        @click="deleteRowFromDB($event, e.id)"
                                    >
                                        <img
                                            svg-inline
                                            src="@img/svg/close.svg"
                                            class="fill-primary"
                                        />
                                    </button>
                                </div>
                            </div>

                            <!-- Static input row -->
                            <div
                                class="grid-x grid-margin-x grid-margin-y mt-6 cell small-12 flex-md-nowrap"
                                v-if="expense"
                            >
                                <div
                                    class="form__fieldWrapper display-flex flex-wrap cell small-6 relative"
                                >
                                    <img
                                        class="select-arrow"
                                        svg-inline
                                        src="@img/svg/arrow-down.svg"
                                    />
                                    <select
                                        name="expense_type"
                                        v-model="expense.expense_type"
                                    >
                                        <option value="null" disabled hidden
                                            >Select Expense</option
                                        >
                                        <option
                                            v-for="expense_type in filtered_expense_types"
                                            :key="expense_type.id"
                                            >{{
                                                expense_type.expense_type
                                            }}</option
                                        >
                                    </select>
                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="expense_type"
                                        >Expense Type</label
                                    >
                                </div>

                                <div
                                    class="form__fieldWrapper display-flex flex-wrap cell small-3"
                                >
                                    <input
                                        type="number"
                                        name="expense_value"
                                        step="0.00"
                                        min="0"
                                        placeholder="0"
                                        v-model="expense.expense_value"
                                    />
                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="expense_value"
                                        >Expense Value</label
                                    >
                                </div>

                                <div
                                    class="form__fieldWrapper display-flex flex-wrap cell shrink"
                                >
                                    <button
                                        value="submit"
                                        name="submit"
                                        type="submit"
                                        class="button button--hollow button--stepNav"
                                    >
                                        Add Line
                                    </button>
                                </div>

                                <div
                                    class="form__fieldWrapper display-flex flex-wrap cell shrink"
                                >
                                    <button
                                        @click.stop="resetLine($event)"
                                        value="reset"
                                        name="reset"
                                        class="button button--hollow button--stepNav"
                                    >
                                        Reset Line
                                    </button>
                                </div>
                            </div>

                            <div class="cell small-12 text-center">
                                <p class="font-book text-25 mt-4 mb-0">
                                    If you selected more than one type of
                                    expense on the previous screen, you'll be
                                    prompted to enter in your next category of
                                    expenses on the next screen when you hit
                                    “Continue.” Otherwise, we'll move on to the
                                    next step.
                                </p>
                            </div>

                            <div
                                class="form__fieldWrapper display-flex flex-wrap cell small-12"
                            >
                                <div class="button-group flex-center">
                                    <button
                                        type="button"
                                        class="button button--hollow button--stepNav"
                                        @click="nextCategory"
                                    >
                                        Skip This Step
                                    </button>
                                    <button
                                        type="button"
                                        class="button button--stepNav"
                                        @click="nextCategory"
                                    >
                                        Continue
                                    </button>
                                </div>

                                <div class="w-100 flex-center mt-4">
                                    <button
                                        type="button"
                                        class="weight-600 underline uppercase text-primary"
                                        @click="previousCategory"
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
                            <template v-for="line in message.split('\n')">
                                <p>{{ line }}</p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import api from "@/api";
import { mapGetters } from "vuex";
export default {
    name: "ExpensesCreate",
    data: function() {
        return {
            message: null
        };
    },
    computed: {},
    methods: {
        resetLine($event) {
            $event.preventDefault();
            $event.stopPropagation();
            this.expense.expense_value = null;
            this.expense.expense_type = null;
        },

        onSubmit($event) {
            this.addItem();
        },

        async nextCategory() {
            await this.addItem();

            if (!this.expense.expense_type) {
                if (this.next_expense_category) {
                    this.expense.expense_value = null;
                    this.expense.expense_type = null;
                    // The expense types within the specific category
                    let filtered_expense_types = this.expense_types.filter(
                        obj => {
                            return (
                                obj.category_id ===
                                this.next_expense_category.id
                            );
                        }
                    );

                    // Update the category-specific expense types
                    this.$store.dispatch(
                        "expenses/updateFilteredExpenseTypes",
                        filtered_expense_types
                    );

                    // Filter expenses by matching against the filtered expense types
                    this.$store.dispatch("expenses/updateFilteredExpenses", {
                        filtered_expense_types: this.filtered_expense_types
                    });

                    // Update current/next/previous expense categories
                    this.$store.dispatch(
                        "expenses/updateRelativeExpenseCategories",
                        {
                            current_expense_category: this
                                .next_expense_category,
                            enabled_expense_categories: this
                                .enabled_expense_categories
                        }
                    );
                } else {
                    this.$store.dispatch("steps/goToNextStep", {
                        next_step: this.next_step
                    });
                }
            }

            window.scrollTo(0, 0);
        },
        async addItem() {
            if (!this.expense.expense_type) return;

            this.saving = true;
            this.message = false;

            if (
                this.submission.id &&
                this.expense.expense_type &&
                this.expense.expense_type &&
                this.current_expense_category.expense_category
            ) {
                await api.expenses
                    .create({
                        submission_id: this.submission.id,
                        expense_category: this.current_expense_category
                            .expense_category,
                        expense_category_id: this.current_expense_category.id,
                        expense_type: this.expense.expense_type,
                        expense_value: this.expense.expense_value
                    })
                    .then(response => {
                        this.expense.expense_value = null;
                        this.expense.expense_type = null;
                        this.$store.dispatch("expenses/getExpenses");

                        this.$store.dispatch(
                            "expenses/updateFilteredExpenses",
                            {
                                filtered_expense_types: this
                                    .filtered_expense_types
                            }
                        );

                        // At least one expense was added
                        this.$store.dispatch("steps/completeStep", {
                            name: this.$route.name,
                            steps: this.steps
                        });
                    })
                    .catch(error => {
                        console.log("create error");
                        console.log(error);
                        if (typeof error.response.data === "object") {
                            this.message = "";
                            let errMsgs = _.toArray(error.response.data.errors);
                            console.log(errMsgs);
                            errMsgs.forEach(element => {
                                this.message += element + "\n";
                            });
                        }
                    });
            }
        },
        previousCategory() {
            if (this.previous_expense_category) {
                this.expense.expense_value = null;
                this.expense.expense_type = null;
                // The expense types within the specific category
                let filtered_expense_types = this.expense_types.filter(obj => {
                    return (
                        obj.category_id === this.previous_expense_category.id
                    );
                });

                // Update the category-specific expense types
                this.$store.dispatch(
                    "expenses/updateFilteredExpenseTypes",
                    filtered_expense_types
                );

                // Filter expenses by matching against the filtered expense types
                this.$store.dispatch("expenses/updateFilteredExpenses", {
                    filtered_expense_types: this.filtered_expense_types
                });

                // Update current/next/previous expense categories
                this.$store.dispatch(
                    "expenses/updateRelativeExpenseCategories",
                    {
                        current_expense_category: this
                            .previous_expense_category,
                        enabled_expense_categories: this
                            .enabled_expense_categories
                    }
                );
            } else {
                this.$store.dispatch("steps/goToPreviousStep", {
                    previous_step: this.previous_step
                });
            }
        },
        async deleteRowFromDB($event, expenseID) {
            let expense = this.expenses.filter(obj => {
                return expenseID === obj.id;
            });

            if (expense && expense[0]) {
                // Delete expense
                await api.expenses
                    .delete(expense[0].id)
                    .then(response => {
                        this.expense.expense_value = null;
                        this.expense.expense_type = null;
                        // Refresh the list of expenses
                        this.$store.dispatch("expenses/getExpenses");

                        this.$store.dispatch(
                            "expenses/updateFilteredExpenses",
                            {
                                filtered_expense_types: this
                                    .filtered_expense_types
                            }
                        );
                    })
                    .catch(error => {
                        console.log(error);
                        if (typeof error.response.data === "object") {
                            this.message = "";
                            let errMsgs = _.toArray(error.response.data.errors);
                            errMsgs.forEach(element => {
                                this.message += element + "\n";
                            });
                        }
                    });
            }
        }
    },
    mounted() {
        this.$store.dispatch("expenses/getExpenses");

        if (this.expenses && this.expenses.length > 0) {
            // At least one expense was added
            this.$store.dispatch("steps/completeStep", {
                name: this.$route.name,
                steps: this.steps
            });
        }

        this.$store.dispatch("expenses/getAllExpenseTypes");

        axios.get("/api/expense-types").then(response => {
            let expense_types = response.data;

            // Get saved enabled categories
            let enabledCategories = JSON.parse(
                localStorage.getItem("enabled-expense-types")
            );
            this.$store.dispatch(
                "expenses/updateEnabledExpenseCategories",
                enabledCategories
            );

            // If there isn't a current category enabled (such as page reload on expense category)
            if (
                (enabledCategories &&
                    enabledCategories.length > 0 &&
                    !this.current_expense_category) ||
                !this.current_expense_category.expense_category
            ) {
                this.$store.dispatch(
                    "expenses/updateRelativeExpenseCategories",
                    {
                        current_expense_category: enabledCategories[0],
                        enabled_expense_categories: enabledCategories
                    }
                );
                // Array of expense_types objects
                let filtered_expense_types = expense_types.filter(obj => {
                    return obj.category_id === enabledCategories[0].id;
                });

                this.$store.dispatch(
                    "expenses/updateFilteredExpenseTypes",
                    filtered_expense_types
                );

                this.$store.dispatch("expenses/updateFilteredExpenses", {
                    filtered_expense_types: this.filtered_expense_types
                });
            }
        });
    }
};
</script>
