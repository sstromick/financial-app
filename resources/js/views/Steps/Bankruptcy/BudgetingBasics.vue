<template>
    <bankruptcy-video-section
        heading="Budgeting Basics"
        video="/videos/Budgeting-Basics-Revised.mp4"
        class="mt-6"
    >
        <template v-slot:text>
            <p>
                A sustainable budget is the foundation for financial health. In
                this lesson you will learn the four key steps in budgeting:
            </p>

            <ul>
                <li>Track Expenses</li>
                <li>Analyze & Adjust Budget</li>
                <li>Create a Spending Plan</li>
                <li>Check-in Regularly</li>
            </ul>

            <div class="grid-x grid-margin-x mt-7 mb-4">
                <div class="cell shrink">
                    <button
                        type="button"
                        class="button button--stepNav"
                        @click="onClick($event)"
                    >
                        Continue
                    </button>
                </div>
            </div>
            <back-button></back-button>
        </template>
    </bankruptcy-video-section>
</template>

<script>
export default {
    name: "BankruptcyBudgetingBasics",
    methods: {
        onClick($event) {
            this.$store.dispatch("steps/completeStep", {
                name: this.$route.name,
                steps: this.steps
            });

            this.$store.dispatch("steps/goToNextStep", {
                next_step: this.next_step
            });
        }
    }
};
</script>
