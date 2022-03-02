import Vue from "vue";
import App from "./views/App.vue";
import router from "./router.js";
import store from "./store";
import Ziggy from "ziggy";
import Vue2Filters from "vue2-filters";
import VueResource from "vue-resource";
import VueFilterDateParse from "@vuejs-community/vue-filter-date-parse";
import VueFilterDateFormat from "@vuejs-community/vue-filter-date-format";
import { VueReCaptcha } from "vue-recaptcha-v3";
import api from "./api";
import VueGtm from "vue-gtm";

import {
    ValidationProvider,
    ValidationObserver,
    configure,
    extend,
    validate
} from "vee-validate";

import { required, email, oneOf, numeric, min } from "vee-validate/dist/rules";

import { steps } from "./steps";

import { mapMutations, mapGetters } from "vuex";

Vue.use(VueResource);
Vue.use(VueFilterDateParse);
Vue.use(Vue2Filters);
Vue.use(VueFilterDateFormat);
Vue.use(VueReCaptcha, {
    siteKey: "6LebRdcZAAAAANnge4hXqzVFi1NR51vFrn4e0-tq",
    loaderOptions: {
        autoHideBadge: false
    }
});

Vue.use(VueGtm, {
    id: "GTM-KFF7SQ4",
    defer: false, // defaults to false. Script can be set to `defer` to increase page-load-time at the cost of less accurate results (in case visitor leaves before script is loaded, which is unlikely but possible)
    enabled: true, // defaults to true. Plugin can be disabled by setting this to false for Ex: enabled: !!GDPR_Cookie (optional)
    debug: true, // Whether or not display console logs debugs (optional)
    loadScript: true, // Whether or not to load the GTM Script (Helpful if you are including GTM manually, but need the dataLayer functionality in your components) (optional)
    vueRouter: router, // Pass the router instance to automatically sync with router (optional)
    ignoredViews: [], // Don't trigger events for specified router names (case insensitive) (optional)
    trackOnNextTick: false // Whether or not call trackView in Vue.nextTick
});

// Add the required rule
extend("required", {
    ...required,
    message: "This field is required"
});

// Add the email rule
extend("email", {
    ...email,
    message: "This field must be a valid email"
});

extend("min", {
    ...min
});

extend("oneOf", {
    ...oneOf
});

extend("numeric", value => {
    if (value >= 1) {
        return true;
    } else {
        return "This field must be a number";
    }
});

extend("comment_length", value => {
    if (value.length <= 495) {
        return true;
    } else {
        return "Message must be less than 495 charcters";
    }
});

extend("verify_password", {
    validate: value => {
        var strongPasswordRegex = new RegExp(
            "^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})"
        );
        return strongPasswordRegex.test(value);
    },
    message: `The password must contain 8 or more characters, using letters, numbers, and symbols.`
});

extend("verify_ssn", {
    validate: value => {
        var ssnRegex = new RegExp(
            /^(?!(000))(\d{3}-?(?!(00))\d{2}-?(?!(0000))\d{4})$/
        );
        return ssnRegex.test(value);
    },
    message: `A valid social security number (SSN) is required.`
});

extend("verify_dob", {
    validate: value => {
        return moment(value, "MM/DD/YYYY", true).isValid();
    },
    message: `A valid date of birth is required.`
});

extend("verify_phone", {
    //must be 10 digits only
    validate: value => {
        return value.length==10 && !/\D/.test(value);
    },
    message: `Phone number must be 10 digits (no dashes).`
});

configure({
    classes: {
        valid: "is-valid",
        invalid: "is-invalid"
    }
});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = Vue;

window.axios = require("axios");

import BackButton from "@components/BackButton.vue";
import BankruptcyTimer from "@components/BankruptcyTimer.vue";
import BankruptcyVideoSection from "@components/BankruptcyVideoSection.vue";
import BottomBar from "@components/BottomBar.vue";
import CategoryBlock from "@components/CategoryBlock.vue";
import CompletedSubmission from "@components/CompletedSubmission.vue";
import ContinueSkipButtons from "@components/ContinueSkipButtons.vue";
import CreateAccountModal from "@components/CreateAccountModal.vue";
import DisclosureModal from "@components/DisclosureModal.vue";
import ForgotPasswordForm from "@components/ForgotPasswordForm.vue";
import LoginModal from "@components/LoginModal.vue";
import ProgressNav from "@components/ProgressNav.vue";
import QuestionsIris from "@components/QuestionsIris.vue";
import ResetPasswordForm from "@components/ResetPasswordForm.vue";
import SubstepsNav from "@components/SubstepsNav.vue";

