<template>
    <bankruptcy-video-section
        heading="Next Steps & Resources"
        video="/videos/Next-Steps-Resources-Revised.mp4"
        class="mt-6"
    >
        <template v-slot:text>
            <p>
                Now that you know how to establish and maintain a budget, in
                this lesson we cover debt solution options that may be more
                viable to you vs. filing bankruptcy. You will learn 6 main
                bankruptcy alternatives, along with their pros and cons:
            </p>
            <ul>
                <li>Debt Snowball</li>
                <li>Debt Avalanche</li>
                <li>Debt Management Program</li>
                <li>Consolidation</li>
                <li>Debt Settlement</li>
                <li>Payday Loans</li>
            </ul>

            <p>
                The lesson also covers next steps in the counseling session &
                resources to help start your path to financial health.
            </p>

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
    name: "BankruptcyNextStepsResources",
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
