<template>
    <section class="section pb-4">
        <div class="grid-container mt-2">
            <div class="grid-container grid-container--smaller text-center">
                <h1 class="text-54 weight-100 text-darkGreen">
                    {{ headingTitle }}
                </h1>

                <p class="font-book text-25">
                    Once you complete the steps, we’ll be sending you a
                    customized action plan that will get you started on your
                    journey to financial health. Enter your contact information
                    below so a financial specialist can connect with you to
                    share your custom plan. Sharing your information allows us
                    to communicate with you about your action plan—but don’t
                    worry, we won’t share it with anyone else.
                </p>
                <a
                    href="/privacy"
                    target="_blank"
                    class="weight-600 uppercase text-secondary underline text-center"
                    >Privacy Notice</a
                >
            </div>

            <ValidationObserver
                tag="form"
                ref="observer"
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form mt-4 grid-x grid-margin-x grid-margin-y"
            >
                <ValidationProvider
                    tag="div"
                    name="first_name"
                    rules="required"
                    class="form__fieldWrapper display-flex flex-wrap cell small-6"
                    v-slot="{ classes, errors }"
                >
                    <div class="control w-100" :class="classes">
                        <input
                            name="first_name"
                            v-model="submission.first_name"
                            placeholder="First Name"
                            type="text"
                            autocomplete="given-name"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="first_name"
                            >First Name</label
                        >

                        <p class="errors-wrapper">{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>

                <ValidationProvider
                    tag="div"
                    name="last_name"
                    rules="required"
                    class="form__fieldWrapper display-flex flex-wrap cell small-6"
                    v-slot="{ classes, errors }"
                >
                    <div class="control w-100" :class="classes">
                        <input
                            name="last_name"
                            v-model="submission.last_name"
                            placeholder="Last Name"
                            type="text"
                            autocomplete="family-name"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="last_name"
                            >Last Name</label
                        >

                        <p class="errors-wrapper">{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>

                <ValidationProvider
                    tag="div"
                    name="email"
                    rules="required|email"
                    class="form__fieldWrapper display-flex flex-wrap cell small-12"
                    v-slot="{ classes, errors }"
                    v-if="user.has_email === 0 || user.has_email === false"
                >
                    <div class="control w-100" :class="classes">
                        <input
                            name="email"
                            v-model.trim="user.email"
                            placeholder="Email"
                            type="text"
                            autocomplete="email"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="email"
                            >Email</label
                        >

                        <p class="errors-wrapper">{{ errors[0] }}</p>
                    </div>
                </ValidationProvider>

                <div class="cell small-12">
                    <p class="text-center text-18 font-book weight-300">
                        As you work your way through our financial analysis,
                        fill out as much information as you can. If you reach a
                        question you aren’t able to answer, you have the ability
                        to skip any step in the process.
                    </p>
                </div>

                <div class="cell small-12">
                    <div
                        v-if="message"
                        class="alert text-error text-center weight-500 text-20"
                    >
                        {{ message }}
                    </div>
                </div>

                <div class="form__fieldWrapper cell small-12">
                    <div class="flex-center mt-2 mb-3">
                        <button
                            value="submit"
                            name="submit"
                            type="submit"
                            class="button button--stepNav"
                        >
                            Continue
                        </button>
                    </div>

                    <div class="flex-center">
                        <back-button></back-button>
                    </div>
                </div>
            </ValidationObserver>
        </div>
    </section>
</template>

<script>
import api from "@/api";
import router from "../../router";

export default {
    name: "SubmissionCustomActionPlan",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false,
            showLoginMsg: false
        };
    },
    computed: {
        headingTitle: function() {
            if (this.submission.reason == "Debt")
                return "Where should we send your Custom Debt Management Plan?";
            else return "Where should we send your Custom Action Plan?";
        }
    },
    methods: {
        async onSubmit($event) {
            const isValid = await this.$refs.observer.validate();

            await this.$recaptchaLoaded();
            const token = await this.$recaptcha("login");
            let formData = new FormData();
            formData.append("recaptcha_token", token);
            formData.append("email", this.user.email);
            formData.append("has_email", this.user.has_email);
            formData.append("has_password", this.user.has_password);

            if (
                this.user.id &&
                this.user.email &&
                this.submission.first_name &&
                this.submission.last_name &&
                isValid
            ) {
                // All required fields are completed
                this.$store.dispatch("steps/completeStep", {
                    name: this.$route.name,
                    steps: this.steps
                });

                this.$store.dispatch(
                    "submissions/updateSubmission",
                    this.submission
                );

                this.$store.dispatch("steps/goToNextStep", {
                    next_step: this.next_step
                });
            } else if (
                this.user.email &&
                this.submission.first_name &&
                this.submission.last_name &&
                isValid
            ) {
                // Create new user
                await api.users
                    .create(formData)
                    .then(response => {
                        this.login = response.data.url;
                        this.user.id = response.data.id;

                        localStorage.setItem("jwt", response.data.access_token);

                        // @IMPORTANT: Temporary localhost to bypass CORS
                        let url = new URL(this.login);
                        //url.port = 9999;

                        // password-less login
                        axios
                            .get(url)
                            .then(response => {
                                this.$store.dispatch("users/getUser");
                                this.submission.user_id = this.user.id;
                                this.submission.referrer = this.$referrer;
                                this.submission.referrer_tag_id = this.$referrer_tag_id;
                                console.log(this.submission.referrer_tag_id);
                                api.submissions
                                    .create(this.submission)
                                    .then(response => {
                                        api.infusionsoft.addClientTag({
                                            id: response.data.id
                                        });

                                        if (response.data.selected_incomes)
                                            localStorage.setItem(
                                                "income-steps",
                                                response.data.selected_incomes
                                            );
                                        if (response.data.steps_namespace)
                                            localStorage.setItem(
                                                "steps-namespace",
                                                response.data.steps_namespace
                                            );
                                        if (response.data.selected_incomes)
                                            localStorage.setItem(
                                                "income-steps",
                                                response.data.selected_incomes
                                            );
                                        if (response.data.selected_expenses)
                                            localStorage.setItem(
                                                "enabled-expense-types",
                                                response.data.selected_expenses
                                            );
                                        let savedStepsNamespace = null;
                                        if (response.data.steps_namespace) {
                                            savedStepsNamespace = JSON.parse(
                                                response.data.steps_namespace
                                            );
                                        }
                                        if (savedStepsNamespace) {
                                            this.$store.dispatch(
                                                "steps/restoreStepsState",
                                                savedStepsNamespace
                                            );
                                        }
                                        this.$store.dispatch("users/getUser");
                                        this.$store.dispatch(
                                            "submissions/getSubmission"
                                        );

                                        // All required fields are completed
                                        this.$store.dispatch(
                                            "steps/completeStep",
                                            {
                                                name: this.$route.name,
                                                steps: this.steps
                                            }
                                        );

                                        this.$store.dispatch(
                                            "submissions/updateSubmission",
                                            this.submission
                                        );

                                        this.$store.dispatch(
                                            "steps/goToNextStep",
                                            {
                                                next_step: this.next_step
                                            }
                                        );
                                    })
                                    .catch(error => {
                                        this.message =
                                            error.response.data.message ||
                                            "There was an issue creating a submission for this user.";
                                    });
                            })
                            .catch(error => {
                                console.log("post error");
                                console.log(error.response.data);
                            });
                    })
                    .catch(error => {
                        console.log("post error");
                        console.log(error.response.data);
                        if (error.response.data.errors.recaptcha_token)
                            this.message = "Recaptcha validation error";

                        if (
                            error.response.data.errors.email &&
                            error.response.data.errors.email[0] ==
                                "The email has already been taken."
                        ) {
                            this.message = "User already exists, please login.";
                        }
                    });
            } else {
            }
        }
    },
    mounted() {}
};
</script>
