<template>
    <section class="section pb-4">
        <div class="grid-container grid-container--small mt-2">
            <div class="text-center flex-column flex-center">
                <img :src="income_type.image" class="mb-2" />
                <h1 class="text-secondary text-28 weight-500">
                    Monthly Employment Income
                </h1>

                <div class="mt-2">
                    <div
                        class="grid-container grid-container--smaller text-center"
                    >
                        <h2 class="text-54 weight-100 text-darkGreen">
                            Great! Now let's delve a little deeper.
                        </h2>

                        <p class="font-book text-25 mb-4">
                            Below, enter in the gross and net amounts of your
                            employment income. If you don’t know exact numbers,
                            that’s okay! Enter your best estimate.
                        </p>

                        <p
                            class="text-25 weight-500 display-inline-flex align-middle"
                        >
                            Monthly Employment Income
                            <span
                                id="employment-income-tooltip-1"
                                class="lh-1 ml-1"
                                ><img
                                    svg-inline
                                    src="@img/svg/help.svg"
                                    class="fill-gray"
                            /></span>
                        </p>
                    </div>
                </div>
            </div>

            <ValidationObserver
                tag="form"
                ref="observer"
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form mt-4 grid-x grid-margin-x"
            >
                <ValidationProvider
                    tag="div"
                    rules="required|numeric"
                    class="form__fieldWrapper display-flex flex-wrap cell small-6"
                    v-slot="{ classes, errors }"
                >
                    <div
                        class="display-flex flex-wrap control w-100"
                        :class="classes"
                    >
                        <input
                            name="gross_employment_income"
                            v-model="submission.gross_employment_income"
                            step="0.01"
                            min="1"
                            placeholder="XXXXXX"
                            type="number"
                            required
                        />

                        <label
                            class="form__label display-block text-20 weight-500"
                            for="gross_employment_income"
                            >Gross</label
                        >

                        <p class="errors-wrapper">{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>

                <ValidationProvider
                    tag="div"
                    rules="required|numeric"
                    class="form__fieldWrapper display-flex flex-wrap cell small-6"
                    v-slot="{ classes, errors }"
                >
                    <div
                        class="display-flex flex-wrap control w-100"
                        :class="classes"
                    >
                        <input
                            name="net_employment_income"
                            v-model="submission.net_employment_income"
                            step="0.01"
                            min="1"
                            placeholder="XXXXXX"
                            type="number"
                            required
                        />

                        <label
                            class="form__label display-block  text-20 weight-500"
                            for="net_employment_income"
                            >Net</label
                        >

                        <p class="errors-wrapper">{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>

                <div class="display-flex text-center cell small-12">
                    <p class="font-book text-25 mt-4 mb-0">
                        If you selected more than one type of income, you'll be
                        prompted to enter the next form of income when you hit
                        “Continue.” Otherwise, we'll move on to Debts.
                    </p>
                </div>

                <substeps-nav></substeps-nav>
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
import tippy from "tippy.js";
import { watchAwaitSelector } from "@/scripts/functions";

export default {
    name: "EmploymentIncome",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false,
            parentName: "SubmissionIncomes",
            income_type: {
                image: ""
            }
        };
    },
    computed: {},
    methods: {
        async onSubmit($event) {
            const isValid = await this.$refs.observer.validate();

            if (
                this.submission.gross_employment_income &&
                this.submission.net_employment_income &&
                isValid
            ) {
                this.$store.dispatch(
                    "submissions/updateSubmission",
                    this.submission
                );

                this.$store.dispatch("steps/completeStep", {
                    name: this.$route.name,
                    steps: this.steps
                });

                this.$store.dispatch("steps/goToNextStep", {
                    next_step: this.next_step
                });
            } else {
                this.message =
                    "You must enter the estimated gross and net employment income you receive.";
            }
        }
    },
    mounted() {
        watchAwaitSelector(function() {
            const tooltip = document.getElementById(
                "employment-income-tooltip-1"
            );
            const tooltipInstance = tippy(tooltip, {
                allowHTML: true,
                content: `<div class="tooltip relative">

                Gross income is the total income you earn before taxes/deductions. Net income is the amount you receive after deductions (the amount that ends up in your bank account).
                <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
            </div>`,
                placement: "right",
                offset: [-5, 34],

                delay: [null, 150],
                arrow: true
            });
        }, "#employment-income-tooltip-1");

        let income_type = this.income_types.filter(obj => {
            return obj.income_type === "Employment Income";
        });

        if (income_type && income_type[0]) {
            this.income_type = income_type[0];
        }
    }
};
</script>