Vue.component("back-button", BackButton);
Vue.component("bankruptcy-timer", BankruptcyTimer);
Vue.component("bankruptcy-video-section", BankruptcyVideoSection);
Vue.component("bottom-bar", BottomBar);
Vue.component("category-block", CategoryBlock);
Vue.component("completed-submission", CompletedSubmission);
Vue.component("continue-skip-buttons", ContinueSkipButtons);
Vue.component("create-account-modal", CreateAccountModal);
Vue.component("disclosure-modal", DisclosureModal);
Vue.component("forgot-password-form", ForgotPasswordForm);
Vue.component("login-modal", LoginModal);
Vue.component("questions-iris", QuestionsIris);
Vue.component("reset-password-form", ResetPasswordForm);
Vue.component("progress-nav", ProgressNav);
Vue.component("substeps-nav", SubstepsNav);

// vee-validate
Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
        getCurrentStepObject(steps, routeName) {
            let step = steps.filter(obj => {
                return routeName === obj.name;
            });

            if (step && step[0]) {
                return step[0];
            }

            return false;
        }
    },
    computed: {
        ...mapGetters({
            user: "users/user",
            submission: "submissions/submission",
            submission_reasons: "submissions/submission_reasons",

            us_states: "us_states/us_states",

            steps: "steps/steps",
            current_step: "steps/current_step",
            previous_step: "steps/previous_step",
            next_step: "steps/next_step",
            enabled_steps: "steps/enabled_steps",
            disabled_steps: "steps/disabled_steps",
            completed_steps: "steps/completed_steps",
            progress: "steps/progress",

            credit_account: "credit_accounts/credit_account",
            credit_accounts: "credit_accounts/credit_accounts",
            credit_account_debt_types:
                "credit_accounts/credit_account_debt_types",

            expenses: "expenses/expenses",
            expense: "expenses/expense",
            expense_categories: "expenses/expense_categories",
            expense_types: "expenses/expense_types",
            enabled_expense_categories: "expenses/enabled_expense_categories",
            filtered_expense_types: "expenses/filtered_expense_types",
            filtered_expenses: "expenses/filtered_expenses",
            current_expense_category: "expenses/current_expense_category",
            filtered_expense_types_names:
                "expenses/filtered_expense_types_names",
            next_expense_category: "expenses/next_expense_category",
            previous_expense_category: "expenses/previous_expense_category",

            incomes: "incomes/incomes",
            income: "incomes/income",
            income_types: "incomes/income_types"
        })
    }
});

// Converts a string to a 'slug', with optional prepend/append values
// value | parameterize('prepend', 'append');
Vue.filter("parameterize", function(value, prepend = "", append = "") {
    return (
        prepend +
        value
            .toLowerCase()
            .replace(/[^\w ]+/g, "")
            .replace(/ +/g, "-") +
        append
    );
});

Vue.filter("dollarize", function(value, localeStringSettings) {
    if (localeStringSettings === null || localeStringSettings === undefined) {
        localeStringSettings = {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        };
    }
    return Number(value).toLocaleString("en", localeStringSettings);
});

/**
 * Vue filter to round the decimal to the given place.
 *
 * @param {String} value    The value string.
 * @param {Number} decimals The number of decimal places.
 */
Vue.filter("round", function(value, decimals) {
    if (!value) {
        value = 0;
    }

    if (!decimals) {
        decimals = 0;
    }

    value = Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals);
    return value;
});

/**
 * Vue filter to convert the given value to whole dollars, no change.
 *
 * @param {String} value The value string.
 */
Vue.filter("no-change", function(value, symbol) {
    if (!value) {
        value = 0;
    }

    if (!symbol) {
        symbol = "$";
    }

    value = value
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        .split(".")[0];
    return symbol + value;
});

// Set initial route (will be redirected to latest step if it exists)
router.replace("/");

function completeMilestone(id) {
    let milestone = document.getElementById(id);
    if (milestone) {
        milestone.classList.add("milestone--completed");
    }
}

