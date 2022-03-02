<template>
    <section class="section pb-4">
        <div class="grid-container mt-2">
            <div class="grid-container grid-container--smaller text-center">
                <img svg-inline src="@img/svg/reason-debt.svg" />
                <h1
                    v-if="submission.credit_pull"
                    class="text-54 weight-100 text-darkGreen"
                >
                    Review Your Debts.
                </h1>
                <h1 v-else class="text-54 weight-100 text-darkGreen">
                    Manually enter your debts.
                </h1>

                <p v-if="submission.credit_pull" class="font-book text-25">
                    We’ve automatically pulled your debts based on the
                    information you provided us. Please review the debts listed
                    below and, if needed, manually edit any information or add
                    any debts that may have been missed. If everything looks
                    good, click Continue to move on to the next step!
                </p>
                <p v-else class="font-book text-25">
                    You’ve chosen to manually enter in each of your debts. If
                    you’d rather, we can safely and securely access our debts
                    automatically. You can click “automatically pull my debt”
                    and we’ll get right to it!
                </p>

                <button
                    v-if="!this.submission.credit_pull"
                    class="text-17 weight-600 uppercase underline text-secondary"
                    @click="disableManualEnableAutomatic"
                >
                    Automatically pull my debts
                </button>
            </div>

            <ValidationObserver
                tag="form"
                ref="observer"
                id="submission-form"
                method="POST"
                @submit.prevent="onSubmit($event)"
                class="form mt-4 w-auto grid-x grid-margin-y"
            >
                <div class="form__grid grid-x grid-margin-x grid-margin-y">
                    <div
                        class="cell small-12 grid-x grid-margin-x grid-margin-y pr-3--large"
                        v-if="!submission.credit_pull"
                    >
                        <ValidationProvider
                            tag="div"
                            rules="required|verify_ssn"
                            class="form__fieldWrapper cell small-12 medium-6 relative"
                            v-slot="{ classes, errors }"
                        >
                            <div class="control mb-4" :class="classes">
                                <label
                                    class="form__label display-block"
                                    for="ssn"
                                    >Social Security Number</label
                                >
                                <div class="relative">
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
                                </div>
                                <p class="errors-wrapper">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>

                        <ValidationProvider
                            tag="div"
                            rules="required|verify_dob"
                            class="form__fieldWrapper cell small-12 medium-6 relative"
                            v-slot="{ classes, errors }"
                        >
                            <div class="control mb-6" :class="classes">
                                <label
                                    class="form__label display-block"
                                    for="dob"
                                    >Date of Birth</label
                                >
                                <input
                                    name="dob"
                                    v-model="submission.date_of_birth"
                                    placeholder="Date of Birth mm/dd/yyyy"
                                    type="text"
                                    autocomplete="off"
                                    onkeyup="this.value=this.value.replace(/^(\d\d)(\d)$/g,'$1/$2').replace(/^(\d\d\/\d\d)(\d+)$/g,'$1/$2').replace(/[^\d\/]/g,'')"
                                />

                                <p class="errors-wrapper">{{ errors[0] }}</p>
                            </div>
                        </ValidationProvider>
                    </div>

                    <!-- Dynamic Rows -->
                    <div
                        class="grid-x grid-margin-x grid-margin-y cell small-11 large-12 relative"
                        v-for="(account, i) in credit_accounts"
                        :key="account.id"
                    >
                        <div
                            class="form__fieldWrapper form__fieldWrapper--manualDebtsSelect display-flex flex-wrap relative"
                        >
                            <img
                                class="select-arrow"
                                svg-inline
                                src="@img/svg/arrow-down.svg"
                            />
                            <select
                                name="debt_type"
                                v-model="credit_accounts[i].debt_type"
                            >
                                <option value="null" disabled hidden
                                    >Debt Type</option
                                >
                                <option
                                    v-for="debt_type in credit_account_debt_types"
                                    :key="debt_type.id"
                                    >{{ debt_type.debt_type }}</option
                                >
                            </select>

                            <label
                                class="form__label display-block visuallyhidden"
                                for="debt_type"
                                >Debt Type</label
                            >
                        </div>

                        <div
                            class="form__fieldWrapper form__fieldWrapper--19 display-flex flex-wrap"
                        >
                            <input
                                name="creditor"
                                v-model="credit_accounts[i].creditor"
                                placeholder="Lender Name"
                                type="text"
                            />

                            <label
                                class="form__label display-block visuallyhidden"
                                for="creditor"
                                >Lender Name</label
                            >
                        </div>

                        <div
                            class="form__fieldWrapper form__fieldWrapper--17 display-flex flex-wrap"
                        >
                            <input
                                name="account_number"
                                v-model="credit_accounts[i].account_number"
                                placeholder="Account Number"
                                type="text"
                            />

                            <label
                                class="form__label display-block visuallyhidden"
                                for="account_number"
                                >Account Number</label
                            >
                        </div>

                        <div
                            class="form__fieldWrapper form__fieldWrapper--17 display-flex flex-wrap"
                        >
                            <input
                                name="monthly_payment"
                                v-model="credit_accounts[i].monthly_payment"
                                placeholder="Monthly Payment"
                                type="text"
                            />

                            <label
                                class="form__label display-block visuallyhidden"
                                for="monthly_payment"
                                >Monthly Payment</label
                            >
                        </div>

                        <div
                            class="form__fieldWrapper form__fieldWrapper--8 display-flex flex-wrap"
                        >
                            <input
                                name="interest_rate"
                                v-model="credit_accounts[i].interest_rate"
                                placeholder="APR"
                                type="text"
                            />

                            <label
                                class="form__label display-block visuallyhidden"
                                for="interest_rate"
                                >APR</label
                            >
                        </div>

                        <div
                            class="form__fieldWrapper form__fieldWrapper--14 display-flex flex-wrap"
                        >
                            <input
                                name="balance_owed"
                                v-model="credit_accounts[i].balance_owed"
                                placeholder="Debt Balance"
                                type="text"
                            />

                            <label
                                class="form__label display-block visuallyhidden"
                                for="balance_owed"
                                >Debt Balance</label
                            >
                        </div>

                        <div
                            :id="'delete-row-' + account.id"
                            class="form__fieldWrapper form__fieldWrapper--deleteRowButtonWrapper cell shrink flex-center"
                        >
                            <button
                                type="button"
                                class=""
                                @click="deleteRowFromDB($event, account.id)"
                            >
                                <img
                                    svg-inline
                                    src="@img/svg/close.svg"
                                    class="fill-primary"
                                />
                            </button>
                        </div>

                        <div
                            class="form__fieldWrapper display-flex flex-wrap cell small-12"
                        >
                            <input
                                :id="'pastDue-' + account.id"
                                name="past_due"
                                v-model="credit_accounts[i].past_due"
                                type="checkbox"
                                class="visuallyhidden"
                            />

                            <label
                                class="form__label display-flex weight-bold cursor-pointer"
                                :for="'pastDue-' + account.id"
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
                                <span class="text-20 weight-500 text-gray"
                                    >This debt is past due</span
                                >
                            </label>
                        </div>
                    </div>

                    <!-- Static input row -->
                    <div
                        class="grid-x grid-margin-x grid-margin-y cell small-12 relative"
                        v-if="credit_account"
                    >
                        <div
                            class="form__fieldWrapper form__fieldWrapper--manualDebtsSelect display-flex flex-wrap relative"
                        >
                            <img
                                class="select-arrow"
                                svg-inline
                                src="@img/svg/arrow-down.svg"
                            />
                            <select
                                name="debt_type"
                                v-model="credit_account.debt_type"
                            >
                                <option value="null" disabled hidden
                                    >Debt Type</option
                                >
                                <option
                                    v-for="debt_type in credit_account_debt_types"
                                    :key="debt_type.id"
                                    >{{ debt_type.debt_type }}</option
                                >
                            </select>

                            <label
                                class="form__label display-block visuallyhidden"
                                for="debt_type"
                                >Debt Type</label
                            >
                        </div>

                        <ValidationProvider
                            tag="div"
                            name="creditor"
                            rules="required"
                            class="form__fieldWrapper form__fieldWrapper--19 display-flex flex-wrap"
                            v-slot="{ classes, errors }"
                        >
                            <div class="control w-100" :class="classes">
                                <input
                                    name="creditor"
                                    v-model="credit_account.creditor"
                                    placeholder="Lender Name"
                                    type="text"
                                />

                                <label
                                    class="form__label display-block visuallyhidden"
                                    for="creditor"
                                    >Lender Name</label
                                >
                                <p class="errors-wrapper">
                                    {{ errors[0] }}
                                </p>
                            </div>
                        </ValidationProvider>

                        <div
                            class="form__fieldWrapper form__fieldWrapper--17 display-flex flex-wrap"
                        >
                            <input
                                name="account_number"
                                v-model="credit_account.account_number"
                                placeholder="Account Number"
                                type="text"
                            />

                            <label
                                class="form__label display-block visuallyhidden"
                                for="account_number"
                                >Account Number</label
                            >
                        </div>

                        <ValidationProvider
                            tag="div"
                            name="monthly_payment"
                            rules="required|numeric"
                            class="form__fieldWrapper form__fieldWrapper--17 display-flex flex-wrap"
                            v-slot="{ classes, errors }"
                        >
                            <div class="control w-100" :class="classes">
                                <input
                                    name="monthly_payment"
                                    v-model="credit_account.monthly_payment"
                                    placeholder="Monthly Payment"
                                    type="text"
                                />

                                <label
                                    class="form__label display-block visuallyhidden"
                                    for="monthly_payment"
                                    >Monthly Payment</label
                                >
                                <p class="errors-wrapper">
                                    {{ errors[0] }}
                                </p>
                            </div>
                        </ValidationProvider>

                        <div
                            class="form__fieldWrapper form__fieldWrapper--8 display-flex flex-wrap"
                        >
                            <input
                                name="interest_rate"
                                v-model="credit_account.interest_rate"
                                placeholder="APR"
                                type="text"
                            />

                            <label
                                class="form__label display-block visuallyhidden"
                                for="interest_rate"
                                >APR</label
                            >
                        </div>

                        <ValidationProvider
                            tag="div"
                            name="balance_owed"
                            rules="required|numeric"
                            class="form__fieldWrapper form__fieldWrapper--14 display-flex flex-wrap"
                            v-slot="{ classes, errors }"
                        >
                            <div class="control w-100" :class="classes">
                                <input
                                    name="balance_owed"
                                    v-model="credit_account.balance_owed"
                                    placeholder="Debt Balance"
                                    type="text"
                                />

                                <label
                                    class="form__label display-block visuallyhidden"
                                    for="balance_owed"
                                    >Debt Balance</label
                                >
                                <p class="errors-wrapper">
                                    {{ errors[0] }}
                                </p>
                            </div>
                        </ValidationProvider>

                        <div
                            class="form__fieldWrapper display-flex flex-wrap cell small-12"
                        >
                            <input
                                id="pastDue"
                                name="past_due"
                                v-model="credit_account.past_due"
                                type="checkbox"
                                class="visuallyhidden"
                            />

                            <label
                                class="form__label display-flex weight-bold cursor-pointer"
                                for="pastDue"
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
                                <span class="text-20 weight-500 text-gray"
                                    >This debt is past due</span
                                >
                            </label>
                        </div>
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12"
                    >
                        <button
                            value="submit"
                            name="submit"
                            type="submit"
                            class="button button--hollow mt-4"
                        >
                            Add Another Debt
                        </button>
                    </div>

                    <div
                        class="form__fieldWrapper display-flex flex-wrap cell small-12"
                    >
                        <div class="button-group mt-8 flex-center">
                            <button
                                type="button"
                                class="button button--hollow button--stepNav cell shrink"
                                @click="
                                    $store.dispatch('steps/goToNextStep', {
                                        next_step: next_step
                                    })
                                "
                            >
                                Skip This Step
                            </button>
                            <button
                                value="submit"
                                name="submit"
                                type="button"
                                class="button button--stepNav cell shrink"
                                @click="updateAllCreditAccounts($event)"
                            >
                                Continue
                            </button>
                        </div>

                        <div class="w-100 text-center">
                            <back-button></back-button>
                        </div>
                    </div>
                </div>
            </ValidationObserver>
            <div
                v-if="message"
                class="alert text-error text-center my-3 weight-500 text-20"
            >
                <template v-for="line in message.split('\n')">
                    <p>{{ line }}</p>
                </template>
            </div>
        </div>
    </section>
