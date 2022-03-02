<template>
    <div
        id="login-modal"
        class="reveal reveal--createAccountModal reveal--loginModal flex-center mx-auto"
        data-reveal
        style="display:none;"
    >
        <div class="reveal__inner relative bg-white">
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-large-6">
                    <img
                        class="display-block mx-auto"
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
                <div
                    class="cell small-12 medium-large-6"
                    v-if="!message && showForgotPasswordForm === false"
                >
                    <div class="display-flex flex-column">
                        <h2 class="text-32 weight-100">
                            Log in to continue where you left off!
                        </h2>
                        <p class="font-book text-20 weight-300">
                            Enter your email address and password to log in.
                        </p>
                        <form
                            method="POST"
                            @submit.prevent="onSubmit($event)"
                            id="login-modal-form"
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

                            <div
                                class="form__fieldWrapper display-flex flex-wrap cell small-12"
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
                            </div>

                            <div class="form__fieldWrapper cell small-12">
                                <div class="w-100 mb-3" v-if="messageFailed">
                                    <p
                                        class="alert text-error weight-500 text-20"
                                    >
                                        {{ messageFailed }}
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <button
                                        type="button"
                                        @click="forgotPassword(true)"
                                        class="text-17 weight-600 underline uppercase text-secondary"
                                    >
                                        Forgot Password?
                                    </button>
                                </div>

                                <div class="">
                                    <button
                                        value="submit"
                                        name="submit"
                                        type="submit"
                                        class="button"
                                    >
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div
                    class="cell small-12 medium-large-6"
                    v-if="showForgotPasswordForm === true"
                >
                    <forgot-password-form></forgot-password-form>

                    <button
                        type="button"
                        @click="forgotPassword(false)"
                        class="text-17 weight-600 underline uppercase text-primary mt-3"
                    >
                        Cancel
                    </button>
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
    name: "LoginModal",
    data: function() {
        return {
            message: null,
            messageFailed: null,
            showForgotPasswordForm: false
        };
    },
    methods: {
        async onSubmit($event) {
            await api.users
                .login2({
                    email: this.user.email,
                    password: this.user.password
                })
                .then(async response => {
                    if (response.data.verified === true) {
                        // Temporarily required, until figure out how to fully authorize without reload
                        //location.reload();
                        this.message = "Login successful!";
                        this.messageFailed = null;
                        localStorage.setItem("jwt", response.data.access_token);
                        this.$store.dispatch("users/getUser");

                        await api.submissions
                            .current()
                            .then(response => {
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
                                let savedStepsNamespace = JSON.parse(
                                    response.data.steps_namespace
                                );
                                if (savedStepsNamespace) {
                                    this.$store.dispatch(
                                        "steps/restoreStepsState",
                                        savedStepsNamespace
                                    );
                                }
                                if (response.data.last_saved_step) {
                                    this.$router.push({
                                        name: response.data.last_saved_step
                                    });
                                }
                            })
                            .catch(error => {
                                console.log("---------submission error");
                                console.log(error);
                            });

                    } else {
                        this.messageFailed = "Login failed.";
                        this.message = null;
                    }
                })
                .catch(error => {
                    console.log("login error");
                    console.log(error.response.data);
                    console.log(error);
                });
        },
        forgotPassword(state) {
            this.showForgotPasswordForm = state;
        }
    }
};
</script>
