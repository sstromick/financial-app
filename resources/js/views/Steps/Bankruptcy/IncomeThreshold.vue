<template>
    <section class="section py-4">
        <div class="grid-container mt-6">
            <div class="grid-container grid-container--smaller text-center">
                <h1 class="text-54 weight-100 text-darkGreen">
                    First, let's figure out your income.
                </h1>

                <p class="font-book text-25">
                    Why? The standard fee for pre-bankruptcy counseling is $25.
                    But you may not have to pay a fee at all! Refer to the
                    income threshold chart below to see if you qualify to get
                    the service fee waived.
                </p>
            </div>

            <table class="hover my-6">
                <thead>
                    <tr>
                        <th>Number in Household</th>
                        <th>Annual Gross Income</th>
                        <th>Monthly Gross Income</th>
                    </tr>
                </thead>
                <colgroup>
                    <col />
                    <col />
                    <col />
                </colgroup>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>$42,000</td>
                        <td>$3,500</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>$35,000</td>
                        <td>$2,916</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>$54,000</td>
                        <td>$4,500</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>$54,000</td>
                        <td>$4,500</td>
                    </tr>
                </tbody>
            </table>

            <div
                class="grid-container grid-container--smaller text-center mb-6"
            >
                <button
                    id="income-threshold-tooltip-1"
                    class="text-17 weight-600 uppercase underline text-secondary display-inline-flex align-middle mb-6 hover:fill-primary hover:primary"
                >
                    What is Gross Income?
                    <span class="lh-1 ml-1"
                        ><img
                            svg-inline
                            src="@img/svg/help.svg"
                            class="fill-secondary"
                    /></span>
                </button>

                <p class="font-book text-25 font-book weight-300">
                    After you’ve reviewed the chart above, select the one that
                    applies to you. If your income is under the amount in the
                    box, choose under threshold. If your income is over the
                    amount in the box, choose over threshold:
                </p>

                <p class="font-book text-25 font-book weight-500">
                    If choosing "over threshold", you will be re-directed to a
                    payment page.
                </p>
            </div>

            <div class="display-flex grid-x grid-margin-x align-center">
                <div class="cell shrink">
                    <button
                        @click="goToUnderThreshold"
                        id="under-threshold"
                        class="button button--hollow"
                    >
                        Under Threshold
                    </button>
                </div>
                <div class="cell shrink">
                    <button
                        @click="goToOverThreshold"
                        id="over-threshold"
                        class="button button--hollow"
                    >
                        Over Threshold
                    </button>
                </div>
                <div class="cell small-12 flex-center mt-6">
                    <back-button></back-button>
                </div>
            </div>
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

export default {
    name: "BankruptcyIncomeThreshold",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false
        };
    },
    methods: {
        onSubmit($event) {
            this.saving = true;
            this.message = false;
        },
        goToUnderThreshold() {
            this.$store.dispatch("steps/disableSteps", {
                steps: this.steps,
                names: ["BankruptcyOverThreshold"]
            });

            this.$store.dispatch("steps/enableSteps", {
                steps: this.steps,
                names: ["BankruptcyUnderThreshold"]
            });

            this.$store.dispatch("steps/completeStep", {
                name: this.$route.name,
                steps: this.steps
            });

            this.$store.dispatch("steps/goToStep", {
                name: "BankruptcyUnderThreshold"
            });

            localStorage.setItem("over-threshold", "false");
        },
        goToOverThreshold() {
            this.$store.dispatch("steps/disableSteps", {
                steps: this.steps,
                names: ["BankruptcyUnderThreshold"]
            });

            this.$store.dispatch("steps/disableSteps", {
                steps: this.steps,
                names: ["BankruptcyOverThreshold"]
            });

            this.$store.dispatch("steps/completeStep", {
                name: this.$route.name,
                steps: this.steps
            });

            // this.$store.dispatch('steps/goToStep', {
            //     name: 'BankruptcyOverThreshold',
            // });
            localStorage.setItem("over-threshold", "true");

            location =
                "https://bh894.infusionsoft.app/app/orderForms/3be401b9-a5a7-4e75-aa67-e09d92f1c369?cookieUUID=b111341a-5fa7-4455-b467-08f5f77fbe3f";
        }
    },
    mounted() {
        const tooltip = document.getElementById("income-threshold-tooltip-1");

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
    }
};
</script>
