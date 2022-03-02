<template>
    <section
        id="bottom-bar"
        class="bar bg-primary fixed b-0 l-0 w-100 display-flex align-middle"
    >
        <div class="bar__inner grid-container grid-container--large w-100">
            <div class="grid-x grid-margin-x grid-margin-y align-justify">
                <div class="cell small-4 medium-large-3 flex-start my-auto">
                    <a
                        href="https://www.bbb.org/us/oh/columbus/profile/credit-and-debt-counseling/apprisen-0302-972"
                        target="_blank"
                        ><img svg-inline src="@img/svg/bbb-accredited.svg"
                    /></a>
                </div>
                <div
                    class="cell small-4 medium-large-3 flex-center show-medium-large-up"
                >
                    <p
                        class="mb-0 display-inline-flex align-middle lh-1 text-16 weight-600 text-white"
                    >
                        <img
                            svg-inline
                            src="@img/svg/lock.svg"
                            class="fill-white mr-1"
                        />Your information is Secure
                    </p>
                </div>
                <div class="cell small-4 medium-large-3 flex-center">
                    <button
                        class="underline uppercase text-offwhite text-16 weight-600"
                        @click="saveAndExit"
                        v-if="user.id"
                    >
                        Save & Exit
                    </button>
                    <div
                        class="text-white mx-1"
                        v-if="
                            user.id &&
                                (showLogin || (user.id && user.has_password))
                        "
                    >
                        &nbsp;|&nbsp;
                    </div>
                    <button
                        class="underline uppercase text-offwhite text-16 weight-600"
                        @click="login"
                        v-if="!user.id"
                    >
                        Login
                    </button>
                    <button
                        class="underline uppercase text-offwhite text-16 weight-600"
                        @click="logout"
                        v-if="user.id && user.has_password"
                    >
                        Logout
                    </button>
                </div>
                <div class="cell small-4 medium-large-3 flex-center">
                    <questions-iris></questions-iris>
                </div>
                <div class="cell small-12 flex-center hide-medium-large-up">
                    <p
                        class="mb-0 display-inline-flex align-middle lh-1 text-16 weight-600 text-white"
                    >
                        <img
                            svg-inline
                            src="@img/svg/lock.svg"
                            class="fill-white mr-1"
                        />Your information is Secure
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import api from "@/api";
export default {
    name: "BottomBar",
    computed: {
        showLogin: function() {}
    },
    methods: {
        async saveAndExit() {
            this.submission.last_saved_step = this.$store.state.steps.current_step.name;
            this.submission.steps_namespace = localStorage.getItem(
                "steps-namespace"
            );
            await this.$store
                .dispatch("submissions/updateSubmission", this.submission)
                .then(response => {})
                .catch(error => {
                    console.log(error);
                });

            if (
                this.user.has_email === 0 ||
                this.user.has_email === false ||
                this.user.has_password === 0 ||
                this.user.has_password === false
            ) {
                $("#create-account-modal").foundation("open");
            } else if (
                this.user.id &&
                this.submission.id &&
                (this.user.has_email === 1 || this.user.has_email === true) &&
                (this.user.has_password === 1 ||
                    this.user.has_password === true)
            ) {
                let selected_incomes = localStorage.getItem("income-steps");
                let selected_expenses = localStorage.getItem(
                    "enabled-expense-types"
                );
                if (selected_incomes)
                    this.submission.selected_incomes = selected_incomes;
                if (selected_expenses)
                    this.submission.selected_expenses = selected_expenses;

                // If user/submission already exists, update the submission
                await this.$store
                    .dispatch("submissions/updateSubmission", this.submission)
                    .then(response => {
                        api.users.logout().then(response => {
                            this.logout();
                        });
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        login() {
            $("#login-modal").foundation("open");
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
                this.submission.referrer = null;
                this.submission.referrer_tag_id = null;
                this.submission.date_of_birth = null;
                this.submission.co_applicant_date_of_birth = null;

                //this.$store.dispatch("users/resetUser");
                this.$store.dispatch("steps/resetStepsProgress");
                this.$store.dispatch("submissions/resetSubmission");
                this.$router.push({ name: "SubmissionReason" });
            });
        }
    },
    mounted() {
    }
};
</script>
