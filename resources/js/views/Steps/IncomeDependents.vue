<template>
    <section class="section pb-4">
        <div class="grid-container mt-2">
            <div class="grid-container grid-container--smaller text-center">
                <h1 class="text-54 weight-100 text-darkGreen">
                    Let's talk about your income.
                </h1>

                <p class="font-book text-25 mb-4">
                    In order for us to create an accurate and effective budget
                    for you, we need to know a little bit more about your
                    finances, starting with your income. First things first:
                </p>

                <p class="text-25 weight-500">
                    How many people does your income support?
                </p>
            </div>

            <form
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form mt-4 grid-x grid-margin-x align-center"
            >
                <div
                    class="form__fieldWrapper display-flex flex-wrap cell small-12 flex-center"
                >
                    <div class="relative">
                        <img
                            class="select-arrow"
                            svg-inline
                            src="@img/svg/arrow-down.svg"
                        />
                        <select
                            name="income_dependents"
                            v-model="submission.income_dependents"
                            style="width: 80px;"
                        >
                            <option v-for="i in 11" :key="i" :value="i">{{
                                i
                            }}</option>
                        </select>

                        <label
                            class="form__label display-block visuallyhidden"
                            for="income_dependents"
                            >Number of Income Dependents</label
                        >
                    </div>

                    <span id="income-dependents-tooltip-1" class="lh-1 ml-1">
                        <img
                            svg-inline
                            src="@img/svg/help.svg"
                            class="fill-gray"
                        />
                    </span>
                </div>

                <div class="form__fieldWrapper cell shrink">
                    <continue-skip-buttons></continue-skip-buttons>
                    <div class="w-100 text-center">
                        <back-button></back-button>
                    </div>
                </div>
            </form>

            <div
                v-if="message"
                class="alert text-error text-center mt-3 weight-500 text-20"
            >
                {{ message }}
            </div>
        </div>
    </section>
</template>

<script>
import tippy from "tippy.js";

import { mapGetters } from "vuex";

export default {
    name: "IncomeDependents",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false
        };
    },
    computed: {},
    methods: {
        onSubmit($event) {
            if (this.submission.income_dependents) {
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
                    "You need to enter the number of people your income supports.";
            }
        }
    },

    mounted() {
        const tooltip = document.getElementById("income-dependents-tooltip-1");

        const tooltipInstance = tippy(tooltip, {
            allowHTML: true,
            content: `<div class="tooltip relative">

                Count each person in your home who relies on your income for financial support.
                <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
            </div>`,
            placement: "right",
            offset: [-5, 34],

            delay: [null, 150],
            arrow: true
        });
    }
};

//facebook tracking
fbq("track", "Lead");
</script>
