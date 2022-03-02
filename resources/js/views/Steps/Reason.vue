<template>
    <section class="section pb-4">
        <div class="grid-container grid-container--small mt-2">
            <div class="text-center mb-6">
                <h1 class="text-54 weight-100 text-darkGreen">
                    Welcome to Apprisen’s
                    <span class="text-secondary">free & secure</span> financial
                    analysis!
                </h1>
                <div class="grid-container grid-container--smaller">
                    <p class="font-book text-25">
                        Do you know how much you owe in debt or where you are
                        financially? Apprisen’s online Financial Health Expert,
                        IRIS, can calculate that for you! IRIS is here to show
                        you where all your money is going and how to take
                        control of your finances with a custom action plan—it's
                        completely free and secure. Choose the topic you’d like
                        to focus on below.
                    </p>
                    <p class="font-book text-25">
                        Want to get to know us? Scroll below to learn more.
                    </p>
                </div>
            </div>

            <form
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form form--blocks mt-4"
            >
                <div class="categoryBlockWrapper align-center">
                    <category-block
                        :value="reason.reason"
                        :image="reason.image"
                        :description="reason.description"
                        classes="categoryBlock--reason relative cell small-12"
                        :class="reason.reason"
                        v-for="reason in submission_reasons"
                        :key="reason.id"
                        field-name="reason"
                        type="radio"
                        v-on:category-clicked="categoryChanged"
                        :label="reason.reason"
                    ></category-block>
                </div>

                <div class="form__fieldWrapper cell small-12">
                    <div class="grid-x grid-margin-x align-center mt-6">
                        <div class="cell shrink">
                            <button
                                value="submit"
                                name="submit"
                                type="submit"
                                class="button button--stepNav"
                            >
                                Continue
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div
                v-if="message"
                class="alert text-error text-center my-3 weight-500 text-20"
            >
                {{ message }}
            </div>
            <div class="text-center">
                <h4 class="text-40 weight-100 mt-6">About Apprisen</h4>
                <p class="font-book text-20">
                    Apprisen is an accredited non-profit focused on helping
                    people improve their financial health. We have helped over 1
                    million individuals improve their financial health by
                    empowering them to manage money & get out of debt. Our
                    signature program, the Debt Management Program, helps people
                    pay down debt with lower interest rates & potentially
                    minimum payments.
                </p>
            </div>
        </div>
    </section>
</template>

<script>
import api from "@/api";
import { mapGetters } from "vuex";

import { watchAwaitSelector } from "@/scripts/functions";

import tippy from "tippy.js";