async function checkMilestoneProgress() {
    axios.defaults.headers.common["Authorization"] =
        "Bearer " + localStorage.getItem("jwt");
    await axios
        .get("/api/user", {
            Authorization: "Bearer " + localStorage.getItem("jwt")
        })
        .then(response => {
            let submission = response.data.submission;
            let creditAccounts = response.data.creditAccounts;
            let expenses = response.data.expenses;
            let files = response.data.files;

            if (submission.reason) {
                completeMilestone("milestone-getting-started");
            }

            if (
                submission.first_name &&
                submission.last_name &&
                response.data.email
            ) {
                completeMilestone("milestone-getting-acquainted");
            }

            if (submission.income_dependents) {
                completeMilestone("milestone-income-dependents");
            }

            if (
                (submission.gross_employment_income &&
                    submission.net_employment_income) ||
                submission.self_employment_income ||
                submission.benefits_income ||
                submission.retirement_income ||
                submission.social_security_income ||
                submission.pension_income ||
                submission.other_income
            ) {
                completeMilestone("milestone-income-types");
            }

            // @TODO check how this should be handled with the automatic credit pull vs the manual debts
            if (
                (submission.ssn &&
                    submission.address_line_1 &&
                    submission.city &&
                    submission.state &&
                    submission.zip) ||
                creditAccounts.length > 0
            ) {
                completeMilestone("milestone-debts");
            }

            if (expenses.length > 0) {
                completeMilestone("milestone-expenses");
            }

            if (submission.phone && submission.message) {
                completeMilestone("milestone-additional-information");
            }
        })
        .catch(error => {
            if (submission.reason) {
                completeMilestone("milestone-getting-started");
            }

            if (submission.first_name && submission.last_name && user.email) {
                completeMilestone("milestone-getting-acquainted");
            }
        });
}

router.beforeResolve((to, from, next) => {
    const latestRouteName =
        localStorage.getItem("latest-step") || "SubmissionReason";

    const shouldRedirect = Boolean(
        (to.name === "Home" || to.name === "404") && latestRouteName
    );

    if (shouldRedirect) {
        next({
            name: latestRouteName
        });
    } else {
        next();
    }

    if (to.name === "PaymentApproved") {
        api.users.current().then(response => {
            if (!response.data.payment) {
                let array = new Uint32Array(20);
                window.crypto.getRandomValues(array);
                // Generating a UID, not sure if still part of tech requirements
                let uid = array.join("");

                api.payments
                    .create({
                        submission_id: response.data.submission.id,
                        uid: uid,
                        approved: true
                    })
                    .then(response => {
                        store.dispatch("steps/enableSteps", {
                            steps: store.state.steps.steps,
                            names: ["BankruptcyOverThreshold"]
                        });

                        store.dispatch("steps/completeStep", {
                            name: "BankruptcyIncomeThreshold",
                            steps: store.state.steps.steps
                        });

                        store.dispatch("steps/completeStep", {
                            name: "BankruptcyOverThreshold",
                            steps: store.state.steps.steps
                        });

                        store.dispatch(
                            "steps/updateCompletedSteps",
                            store.state.steps.steps
                        );
                        store.dispatch(
                            "steps/updateCompletedRequiredEnabledSteps",
                            store.state.steps.steps
                        );
                        store.dispatch(
                            "steps/updateIncompleteRequiredEnabledSteps",
                            store.state.steps.steps
                        );
                        store.dispatch(
                            "steps/updateStepsProgress",
                            store.state.steps.steps
                        );

                        next({
                            name: "BankruptcyBasics"
                        });
                    })
                    .catch(error => {
                        console.log("ERROR IS:");
                        console.log(error);
                    });
            } else {
                store.dispatch("steps/enableSteps", {
                    steps: store.state.steps.steps,
                    names: ["BankruptcyOverThreshold"]
                });

                store.dispatch("steps/completeStep", {
                    name: "BankruptcyIncomeThreshold",
                    steps: store.state.steps.steps
                });

                store.dispatch("steps/completeStep", {
                    name: "BankruptcyOverThreshold",
                    steps: store.state.steps.steps
                });

                store.dispatch(
                    "steps/updateCompletedSteps",
                    store.state.steps.steps
                );
                store.dispatch(
                    "steps/updateCompletedRequiredEnabledSteps",
                    store.state.steps.steps
                );
                store.dispatch(
                    "steps/updateIncompleteRequiredEnabledSteps",
                    store.state.steps.steps
                );
                store.dispatch("steps/updateStepsProgress", store.state.steps);

                next({
                    name: "BankruptcyBasics"
                });
            }
        });
    }
});

