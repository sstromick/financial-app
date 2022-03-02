<template>
    <section class="section pb-4">
        <div class="grid-container mt-2">
            <div class="text-center flex-column flex-center">
                <img :src="income_type.image" class="mb-2" />
                <h1 class="text-secondary text-28 weight-500">
                    Monthly Social Security Income
                </h1>

                <div class="mt-2">
                    <div
                        class="grid-container grid-container--smaller text-center"
                    >
                        <h2 class="text-54 weight-100 text-darkGreen">
                            Great! Now let's delve a little deeper.
                        </h2>

                        <p class="font-book text-25 mb-4">
                            Below, enter in the amount of your social security
                            income. If you don’t know the exact number, that’s
                            okay! Enter your best estimate.
                        </p>

                        <p
                            class="text-25 weight-500 display-inline-flex align-middle"
                        >
                            Monthly Social Security Income
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
                class="form mt-4 grid-x grid-margin-x align-center"
            >
                <ValidationProvider
                    tag="div"
                    rules="required|numeric"
                    class="form__fieldWrapper display-flex flex-wrap cell small-6"
                    v-slot="{ classes, errors }"
                >
                    <div
                        class="display-flex flex-wrap control w-100 flex-center"
                        :class="classes"
                    >
                        <input
                            name="social_security_income"
                            v-model="submission.social_security_income"
                            placeholder="XXXXXX"
                            type="number"
                            step="0.01"
                            min="1"
                            style="width: 150px;"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="social_security_income "
                            >Social Security Income</label
                        >
                        <p class="errors-wrapper w-100">{{ errors[0] }}</p>
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
import { mapGetters } from "vuex";

export default {
    name: "SocialSecurityIncome",
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

            if (this.submission.social_security_income && isValid) {
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
                    "You must enter the estimated amount of social security income you receive.";
            }
        }
    },
    mounted() {
        let income_type = this.income_types.filter(obj => {
            return obj.income_type === "Social Security Income";
        });

        if (income_type && income_type[0]) {
            this.income_type = income_type[0];
        }
    }
};
</script>
