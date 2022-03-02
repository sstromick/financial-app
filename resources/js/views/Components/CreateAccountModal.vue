<template>
    <div
        id="create-account-modal"
        class="reveal reveal--createAccountModal flex-center mx-auto"
        data-reveal
        style="display:none;"
    >
        <div class="reveal__inner relative bg-white">
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-large-6">
                    <img
                        class="mx-auto display-block"
                        svg-inline
                        src="@img/svg/iris-create-account.svg"
                    />
                    <a
                        href="/privacy"
                        target="_blank"
                        class="text-17 weight-600 underline uppercase text-primary display-block text-center mt-4"
                        >Privacy Notice</a
                    >
                </div>
                <div class="cell small-12 medium-large-6" v-if="!message">
                    <div class="display-flex flex-column">
                        <h2 class="text-32 weight-100">
                            I'll save your spot for you while you're away!
                        </h2>
                        <p class="font-book text-20 weight-300">
                            Enter your email address and create a password so
                            you can sign in later and pick up where you left
                            off. All your previous work will be saved!
                        </p>
                        <form
                            method="POST"
                            @submit.prevent="onSubmit($event)"
                            id="create-account-modal-form"
                            class="form grid-x grid-margin-y"
                        >
                            <div
                                class="form__fieldWrapper display-flex flex-wrap cell small-12"
                            >
                                <input
                                    name="email"
                                    v-model.trim="user.email"
                                    placeholder="Email"
                                    type="email"
                                    autocomplete="email"
                                />

                                <label
                                    class="form__label display-block visuallyhidden"
                                    for="email"
                                    >Email</label
                                >
                            </div>

                            <ValidationProvider
                                tag="div"
                                name="password"
                                rules="required|verify_password|min:8"
                                class="form__fieldWrapper display-flex flex-wrap cell small-12"
                                v-slot="{ classes, errors }"
                                v-if="
                                    user.has_password === 0 ||
                                        user.has_password === false
                                "
                            >
                                <div
                                    class="control w-100 relative"
                                    :class="classes"
                                >
                                    <input
                                        name="password"
                                        v-model="user.password"
                                        placeholder="Password"
                                        type="password"
                                        autocomplete="password"
                                    />
                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="password"
                                        >Password</label
                                    >
                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>
                            <div class="form__fieldWrapper cell small-12">
                                <div class="">
                                    <button
                                        value="submit"
                                        name="submit"
                                        type="submit"
                                        class="button"
                                    >
                                        Create An Account
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="cell small-12 medium-large-6" v-if="message">
                    <p class="text-30 text-secondary weight-300">
                        {{ message }}
                    </p>
                </div>
            </div>
            <div
                class="reveal__closeWrapper absolute display-inline-block lh-1"
            >
                <button data-close aria-label="Close modal">
                    <span aria-hidden="true"
                        ><img
                            svg-inline
                            src="@img/svg/close.svg"
                            class="reveal__close"
                    /></span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import api from "@/api";
import { mapGetters } from "vuex";

export default {
    name: "CreateAccountModal",
    data: function() {
        return {
            message: null
        };
    },
    methods: {
        // @TODO ask/look into better way of checking all of this/in other components in DRY way
        async onSubmit($event) {
            await this.$recaptchaLoaded();
            const token = await this.$recaptcha("login");
            this.user.recaptcha_token = token;

            let selected_incomes = localStorage.getItem("income-steps");
            let selected_expenses = localStorage.getItem(
                "enabled-expense-types"
            );

            if (selected_incomes)
                this.submission.selected_incomes = selected_incomes;
            if (selected_expenses)
                this.submission.selected_expenses = selected_expenses;

            // Has everything except password
            if (
                this.user.id &&
                this.submission.id &&
                this.submission.first_name &&
                this.submission.last_name &&
                (this.user.has_password === 0 ||
                    this.user.has_password === false)
            ) {
                api.users.update(this.user.id, this.user).then(response => {
                    localStorage.setItem("has_password", "true");
                    api.submissions
                        .update(this.submission.id, this.submission)
                        .then(response => {
                            this.logout();
                        });
                });
            } else if (!this.user.id && !this.submission.id) {
                // Create new user
                api.users.create(this.user).then(response => {
                    this.login = response.data.url;
                    this.user.id = response.data.id;
                    localStorage.setItem("has_password", "true");

                    // @IMPORTANT: Temporary localhost to bypass CORS
                    let url = new URL(this.login);

                    // password-less login
                    axios.get(url).then(response => {
                        this.$store.dispatch("users/getUser");

                        this.submission.user_id = this.user.id;

                        // Create new submission
                        api.submissions
                            .create(this.submission)
                            .then(response => {
                                this.$store.dispatch("users/getUser");
                                this.$store.dispatch(
                                    "submissions/getSubmission"
                                );
                                this.logout();
                                //location.reload();
                            })
                            .catch(error => {
                                this.message =
                                    error.response.data.message ||
                                    "There was an issue creating a submission for this user.";
                            });
                    });
                });
            } else if (this.user.id && !this.submission.id) {
                this.submission.user_id = this.user.id;

                // Create new submission
                api.submissions
                    .create(this.submission)
                    .then(response => {
                        this.$store.dispatch("users/getUser");
                        this.$store.dispatch("submissions/getSubmission");
                        //location.reload();
                    })
                    .catch(error => {
                        this.message =
                            error.response.data.message ||
                            "There was an issue creating a submission for this user.";
                    });
            }
        },

        logout() {
            $(".milestone--completed").removeClass("milestone--completed");

            localStorage.removeItem("jwt");
            localStorage.removeItem("income-steps");
            localStorage.removeItem("submission-reason");
            localStorage.removeItem("enabled-expense-types");
            localStorage.removeItem("steps-namespace");
            api.users.logout().then(response => {
                this.user.id = null;
                this.user.email = null;
                this.user.password = null;
                this.user.first_name = null;
                this.user.last_name = null;
                this.user.has_email = 0;
                this.user.has_password = 0;
                this.submission.id = null;
                this.submission.first_name = null;
                this.submission.last_name = null;
                this.submission.reason = null;
                this.steps.progress = 0;
                this.steps.completed_steps = null;
                this.submission.joint_coapplicant = false;
                this.$store.dispatch("steps/resetStepsProgress");
                this.$store.dispatch("submissions/resetSubmission");
                this.$router.push({ name: "SubmissionReason" });
                //location.reload();
                $("#create-account-modal").foundation("close");
            });
        }
    }
};
</script>
<style>
.error-red {
    color: red;
}
.form .errors-wrapper {
    margin-bottom: 2rem !important;
}
</style>