var firstLoad = true;

router.afterEach((to, from) => {
    // Remove classlist so green background is reverted if they go back a step
    document.documentElement.classList.remove("completed");

    store.dispatch("users/getUser");
    store.dispatch("submissions/getSubmission");

    if (localStorage.getItem("submission-type")) {
        completeMilestone("milestone-getting-started");
    }

    // Store latest step
    if (to.name !== "404" && to.name !== "Home") {
        localStorage.setItem("latest-step", to.name);
    } else {
        // Set to first step
        localStorage.setItem("latest-step", "SubmissionReason");
    }

    if (firstLoad === true) {
        firstLoad = false;
    } else {
        store.dispatch("steps/updateSteps", store.state.steps.steps);
        store.dispatch("steps/updateEnabledSteps", store.state.steps.steps);
        store.dispatch("steps/updateDisabledSteps", store.state.steps.steps);
        store.dispatch("steps/updateIncompleteSteps", store.state.steps.steps);
        store.dispatch("steps/updateCompletedSteps", store.state.steps.steps);
        store.dispatch(
            "steps/updateCompletedRequiredEnabledSteps",
            store.state.steps.steps
        );
        store.dispatch(
            "steps/updateIncompleteRequiredEnabledSteps",
            store.state.steps.steps
        );
        if (to.name)
            store.dispatch("steps/updateRelativeSteps", {
                steps: store.state.steps.steps,
                name: to.name
            });
        store.dispatch("steps/updateStepsProgress", store.state.steps);

        // Store the current steps namespace state
        localStorage.setItem(
            "steps-namespace",
            JSON.stringify(store.state.steps)
        );
    }

    checkMilestoneProgress();
});

const app = new Vue({
    el: "#app",
    router,
    store,
    mixins: [Vue2Filters.mixin],
    mounted: function() {
        // Restore previous steps namespace state, if loading the app again
        let savedStepsNamespace = JSON.parse(
            localStorage.getItem("steps-namespace")
        );
        if (savedStepsNamespace) {
            store.dispatch("steps/restoreStepsState", savedStepsNamespace);
        } else {
            // If no existing steps state, generate it
            store.dispatch("steps/updateSteps", steps);
            store.dispatch("steps/updateEnabledSteps", steps);
            store.dispatch("steps/updateDisabledSteps", steps);
            store.dispatch("steps/updateRelativeSteps", {
                steps: steps,
                name: this.$route.name
            });

            // Store the steps namespace state
            localStorage.setItem(
                "steps-namespace",
                JSON.stringify(store.state.steps)
            );
        }

        let submissionType = localStorage.getItem("submission-type");
        let storedTime = localStorage.getItem("bankruptcy-timer-ms-remaining");
        if (submissionType === "General" && storedTime) {
            localStorage.removeItem("bankruptcy-timer-ms-remaining");
        }

        store.dispatch("users/getUser");
        store.dispatch("submissions/getSubmission");

        // Get initial user data
        store.dispatch("expenses/getExpenses");
        store.dispatch("credit_accounts/getCreditAccounts");

        /*
            Grab "fixed" data from reference tables,
            which are currently generated using
            config values in /config/field_values
        */

        // Valid income types fetched from income_types table
        store.dispatch("incomes/getIncomeTypes");

        // Valid expense categories fetched from expense_categories table
        store.dispatch("expenses/getExpenseCategories");

        // Valid expense types fetched from expense_types table
        store.dispatch("expenses/getAllExpenseTypes");

        // Valid submission reasons from submission_reasons table
        store.dispatch("submissions/getSubmissionReasons");

        // Valid US states / their postal codes
        store.dispatch("us_states/getStates");

        // Valid credit account debt types
        store.dispatch("credit_accounts/getCreditAccountDebtTypes");

        checkMilestoneProgress();

        if (store.state.steps.progress) {
            document.documentElement.style.setProperty(
                "--progress",
                store.state.steps.progress + "%"
            );
        }
    },
    components: {
        app: App
    },
    computed: {},
    methods: {}
});
