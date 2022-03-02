<template>
    <section class="section pb-4">
        <div class="grid-container mt-2">
            <div
                class="grid-container grid-container--smaller text-center mb-8"
            >
                <img
                    svg-inline
                    src="@img/svg/reason-debt.svg"
                    class="text-center"
                />
                <h1 class="text-54 weight-100 text-darkGreen">
                    Now let's look at your debts.
                </h1>

                <p
                    class="font-book text-25 mb-4"
                    v-if="this.submission.reason == 'Debt'"
                >
                    Debt is a key driver of financial stress and can have a huge
                    impact on your financial health. Understanding your debts is
                    essential for us in creating an effective and productive
                    financial plan for you. By filling out the information
                    below, we can automatically pull your debts from your credit
                    report and provide information on a custom debt management
                    plan. Please know this is 100% safe, secure, and easy, and
                    this soft inquiry will not impact your credit score.
                </p>
                <p
                    class="font-book text-25 mb-4"
                    v-if="this.submission.reason != 'Debt'"
                >
                    Debt is a key driver of financial stress and can have a huge
                    impact on your financial health. Understanding your debts is
                    essential for us in creating an effective and productive
                    financial plan for you. By filling out the information
                    below, we can automatically pull your debts from your credit
                    report. Please know this is 100% safe, secure, and easy, and
                    this soft inquiry will not impact your credit score.
                </p>

                <button
                    class="text-17 weight-600 uppercase underline text-secondary"
                    @click="disableAutomaticEnableManual"
                >
                    Enter My Debts Manually
                </button>
            </div>

            <ValidationObserver
                tag="form"
                ref="observer"
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form form--debts mt-4 mx-auto"
            >
                <div
                    class="form__userInfo grid-x grid-margin-x grid-margin-y align-center"
                >
                    <ValidationProvider
                        tag="div"
                        rules="required|verify_ssn"
                        class="form__fieldWrapper display-flex flex-wrap cell small-12 relative"
                        v-slot="{ classes, errors }"
                    >
                        <div class="control w-100" :class="classes">
                            <input
                                name="ssn"
                                v-model="submission.ssn"
                                placeholder="Social Security Number"
                                type="password"
                                inputmode="numeric"
                                autocomplete="off"
                            />

                            <span
                                id="ssn-tooltip"
                                class="lh-1 ml-1 tooltip__helpIcon cursor-pointer tooltip__helpIcon--insideInput"
                                ><img
                                    svg-inline
                                    src="@img/svg/help.svg"
                                    class="fill-gray"
                            /></span>
                            <label
                                class="form__label display-block visuallyhidden"
                                for="ssn"
                                >Social Security Number</label
                            >
                            <p class="errors-wrapper">{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>

                    <!-- Row -->
                    <ValidationProvider
                        tag="div"
                        name="Address Line 1"
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
                            <p class="errors-wrapper">{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>

                    <ValidationProvider
                        tag="div"
                        class="form__fieldWrapper display-flex flex-wrap cell small-12 medium-4"
                        v-slot="{ classes, errors }"
                    >
                        <div class="control w-100" :class="classes">
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
                            <p class="errors-wrapper">{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>

                    <!-- Row -->
                    <ValidationProvider
                        tag="div"
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
                            <p class="errors-wrapper">{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>

                    <ValidationProvider
                        tag="div"
                        rules="required"
                        class="form__fieldWrapper form__fieldWrapper--state display-flex flex-wrap cell auto relative"
                        v-slot="{ classes, errors }"
                    >
                        <div class="control w-100" :class="classes">
                            <img
                                class="select-arrow"
                                svg-inline
                                src="@img/svg/arrow-down.svg"
                            />
                            <select name="state" v-model="submission.state">
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
                            <p class="errors-wrapper">{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>

                    <ValidationProvider
                        tag="div"
                        rules="required"
                        class="form__fieldWrapper form__fieldWrapper--zip form__fieldWrapper--37 display-flex flex-wrap relative"
                        v-slot="{ classes, errors }"
                    >
                        <div class="control w-100" :class="classes">
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
                            <p class="errors-wrapper">{{ errors[0] }}</p>
                        </div>
                    </ValidationProvider>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12"
                    >
                        <input
                            id="joint"
                            name="joint"
                            v-model="submission.joint_coapplicant"
                            type="checkbox"
                            class="visuallyhidden"
                        />

                        <label
                            class="form__label display-flex weight-bold cursor-pointer"
                            for="joint"
                        >
                            <div class="form__checkboxWrapper relative mr-1">
                                <img svg-inline src="@img/svg/checkbox.svg" />
                                <img svg-inline src="@img/svg/checked.svg" />
                            </div>
                            <span class="text-20 weight-500 text-gray"
                                >Some of my debts are joint</span
                            >
                        </label>
                    </div>
                </div>

                <div
                    class="form__userInfo form__userInfo--co grid-x grid-margin-x grid-margin-y align-center"
                    v-if="submission.joint_coapplicant"
                >
                    <div class="cell small-12">
                        <h2 class="text-25 weight-500 font-body text-gray mt-5">
                            Co-Applicant
                        </h2>
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12 medium-6"
                    >
                        <input
                            name="co_applicant_first_name"
                            v-model="submission.co_applicant_first_name"
                            placeholder="First Name"
                            type="text"
                            autocomplete="given-name"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_first_name"
                            >First Name</label
                        >
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12 medium-6"
                    >
                        <input
                            name="co_applicant_last_name"
                            v-model="submission.co_applicant_last_name"
                            placeholder="Last Name"
                            type="text"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_last_name"
                            >Last Name</label
                        >
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12"
                    >
                        <input
                            name="co_applicant_email"
                            v-model="submission.co_applicant_email"
                            placeholder="Email"
                            type="email"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_email"
                            >Email</label
                        >
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12"
                    >
                        <input
                            name="co_applicant_ssn"
                            v-model="submission.co_applicant_ssn"
                            placeholder="Social Security Number"
                            type="password"
                            inputmode="numeric"
                            minlength="9"
                            maxlength="12"
                            pattern="^(?!(000|666))(\d{3}-?(?!(00))\d{2}-?(?!(0000))\d{4})"
                            autocomplete="off"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_ssn"
                            >Social Security Number</label
                        >
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12 medium-9"
                    >
                        <input
                            name="co_applicant_address_line_1"
                            v-model="submission.co_applicant_address_line_1"
                            placeholder="Address Line 1"
                            type="text"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_address_line_1"
                            >Address Line 1</label
                        >
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12 medium-3"
                    >
                        <input
                            name="co_applicant_address_line_2"
                            v-model="submission.co_applicant_address_line_2"
                            placeholder="Apt #"
                            type="text"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_address_line_1"
                            >Apt #</label
                        >
                    </div>

                    <div
                        class="form__fieldWrapper--city form__fieldWrapper--37 display-flex flex-wrap"
                    >
                        <input
                            name="co_applicant_city"
                            v-model="submission.co_applicant_city"
                            placeholder="City"
                            type="text"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_city"
                            >City</label
                        >
                    </div>

                    <div
                        class="form__fieldWrapper form__fieldWrapper--state display-flex flex-wrap cell auto relative"
                    >
                        <img
                            class="select-arrow"
                            svg-inline
                            src="@img/svg/arrow-down.svg"
                        />
                        <select
                            name="state"
                            v-model="submission.co_applicant_state"
                        >
                            <option value="null" disabled hidden>State</option>
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

                    <div
                        class="form__fieldWrapper form__fieldWrapper--zip form__fieldWrapper--37 display-flex flex-wrap"
                    >
                        <input
                            name="co_applicant_zip"
                            v-model="submission.co_applicant_zip"
                            placeholder="Zip"
                            type="text"
                        />

                        <label
                            class="form__label display-block visuallyhidden"
                            for="co_applicant_zip"
                            >Zip</label
                        >
                    </div>
                </div>

                <div class="text-center mt-6">
                    <p class="text-18">
                        By entering the requested information above and clicking
                        continue, you affirm you are the individual(s) listed
                        above and authorize Apprisen to obtain a copy of your
                        credit report.
                    </p>
                </div>

                <div class="form__fieldWrapper cell small-12">
                    <div class="flex-center flex-wrap">
                        <continue-skip-buttons></continue-skip-buttons>

                        <div class="w-100 flex-center">
                            <back-button></back-button>
                        </div>
                    </div>
                </div>
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
import api from "@/api";
import tippy from "tippy.js";

export default {
    name: "SubmissionAutomaticDebts",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false,
            submitInProgress: false
        };
    },
    computed: {},
    methods: {
        disableAutomaticEnableManual() {
            // Enable the manual debts step
            this.$store.dispatch("steps/enableSteps", {
                steps: this.steps,
                name: this.$route.name,
                names: ["CreditAccountManualDebts"]
            });

            // Disable this step
            this.$store.dispatch("steps/disableSteps", {
                steps: this.steps,
                name: this.$route.name,
                names: [this.$route.name]
            });

            // Update steps to adjust for new enabled/disabled steps
            this.$store.dispatch("steps/updateSteps", this.steps);

            this.$router.push({
                name: "CreditAccountManualDebts"
            });
        },
        async onSubmit($event) {
            if (this.submitInProgress) return;

            const isValid = await this.$refs.observer.validate();

            if (
                this.submission.ssn &&
                this.submission.address_line_1 &&
                this.submission.city &&
                this.submission.state &&
                this.submission.zip &&
                isValid
            ) {
                if (this.submission.joint_coapplicant) {
                    // Check if the required joint fields are filled out
                    if (
                        this.submission.co_applicant_first_name &&
                        this.submission.co_applicant_last_name &&
                        this.submission.co_applicant_email &&
                        this.submission.co_applicant_ssn &&
                        this.submission.co_applicant_address_line_1 &&
                        this.submission.co_applicant_city &&
                        this.submission.co_applicant_state &&
                        this.submission.co_applicant_zip
                    ) {
                        this.submitInProgress = true;
                        await api.creditAccounts
                            .creditPull({
                                submission_id: this.submission.id,
                                first_name: this.submission.first_name,
                                last_name: this.submission.last_name,
                                ssn: this.submission.ssn,
                                addr1: this.submission.address_line_1,
                                addr2: this.submission.address_line_2,
                                city: this.submission.city,
                                state: this.submission.state,
                                zip: this.submission.zip,
                                coapplicant: false
                            })
                            .then(async response => {
                                this.submitInProgress = true;
                                await api.creditAccounts
                                    .creditPull({
                                        submission_id: this.submission.id,
                                        first_name: this.submission
                                            .co_applicant_first_name,
                                        last_name: this.submission
                                            .co_applicant_last_name,
                                        ssn: this.submission.co_applicant_ssn,
                                        addr1: this.submission
                                            .co_applicant_address_line_1,
                                        addr2: this.submission
                                            .co_applicant_address_line_2,
                                        city: this.submission.co_applicant_city,
                                        state: this.submission
                                            .co_applicant_state,
                                        zip: this.submission.co_applicant_zip,
                                        coapplicant: true
                                    })
                                    .then(response => {
                                        this.submitInProgress = false;
                                        this.disableAutomaticEnableManual();
                                        // All required fields are completed
                                        this.$store.dispatch(
                                            "steps/completeStep",
                                            {
                                                name: this.$route.name,
                                                steps: this.steps
                                            }
                                        );
                                        /*
                                        // Disable the manual debts step
                                        this.$store.dispatch(
                                            "steps/disableSteps",
                                            {
                                                steps: this.steps,
                                                name: this.$route.name,
                                                names: [
                                                    "CreditAccountManualDebts"
                                                ]
                                            }
                                        );
*/
                                        this.$store.dispatch(
                                            "submissions/updateSubmission",
                                            this.submission
                                        );

                                        // Update steps to adjust for new enabled/disabled steps
                                        this.$store.dispatch(
                                            "steps/updateSteps",
                                            this.steps
                                        );

                                        this.$store.dispatch(
                                            "steps/updateRelativeSteps",
                                            {
                                                steps: this.steps,
                                                name: this.$route.name
                                            }
                                        );
                                        this.$router.push({
                                            name: "CreditAccountManualDebts"
                                        });
                                    })
                                    .catch(error => {
                                        this.submitInProgress = false;
                                        console.log("credit pull error");
                                        console.log(error.response);
                                        console.log(error);
                                        if (error.response.data.message) {
                                            this.message =
                                                "Error trying to pull credit for co-app. " +
                                                error.response.data.message;
                                        } else if (
                                            typeof error.response.data ===
                                            "object"
                                        ) {
                                            this.message = "";
                                            let errMsgs = _.toArray(
                                                error.response.data.errors
                                            );
                                            errMsgs.forEach(element => {
                                                this.message +=
                                                    element.message + "\n";
                                            });
                                        } else
                                            this.message =
                                                "Error trying to pull credit.";
                                    });
                            })
                            .catch(error => {
                                this.submitInProgress = false;
                                console.log("credit pull error");
                                console.log(error.response);
                                console.log(error);
                                if (error.response.data.message) {
                                    this.message =
                                        "Error trying to pull credit. " +
                                        error.response.data.message;
                                } else if (
                                    typeof error.response.data === "object"
                                ) {
                                    this.message = "";
                                    let errMsgs = _.toArray(
                                        error.response.data.errors
                                    );
                                    errMsgs.forEach(element => {
                                        this.message += element.message + "\n";
                                    });
                                } else
                                    this.message =
                                        "Error trying to pull credit.";
                            });
                    } else {
                        this.submitInProgress = false;
                        this.message =
                            "You need to fill out the required co-applicant fields.";
                    }
                } else {
                    this.submitInProgress = true;
                    await api.creditAccounts
                        .creditPull({
                            submission_id: this.submission.id,
                            first_name: this.submission.first_name,
                            last_name: this.submission.last_name,
                            ssn: this.submission.ssn,
                            addr1: this.submission.address_line_1,
                            addr2: this.submission.address_line_2,
                            city: this.submission.city,
                            state: this.submission.state,
                            zip: this.submission.zip,
                            coapplicant: false
                        })
                        .then(response => {
                            this.submitInProgress = false;
                            this.$store.dispatch(
                                "submissions/updateSubmission",
                                this.submission
                            );

                            this.disableAutomaticEnableManual();
                            // Complete step / update progress / update submission / go to next step
                            this.$store.dispatch("steps/completeStep", {
                                name: this.$route.name,
                                steps: this.steps
                            });

                            // Update steps to adjust for new enabled/disabled steps
                            this.$store.dispatch(
                                "steps/updateSteps",
                                this.steps
                            );

                            this.$store.dispatch("steps/updateRelativeSteps", {
                                steps: this.steps,
                                name: this.$route.name
                            });
                            this.$router.push({
                                name: "CreditAccountManualDebts"
                            });
                        })
                        .catch(error => {
                            this.submitInProgress = false;
                            console.log("credit pull error");
                            console.log(error.response);
                            console.log(error);
                            if (error.response.data.message) {
                                this.message =
                                    "Error trying to pull credit. " +
                                    error.response.data.message;
                            } else if (
                                typeof error.response.data === "object"
                            ) {
                                this.message = "";
                                let errMsgs = _.toArray(
                                    error.response.data.errors
                                );
                                errMsgs.forEach(element => {
                                    this.message += element.message + "\n";
                                });
                            } else
                                this.message = "Error trying to pull credit.";
                        });
                }
            } else {
                this.submitInProgress = false;
                if (this.submission.joint_coapplicant) {
                    this.message =
                        "You need to fill out the required applicant and co-applicant fields.";
                } else {
                    this.message =
                        "You need to fill out the required applicant fields.";
                }
            }
        }
    },
    mounted() {
        if (
            this.submission.co_applicant_first_name ||
            this.submission.co_applicant_last_name ||
            this.submission.co_applicant_email
        ) {
            // Reveal co-applicant half of form
            this.submission.joint_coapplicant = true;
        }

        const tooltip1 = document.getElementById("ssn-tooltip");
        const tooltip2 = document.getElementById("zip-tooltip");

        const commonSettings = {
            allowHTML: true,
            offset: [-5, 50],

            delay: [null, 150],
            arrow: true
        };

        const tooltip1Settings = {
            content: `<div class="tooltip relative">

                Your Social Security Number is required to pull your credit report. By providing your SSN here, you are authorizing us to pull your credit report.
                <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
            </div>`,
            placement: "right-start"
        };

        const tooltip2Settings = {
            content: `<div class="tooltip relative">

                Your address is required by Experian to pull your credit report.
                <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
            </div>`,
            placement: "right"
        };

        tippy(tooltip1, {
            ...commonSettings,
            ...tooltip1Settings
        });

        tippy(tooltip2, {
            ...commonSettings,
            ...tooltip2Settings
        });
    }
};
</script>