export default {
    name: "SubmissionReason",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false,
            tooltipParent: null,
            tooltipInstance: null
        };
    },
    computed: {
        ...mapGetters({
            submission_type: "submissions/submission_type",
            submission_reason: "submissions/submission_reason"
        })
    },
    methods: {
        categoryChanged(value) {
            this.category = value;

            var vm = this;

            // let tooltipParent = document.querySelector('[value="Bankruptcy"] + label');
            // const instance = tippy(tooltipParent, {
            //     allowHTML: true,
            //     offset: [0, 15],
            //     appendTo: tooltipParent,
            //     delay: [null, 150],
            //     arrow: true,
            //     trigger: "click",
            //     hideOnClick: false,
            //     content: `<div class="tooltip relative text-left">

            //         Select Bankruptcy only if you are actively filing for bankruptcy and need to obtain your Pre-Bankruptcy Counseling Certificate.
            //         <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
            //     </div>`,
            //     placement: 'left',
            // });

            // console.log(instance);

            if (this.category === "Bankruptcy") {
                vm.tooltipInstance.show();
            } else {
                vm.tooltipInstance.hide();
            }
        },

        onSubmit($event) {
            this.saving = true;
            this.message = false;

            if (this.category) {
                if (this.category === "Bankruptcy") {
                    // Store type until user is created during next step
                    this.$store.dispatch(
                        "submissions/updateSubmissionType",
                        "Bankruptcy"
                    );

                    // Disable the Custom Action Plan step
                    this.$store.dispatch("steps/disableSteps", {
                        steps: this.steps,
                        name: this.$route.name,
                        names: [
                            "SubmissionCustomActionPlan",
                            "CompletedGeneralSubmission"
                        ]
                    });

                    // Enable the Bankruptcy-specific steps
                    this.$store.dispatch("steps/enableSteps", {
                        steps: this.steps,
                        name: this.$route.name,
                        names: [
                            "SubmissionBankruptcyWelcome",
                            "BankruptcyIncomeThreshold",
                            // 'BankruptcyUnderThreshold',
                            // 'BankruptcyOverThreshold',
                            "BankruptcyBasics",
                            "BankruptcyBudgetingBasics",
                            "BankruptcyNextStepsResources",
                            "BankruptcyConfirmLogin",
                            "BankruptcyCompletedSubmission"
                        ]
                    });
                } else {
                    // Store type until user is created during next step
                    this.$store.dispatch(
                        "submissions/updateSubmissionType",
                        "General"
                    );
                    // Enable the Custom Action Plan step
                    this.$store.dispatch("steps/enableSteps", {
                        steps: this.steps,
                        name: this.$route.name,
                        names: [
                            "SubmissionCustomActionPlan",
                            "CompletedGeneralSubmission"
                        ]
                    });

                    // Disable the Bankruptcy-specific steps
                    this.$store.dispatch("steps/disableSteps", {
                        steps: this.steps,
                        name: this.$route.name,
                        names: [
                            "SubmissionBankruptcyWelcome",
                            "BankruptcyIncomeThreshold",
                            "BankruptcyUnderThreshold",
                            "BankruptcyOverThreshold",
                            "BankruptcyBasics",
                            "BankruptcyBudgetingBasics",
                            "BankruptcyNextStepsResources",
                            "BankruptcyConfirmLogin",
                            "BankruptcyCompletedSubmission"
                        ]
                    });
                }

                localStorage.setItem("submission-reason", this.category);
                this.$store.dispatch(
                    "submissions/updateSubmissionReason",
                    this.category
                );

                // All required fields are completed
                if (this.$route.name) {
                    this.$store.dispatch("steps/completeStep", {
                        name: this.$route.name,
                        steps: this.steps
                    });
                } else {
                    this.$store.dispatch("steps/completeStep", {
                        name: "SubmissionReason",
                        steps: this.steps
                    });
                }

                // If user/submission already exists, update the submission
                if (this.user.id && this.submission.id) {
                    this.$store.dispatch(
                        "submissions/updateSubmission",
                        this.submission
                    );
                }

                // Update steps to adjust for new enabled/disabled steps
                this.$store.dispatch("steps/updateSteps", this.steps);

                this.$store.dispatch("steps/updateRelativeSteps", {
                    steps: this.steps,
                    name: "SubmissionReason"
                });

                this.$store.dispatch("steps/goToNextStep", {
                    next_step: this.next_step
                });
            } else {
                this.message = "You must select a topic.";
            }
        }
    },
    computed: {},
    async mounted() {
        let value = localStorage.getItem("submission-reason");

        if (!value) {
            await api.submissions
                .current()
                .then(response => {
                    value = response.data.reason;
                })
                .catch(error => {
                    console.log(error);
                });
        }

        if (value) {
            watchAwaitSelector(function(elements) {
                for (let element of elements) {
                    element.checked = false;
                }

                let input = document.querySelector(
                    `.categoryBlock input[value="${value}"]`
                );
                if (input) {
                    input.checked = true;
                }
            }, ".categoryBlock input");
        } else {
            $(".categoryBlock input").prop("checked", false);
            watchAwaitSelector(function(elements) {
                console.log("in here");
                for (let element of elements) {
                    element.checked = false;
                }
            }, ".categoryBlock input");
        }

        this.tooltipParent = document.querySelector(
            '[value="Bankruptcy"] + label'
        );
        var vm = this;
        watchAwaitSelector(function() {
            let tooltipParent = document.querySelector(
                '[value="Bankruptcy"] + label'
            );
            vm.tooltipInstance = tippy(tooltipParent, {
                allowHTML: true,
                offset: [0, 15],
                appendTo: tooltipParent,
                delay: [null, 150],
                arrow: true,
                trigger: "click",
                hideOnClick: false,
                content: `<div class="tooltip relative text-left">

                    Select Bankruptcy only if you are actively filing for bankruptcy and need to obtain your Pre-Bankruptcy Counseling Certificate.
                    <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
                </div>`,
                placement: "left"
            });

            if (value === "Bankruptcy") {
                vm.tooltipInstance.show();
            }

            // console.log(instance);
        }, '[value="Bankruptcy"] + label');
    }
};
</script>
