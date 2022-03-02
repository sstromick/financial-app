<template>
    <bankruptcy-video-section
        heading="Bankruptcy Basics"
        video="/videos/Bankruptcy-Basics-Revised.mp4"
        class="mt-6"
    >
        <template v-slot:text>
            <p>
                In this lesson, we will walk you through the bankruptcy basics
                to help you understand the process if you do decide to file. You
                will learn:
            </p>

            <ul>
                <li>
                    What is Bankruptcy
                    <ul>
                        <li>Chapter 7</li>
                        <li>Chapter 13</li>
                    </ul>
                </li>
                <li>The Impact of Bankruptcy on Your Finances</li>
                <li>The Impact of Bankruptcy in Other Areas of Your Life</li>
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
    name: "BankruptcyBasics",
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
