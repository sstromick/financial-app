<template>
    <section class="section py-4">
        <div class="grid-container grid-container--large mt-6">
            <div class="grid-x grid-margin-x">
                <div class="cell small-12 medium-large-5">
                    <h1 class="">
                        Welcome to the Apprisen Bankruptcy Pre-Filing Counseling
                        Session!
                    </h1>
                    <div class="text-25 font-book">
                        <p>
                            This session is required before filing for
                            bankruptcy and is
                            <span
                                id="eoust-tooltip"
                                class="text-secondary weight-500"
                                >approved by EOUST.</span
                            >
                            We have designed this course with your needs in
                            mind: the online course is user-friendly & easy to
                            follow. Our video feature adds an element of
                            interaction to the course & provides engaging
                            financial education content. You’ll leave with a
                            better understanding of the bankruptcy process,
                            resources to build your financial health and a
                            counseling certificate to share with your attorney.
                        </p>

                        <h2 class="text-30 font-body weight-500">
                            What to Expect:
                        </h2>
                        <p>
                            <strong>Cost:</strong> The standard fee for
                            pre-bankruptcy counseling is $25. But you may not
                            have to pay a fee at all! At the beginning of the
                            session, we will look at your income to determine
                            whether you are eligible for a fee waiver.
                        </p>
                        <p>
                            <strong>Process:</strong> Over the next 60 minutes,
                            you will complete a full budget analysis and review
                            3 financial education videos. This will all help you
                            gain a better understanding of your financial
                            situation and give our professional counselors the
                            information they need to help you explore bankruptcy
                            alternatives and ways to improve your financial
                            health moving forward.
                        </p>
                        <p>
                            Once you submit your information, you must connect
                            with a counselor via chat, phone or email to
                            finalize your session and get your certificate. The
                            easiest way to do this is to chat immediately upon
                            submission. You’ll see prompts when it’s time to do
                            that!
                        </p>

                        <h2 class="text-30 font-body weight-500">
                            Next Steps:
                        </h2>
                        <ul>
                            <li>
                                Gather needed documents. It’s really helpful to
                                have the following information available to help
                                you accurately complete the process:
                                <ul>
                                    <li>Pay statements</li>
                                    <li>
                                        Creditor statements (CC, medical bills,
                                        etc)
                                    </li>
                                    <li>List of Household Expenses/Bills</li>
                                </ul>
                            </li>
                            <li>
                                Before continuing, please read the disclosures
                                below & affirm your understanding & acceptance
                                of the material within. Once completed, hit
                                continue.
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="cell small-12 medium-large-5 medium-large-offset-2">
                    <ValidationObserver
                        tag="form"
                        ref="observer"
                        id="submission-form"
                        method="POST"
                        @submit.prevent="onSubmit($event)"
                        class="form form--bankruptcyWelcome mx-auto"
                    >
                        <div
                            class="form__grid grid-x grid-margin-x grid-margin-y"
                        >
                            <!-- Row -->
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

                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
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

                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>

                            <!-- Row -->
                            <ValidationProvider
                                tag="div"
                                name="address_line_1"
                                rules="required"
                                class="form__fieldWrapper display-flex flex-wrap cell small-12 medium-8"
                                v-slot="{ classes, errors }"
                            >
                                <div class="control w-100" :class="classes">
                                    <input
                                        name="address_line_1"
                                        v-model="submission.address_line_1"
                                        placeholder="Address Line 1"
                                        type="text"
                                        autocomplete="address-line1"
                                    />

                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="address_line_1"
                                        >Address Line 1</label
                                    >

                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>

                            <div
                                class="form__fieldWrapper display-flex flex-wrap cell small-12 medium-4"
                            >
                                <input
                                    name="address_line_2"
                                    v-model="submission.address_line_2"
                                    placeholder="Apt #"
                                    type="text"
                                    autocomplete="address-line2"
                                />

                                <label
                                    class="form__label display-block visuallyhidden"
                                    for="address_line_1"
                                    >Apt #</label
                                >
                            </div>

                            <!-- Row -->
                            <ValidationProvider
                                tag="div"
                                name="city"
                                rules="required"
                                class="form__fieldWrapper form__fieldWrapper--city form__fieldWrapper--37 display-flex flex-wrap"
                                v-slot="{ classes, errors }"
                            >
                                <div class="control w-100" :class="classes">
                                    <input
                                        name="city"
                                        v-model="submission.city"
                                        placeholder="City"
                                        type="text"
                                        autocomplete="address-level2"
                                    />

                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="city"
                                        >City</label
                                    >

                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>

                            <ValidationProvider
                                tag="div"
                                name="state"
                                rules="required"
                                class="form__fieldWrapper form__fieldWrapper--state display-flex flex-wrap cell auto relative"
                                v-slot="{ classes, errors }"
                            >
                                <div
                                    class="control w-100 relative"
                                    :class="classes"
                                >
                                    <img
                                        class="select-arrow"
                                        svg-inline
                                        src="@img/svg/arrow-down.svg"
                                    />
                                    <select
                                        name="state"
                                        v-model="submission.state"
                                    >
                                        <option value="null" disabled hidden
                                            >State</option
                                        >
                                        <option
                                            v-for="state in us_states"
                                            :key="state.id"
                                            >{{ state.code }}</option
                                        >
                                    </select>

                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="state"
                                        >State</label
                                    >
                                </div>

                                <div class="control w-100" :class="classes">
                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>

                            <ValidationProvider
                                tag="div"
                                name="zip"
                                rules="required"
                                class="form__fieldWrapper form__fieldWrapper--zip form__fieldWrapper--37 display-flex flex-wrap relative"
                                v-slot="{ classes, errors }"
                            >
                                <div
                                    class="control w-100 relative"
                                    :class="classes"
                                >
                                    <input
                                        name="zip"
                                        v-model="submission.zip"
                                        placeholder="Zip"
                                        type="text"
                                        autocomplete="postal-code"
                                    />

                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="zip"
                                        >Zip</label
                                    >
                                    <span
                                        id="zip-tooltip"
                                        class="lh-1 ml-1 tooltip__helpIcon cursor-pointer tooltip__helpIcon--insideInput"
                                        ><img
                                            svg-inline
                                            src="@img/svg/help.svg"
                                            class="fill-gray"
                                    /></span>
                                </div>

                                <div class="control w-100" :class="classes">
                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>

                            <!-- Row -->
                            <ValidationProvider
                                tag="div"
                                name="phone"
                                rules="required"
                                class="form__fieldWrapper display-flex flex-wrap cell small-12"
                                v-slot="{ classes, errors }"
                            >
                                <div
                                    class="control w-100 relative"
                                    :class="classes"
                                >
                                    <input
                                        name="phone"
                                        v-model="submission.phone"
                                        placeholder="Phone Number"
                                        type="text"
                                        autocomplete="tel"
                                    />

                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="phone"
                                        >Phone Number</label
                                    >
                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>

                            <!-- Row -->
                            <ValidationProvider
                                tag="div"
                                name="email"
                                rules="required|email"
                                class="form__fieldWrapper display-flex flex-wrap cell small-12"
                                v-slot="{ classes, errors }"
                                v-if="
                                    user.has_email === 0 ||
                                        user.has_email === false
                                "
                            >
                                <div
                                    class="control w-100 relative"
                                    :class="classes"
                                >
                                    <input
                                        name="email"
                                        v-model.trim="user.email"
                                        placeholder="Email Address"
                                        type="email"
                                        autocomplete="email"
                                    />

                                    <label
                                        class="form__label display-block visuallyhidden"
                                        for="email"
                                        >Email Address</label
                                    >
                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>

                            <!-- Row -->
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

                            <!-- Row -->
                            <ValidationProvider
                                tag="div"
                                rules="required:true"
                                class="form__fieldWrapper display-flex flex-wrap cell small-12"
                                v-slot="{ classes, errors }"
                            >
                                <div
                                    class="control w-100 relative mt-3 mb-5"
                                    :class="classes"
                                >
                                    <input
                                        id="disclosure"
                                        name="disclosure"
                                        type="checkbox"
                                        class="visuallyhidden"
                                        @change="
                                            disclosureCheckboxClick($event)
                                        "
                                        v-model="
                                            submission.accept_bankruptcy_disclosure
                                        "
                                    />

                                    <label
                                        class="form__label display-flex weight-bold cursor-pointer"
                                        for="disclosure"
                                    >
                                        <div
                                            class="form__checkboxWrapper relative mr-1"
                                        >
                                            <img
                                                svg-inline
                                                src="@img/svg/checkbox.svg"
                                            />
                                            <img
                                                svg-inline
                                                src="@img/svg/checked.svg"
                                            />
                                        </div>
                                        <span
                                            class="text-20 weight-500 text-gray"
                                            >I accept the
                                            <button
                                                type="button"
                                                class="weight-bold text-secondary underline text-20 hover:primary"
                                                data-toggle="disclosure-modal"
                                            >
                                                Disclosure
                                            </button></span
                                        >
                                    </label>
                                    <p class="errors-wrapper">
                                        {{ errors[0] }}
                                    </p>
                                </div>
                            </ValidationProvider>
                            <div
                                class="form__fieldWrapper display-flex flex-wrap cell small-12 error-bankruptcy"
                            >
                                <p
                                    class="errors-wrapper"
                                    v-if="bankruptcyStateError"
                                >
                                    Sorry! We do not currently provide
                                    bankruptcy counseling in your state. Please
                                    check back again in the future
                                </p>
                            </div>
                        </div>

                        <div
                            class="form__fieldWrapper display-flex flex-wrap cell shrink"
                        >
                            <div class="grid-x grid-margin-x mb-4">
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
                            <div class="w-100">
                                <back-button></back-button>
                            </div>
                        </div>
                    </ValidationObserver>
                    <div
                        v-if="message"
                        class="alert text-error my-3 weight-500 text-20"
                    >
                        {{ message }}
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import api from "@/api";
import tippy from "tippy.js";
import { mapGetters } from "vuex";
export default {
    name: "SubmissionBankruptcyWelcome",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false,
            bankruptcyStateError: false
        };
    },
    computed: {},
    methods: {
        disclosureCheckboxClick(e) {
            if (!this.submission.accept_bankruptcy_disclosure)
                localStorage.removeItem("bankruptcy-timer-ms-remaining");
        },

        async onSubmit($event) {
            let userCreationError = false;

            if (
                this.submission.state === "Alabama" ||
                this.submission.state === "North Carolina"
            ) {
                this.bankruptcyStateError = true;
                return;
            } else {
                this.bankruptcyStateError = false;
            }

            const isValid = await this.$refs.observer.validate();

            await this.$recaptchaLoaded();
            const token = await this.$recaptcha("login");
            let formData = new FormData();

            // User account already exists, so just update
            if (
                this.user.id &&
                this.submission.first_name &&
                this.submission.last_name &&
                isValid
            ) {
                this.user.recaptcha_token = token;
                api.users
                    .update(this.user.id, this.user)
                    .then(response => {})
                    .catch(error => {
                        userCreationError = true;
                        if (error.response.data.errors.recaptcha_token)
                            this.message = "Recaptcha validation error";
                        else
                            this.message =
                                error.response.data.message ||
                                "There was an issue creating a submission for this user.";
                    });

                api.submissions
                    .update(this.submission.id, this.submission)
                    .then(response => {});
            }
            // User account doesn't exist, so create an account
            else if (
                this.user.email &&
                this.user.password &&
                this.submission.first_name &&
                this.submission.last_name &&
                isValid
            ) {
                // Create new user
                formData.append("recaptcha_token", token);
                formData.append("email", this.user.email);
                formData.append("has_email", this.user.has_email);
                formData.append("has_password", this.user.has_password);
                formData.append("password", this.user.password);
                await api.users
                    .create(formData)
                    .then(response => {
                        localStorage.setItem("has_password", "true");
                        this.login = response.data.url;
                        this.user.id = response.data.id;
                        localStorage.setItem("jwt", response.data.access_token);

                        // @IMPORTANT: Temporary localhost to bypass CORS
                        let url = new URL(this.login);
                        //url.port = 9999;

                        // password-less login
                        axios.get(url).then(response => {
                            this.$store.dispatch("users/getUser");

                            this.submission.user_id = this.user.id;

                            api.submissions
                                .create(this.submission)
                                .then(response => {
                                    api.infusionsoft.addClientTag({
                                        id: response.data.id
                                    });
                                    this.$store.dispatch("users/getUser");
                                    this.$store.dispatch(
                                        "submissions/getSubmission"
                                    );
                                })
                                .catch(error => {
                                    this.message =
                                        error.response.data.message ||
                                        "There was an issue creating a submission for this user.";
                                });
                        });
                    })
                    .catch(error => {
                        userCreationError = true;
                        if (error.response.data.errors.recaptcha_token)
                            this.message = "Recaptcha validation error";
                        else if (
                            error.response.data.errors.email &&
                            error.response.data.errors.email[0] ==
                                "The email has already been taken."
                        ) {
                            this.message = "User already exists, please login.";
                        } else
                            this.message =
                                error.response.data.message ||
                                "There was an issue creating a submission for this user.";
                    });
            } else {
            }

            // @TODO find a DRY way to do this / other verifications?
            if (
                isValid &&
                this.submission.accept_bankruptcy_disclosure === true &&
                !userCreationError
            ) {
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
            }
        }
    },
    mounted() {
        const tooltip1 = document.getElementById("zip-tooltip");
        const eoustTooltip = document.getElementById("eoust-tooltip");
        const commonSettings = {
            allowHTML: true,
            offset: [-5, 50],

            delay: [null, 150],
            arrow: true
        };
        const tooltip1Settings = {
            content: `<div class="tooltip relative">

                Your address is required by Experian to pull your credit report.
                <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
            </div>`,
            placement: "right"
        };

        const eoustTooltipSettings = {
            content: `<div class="tooltip relative">
          Approved to issue certificates in compliance with the Bankruptcy Code. Approval does not endorse or assure the quality of an Agency's services.
          <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
          </div>`,
            placement: "right",
            offset: [-5, 15]
        };

        tippy(tooltip1, {
            ...commonSettings,
            ...tooltip1Settings
        });

        tippy(eoustTooltip, {
            ...commonSettings,
            ...eoustTooltipSettings
        });
    }
};
</script>
<style>
.error-bankruptcy {
    margin-bottom: 4rem !important;
}
</style>