</template>

<script>
import tippy from "tippy.js";
import { mapGetters } from "vuex";

import api from "@/api";

export default {
    name: "CreditAccountManualDebts",
    data: function() {
        return {
            message: null,
            loaded: false,
            saving: false
        };
    },
    computed: {},
    methods: {
        async updateAllCreditAccounts($event) {
            await this.addDebt();
            if (!this.credit_account.debt_type) {
                // Update credit accounts in case any changes were made
                if (this.credit_accounts && this.credit_accounts.length > 0) {
                    for (let i = 0; i < this.credit_accounts.length; i++) {
                        this.$store.dispatch(
                            "credit_accounts/updateCreditAccount",
                            this.credit_accounts[i]
                        );
                    }

                    this.$store.dispatch("steps/completeStep", {
                        name: this.$route.name,
                        steps: this.steps
                    });
                    this.$store.dispatch("steps/goToNextStep", {
                        next_step: this.next_step
                    });
                } else {
                    this.$store.dispatch("steps/completeStep", {
                        name: this.$route.name,
                        steps: this.steps
                    });
                    this.$store.dispatch("steps/goToNextStep", {
                        next_step: this.next_step
                    });
                }
            } else console.log("error adding item");
        },
        disableManualEnableAutomatic() {
            /*
            // Disable this step
            this.$store.dispatch("steps/disableSteps", {
                steps: this.steps,
                name: this.$route.name,
                names: ["CreditAccountManualDebts"]
            });

            // Enable the automatic debts step
            this.$store.dispatch("steps/enableSteps", {
                steps: this.steps,
                name: this.$route.name,
                names: ["SubmissionAutomaticDebts"]
            });

            // Update steps to adjust for new enabled/disabled steps
            this.$store.dispatch("steps/updateSteps", this.steps);
*/
            this.$router.push({
                name: "SubmissionAutomaticDebts"
            });
        },
        async onSubmit($event) {
            const isValid = await this.$refs.observer.validate();

            if (isValid) this.addDebt();
        },
        async addDebt() {
            if (!this.credit_account.debt_type) return;

            this.saving = true;
            this.message = false;

            this.credit_account.submission_id = this.submission.id;
            if (
                this.credit_account &&
                this.credit_account.submission_id &&
                this.credit_account.debt_type
            ) {
                await api.creditAccounts
                    .create(this.credit_account)
                    .then(response => {
                        this.credit_account.debt_type = null;
                        this.credit_account.creditor = null;
                        this.credit_account.account_number = null;
                        this.credit_account.monthly_payment = null;
                        this.credit_account.interest_rate = null;
                        this.credit_account.balance_owed = null;
                        this.credit_account.past_due = false;

                        // Refresh the list of credit accounts
                        this.$store.dispatch(
                            "credit_accounts/getCreditAccounts"
                        );

                        this.$store.dispatch("users/getUser");

                        // Disable the automatic debts step
                        this.$store.dispatch("steps/disableSteps", {
                            steps: this.steps,
                            name: this.$route.name,
                            names: ["SubmissionAutomaticDebts"]
                        });

                        // Update steps to adjust for new enabled/disabled steps
                        this.$store.dispatch("steps/updateSteps", this.steps);

                        this.$store.dispatch("steps/updateRelativeSteps", {
                            steps: this.steps,
                            name: this.$route.name
                        });

                        // At least one debt was added
                        this.$store.dispatch("steps/completeStep", {
                            name: this.$route.name,
                            steps: this.steps
                        });

                        this.$store.dispatch(
                            "submissions/updateSubmission",
                            this.submission
                        );
                        this.$refs.observer.reset();
                    })
                    .catch(error => {
                        console.log("add account error");
                        if (typeof error.response.data === "object") {
                            this.message = "";
                            let errMsgs = _.toArray(error.response.data.errors);
                            errMsgs.forEach(element => {
                                this.message += element + "\n";
                            });
                        }
                        console.log(error);
                    });
            } else {
                console.log(
                    "ELSE THIS CREDIT ACCOUNT DOES NOT HAVE ENOUGH INFO????"
                );
                console.log(this.credit_accounts);
                // @TODO Replace with page notification
                // alert('Please fill out all details');
            }
        },
        async deleteRowFromDB($event, accountID) {
            // Refresh the list of credit accounts
            //this.$store.dispatch("credit_accounts/getCreditAccounts");
            await api.creditAccounts
                .all()
                .then(async response => {
                    let accounts = Object.values(response.data);
                    let creditAccount = accounts.filter(obj => {
                        return accountID === obj.id;
                    });
                    if (creditAccount && creditAccount[0]) {
                        await api.creditAccounts
                            .delete(creditAccount[0].id)
                            .then(response => {
                                // Refresh the list of credit accounts
                                this.$store.dispatch(
                                    "credit_accounts/getCreditAccounts"
                                );
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    mounted() {
        const tooltip1 = document.getElementById("ssn-tooltip");

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

        tippy(tooltip1, {
            ...commonSettings,
            ...tooltip1Settings
        });

        this.$store.dispatch("credit_accounts/resetCreditAccount");
        this.$store.dispatch("credit_accounts/getCreditAccounts");

        api.creditAccounts
            .all()
            .then(response => {
                if (response.data && response.data.length > 0) {
                    // Disable the automatic debts step
                    this.$store.dispatch("steps/disableSteps", {
                        steps: this.steps,
                        name: this.$route.name,
                        names: ["SubmissionAutomaticDebts"]
                    });

                    // Update steps to adjust for new enabled/disabled steps
                    this.$store.dispatch("steps/updateSteps", this.steps);

                    this.$store.dispatch("steps/updateRelativeSteps", {
                        steps: this.steps,
                        name: this.$route.name
                    });

                    // At least one debt was added
                    this.$store.dispatch("steps/completeStep", {
                        name: this.$route.name,
                        steps: this.steps
                    });
                }
            })
            .catch(error => {
                console.log(error);
            });
    }
};
</script>

<style scoped>
.form .errors-wrapper {
    margin-bottom: 0 !important;
}
</style>
