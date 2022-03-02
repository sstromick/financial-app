<template>
    <div class="grid-container grid-container--large px-8">
        <div class="grid-x grid-margin-x">
            <!-- LEFT COLUMN -->
            <div class="cell small-12 medium-large-6 xlarge-5">
                <div class="mb-5">
                    <h1 class="">Anything else we should know?</h1>
                    <p class="text-25 font-book">
                        Do you have a specific financial goal in mind? Are there
                        special financial circumstances you have that we should
                        know about? Let us know below!
                    </p>

                    <ValidationObserver
                        tag="form"
                        ref="observer"
                        method="POST"
                        @submit.prevent="onSubmit($event)"
                        class="form mt-4 grid-x grid-margin-y"
                    >
                        <div
                            class="form__fieldWrapper display-flex flex-wrap cell small-12"
                        >
                            <ValidationProvider
                                tag="div"
                                name="message"
                                rules="required|comment_length"
                                class="form__fieldWrapper display-flex flex-wrap cell small-7"
                                v-slot="{ classes, errors }"
                            >
                                <div
                                            class="control w-100 relative"
                                            :class="classes"
                                        >
                                <textarea
                                    name="message"
                                    v-model="submission.message"
                                    v-on:keyup="countdown"
                                    placeholder="Anything else we should know?"
                                ></textarea>

                                <p class='text-right text-small' v-bind:class="{'text-danger': hasError }">{{remainingCount}}</p>

                                <label
                                    class="form__label display-block visuallyhidden"
                                    for="phone"
                                    >Phone Number</label
                                >
                                </div>
                                <p class="errors-wrapper">
                                    {{ errors[0] }}
                                </p>
                            </ValidationProvider>
                        </div>

                        <ValidationProvider
                            tag="div"
                            name="phone"
                            rules="required|verify_phone"
                            class="form__fieldWrapper display-flex flex-wrap cell small-7"
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

                        <div
                            class="form__fieldWrapper display-flex flex-wrap cell small-12"
                        >
                            <input
                                id="military"
                                name="military"
                                v-model="submission.military"
                                type="checkbox"
                                class="visuallyhidden"
                            />

                            <label
                                class="form__label display-flex weight-bold cursor-pointer"
                                for="military"
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
                                    class="text-20 weight-500 text-gray display-flex align-middle"
                                    >I am active military
                                    <span
                                        id="military-tooltip"
                                        class="display-flex align-middle ml-1"
                                        ><img
                                            svg-inline
                                            src="@img/svg/help.svg"
                                            class="fill-gray"/></span
                                ></span>
                            </label>
                        </div>

                        <div
                            v-if="!isBankruptcy"
                            class="form__fieldWrapper display-flex flex-wrap cell small-12"
                        >
                            <input
                                id="accept"
                                name="accept"
                                v-model="
                                    submission.accept_statement_of_counseling
                                "
                                type="checkbox"
                                class="visuallyhidden"
                                required
                            />

                            <label
                                class="form__label display-flex weight-bold cursor-pointer"
                                for="accept"
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
                                    class="text-20 weight-500 text-gray display-flex align-middle"
                                    >I accept&nbsp;<a href="/counseling" target="_blank" class="weight-600 underline text-primary ml-0"
>statement of counseling</a>
                                </span>
                            </label>
                        </div>

                        <div class="cell small-12">
                            <div
                                class="grid-x grid-margin-x grid-margin-y"
                            >
                                <div
                                    v-if="!allStepsDone"
                                    class="alert text-error my-3 weight-500 text-20"
                                >
                                <p>
                                    Please finish your application before submitting. Go back to
                                    complete any missing information. Incomplete steps are...
                                    <ul>
                                        <li v-for="is in incompleteSteps" :key="is.id">{{ is.name.replace(/([A-Z])/g, " $1").trim() }}</li>
                                    </ul>
                                </p>
                                </div>
                                <div class="cell shrink">
                                    <button
                                        :disabled="!allStepsDone || submitInProgress"
                                        value="submit"
                                        name="submit"
                                        type="submit"
                                        class="button button--stepNav relative"
                                        @submit.prevent="onSubmit($event)"
                                    >
                                        <div class="lds-ring-container" v-if="submitInProgress">
                                            <div class="lds-ring">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            </div>
                                        </div>
                                        Continue
                                    </button>
                                </div>

                                <div class="cell small-12">
                                    <button
                                        type="button"
                                        class="weight-600 underline uppercase text-17 text-primary"
                                        @click="
                                            $store.dispatch(
                                                'steps/goToPreviousStep',
                                                { previous_step: previous_step }
                                            )
                                        "
                                    >
                                        Back
                                    </button>
                                </div>
                                <div class="cell small-12">
                                    <div
                                        v-if="message"
                                        class="alert text-error weight-500 text-20"
                                    >
                                        {{ message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ValidationObserver>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div
                class="cell small-12 medium-large-5 medium-large-offset-1 xlarge-5 xlarge-offset-2"
            >
                <div class="grid-y grid-margin-y">
                    <!-- INCOMES TABLE -->
                    <div class="cell shrink">
                        <h2 class="text-25 weight-500 text-gray font-body mb-2">
                            Income
                        </h2>

                        <table id="incomes-table" class="mb-6 hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="submission.net_employment_income">
                                    <td>Employment Income</td>
                                    <td>
                                        {{
                                            submission.net_employment_income
                                                | dollarize
                                        }}
                                    </td>
                                </tr>
                                <tr v-if="submission.benefits_income">
                                    <td>Benefits Income</td>
                                    <td>
                                        {{
                                            submission.benefits_income
                                                | dollarize
                                        }}
                                    </td>
                                </tr>
                                <tr v-if="submission.retirement_income">
                                    <td>Retirement Income</td>
                                    <td>
                                        {{
                                            submission.retirement_income
                                                | dollarize
                                        }}
                                    </td>
                                </tr>

                                <tr v-if="submission.social_security_income">
                                    <td>Social Security Income</td>
                                    <td>
                                        {{
                                            submission.social_security_income
                                                | dollarize
                                        }}
                                    </td>
                                </tr>
                                <tr v-if="submission.pension_income">
                                    <td>Pension Income</td>
                                    <td>
                                        {{
                                            submission.pension_income
                                                | dollarize
                                        }}
                                    </td>
                                </tr>
                                <tr v-if="submission.self_employment_income">
                                    <td>Self-Employment Income</td>
                                    <td>
                                        {{
                                            submission.self_employment_income
                                                | dollarize
                                        }}
                                    </td>
                                </tr>
                                <tr v-if="submission.other_income">
                                    <td>Other Income</td>
                                    <td>
                                        {{
                                            submission.other_income | dollarize
                                        }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="total">Total</td>
                                    <td>{{ totalIncome | dollarize }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- EXPENSES TABLE -->
                    <div class="cell shrink">
                        <h2 class="text-25 weight-500 text-gray font-body mb-2">
                            Expenses
                        </h2>

                        <table id="expenses-table" class="mb-6 hover">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="expense in user.expenses">
                                    <td>
                                        {{ expense.expense_type.expense_type }}
                                    </td>
                                    <td>
                                        {{ expense.expense_value | dollarize }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="total">Total</td>
                                    <td>{{ totalExpenses | dollarize }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- DEBTS TABLE -->
                    <div class="cell shrink">
                        <h2 class="text-25 weight-500 text-gray font-body mb-2">
                            Debts
                        </h2>

                        <table id="debts-table" class="mb-6 hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Balance</th>
                                    <th>Monthly Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="debt in user.creditAccounts">
                                    <td>{{ debt.debt_type }}</td>
                                    <td>{{ debt.balance_owed | dollarize }}</td>
                                    <td>
                                        {{ debt.monthly_payment | dollarize }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="total">Total</td>
                                    <td>{{ totalDebts | dollarize }}</td>
                                    <td>
                                        {{ totalMonthlyPayments | dollarize }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="cell small-12">
                        <div class="grid-x grid-margin-x grid-margin-y mt-3">
                            <div class="cell shrink">
                                <button
                                    type="button"
                                    class="button button--hollow"
                                    @click="generatePDF"
                                >
                                    Download Report
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import api from "@/api";
import { mapMutations, mapGetters } from "vuex";
import tippy from "tippy.js";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import axios from "axios";

const icm_login_client = axios.create({
    baseURL: process.env.MIX_ICM_LOGIN_API_URL,
    withCredentials: true
});

const icm_client = axios.create({
    baseURL: process.env.MIX_ICM_API_URL,
    withCredentials: true
});

export default {
    name: "Summary",
    data: function() {
        return {
            military: false,
            accept: false,
            message: null,
            submitInProgress: false,
            isBankruptcy: false,
            maxCount: 495,
            remainingCount: 495,
            hasError: false
        };
    },
    computed: {
        incompleteSteps: function() {
            let steps = [];
            if (
                this.$store.state.steps.incomplete_required_enabled_steps
                    .length > 1
            ) steps = this.$store.state.steps.incomplete_required_enabled_steps.slice(0,-1);

            return steps;
        },
        allStepsDone: function() {
            if (
                this.$store.state.steps.incomplete_required_enabled_steps
                    .length > 1
            ) {
                return false;
            } else return true;
        },
        // @TODO: Make table for income submissions like expenses/credit accounts
        totalIncome: function() {
            let amount = 0;
            let incomes = [
                this.submission.net_employment_income,
                this.submission.benefits_income,
                this.submission.retirement_income,
                this.submission.social_security_income,
                this.submission.pension_income,
                this.submission.other_income,
                this.submission.self_employment_income
            ];

            for (let income of incomes) {
                if (income !== undefined) {
                    amount += Number(income);
                }
            }

            return amount;
        },
        totalExpenses: function() {
            let amount = 0;

            for (let expense of this.user.expenses) {
                amount += Number(expense.expense_value);
            }

            return amount;
        },
        totalDebts: function() {
            let amount = 0;

            for (let debt of this.user.creditAccounts) {
                amount += Number(debt.balance_owed);
            }

            return amount;
        },
        totalMonthlyPayments: function() {
            let amount = 0;

            for (let debt of this.user.creditAccounts) {
                amount += Number(debt.monthly_payment);
            }

            return amount;
        }
    },
    methods: {
        countdown: function() {
            this.remainingCount = this.maxCount - this.submission.message.length;
            this.hasError = this.remainingCount < 0;
        },

        generatePDF() {
            const addFooters = doc => {
                const pageCount = doc.internal.getNumberOfPages()

                doc.setFontSize(8);
                for (var i = 1; i <= pageCount; i++) {
                    doc.setPage(i);
                    doc.text("Apprisen", 10, 277, {align: 'left'});
                    doc.text("690 Taylor Road, Suite 150", 10, 282, {align: 'left'});
                    doc.text("1-800-355-2227", 200, 282, {align: 'right'});
                    doc.text("Gahanna, OH 43230", 10, 287, {align: 'left'});
                    doc.text("www.apprisen.com", 200, 287, {align: 'right'});
                }
            }

            const doc = new jsPDF();

            const commonSettings = {
                didDrawPage: function (data) {
                    // Header
                    //doc.setFontSize(20);
//                    doc.setTextColor(40);
                    //doc.setFontStyle('normal');
                    var base64Img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAUIAAAD2CAYAAACjgY5LAAAMTGlDQ1BJQ0MgUHJvZmlsZQAASImVlwdcU1cXwO8bmSSsQARkhL0EEQQCyAhhRRCQKYhKSAIJI4aEoOKmlCpYt4iCC62KKLZaAakTtc4iuK2jOFCp1OLAhcp3M6DWfuP3nfzue/+ce+6555zc93IvAHq1fJksH9UHoEBaJE+IDGVNSktnkR4CBH70gRWg8gUKGSc+PgZAGbr/XV5fg7ZQLrupfP2z/7+KgVCkEACAxEPOEioEBZB/BAAvFcjkRQAQ2VBvO6NIpuIMyEZyGCBkmYpzNFym4iwNV6ttkhK4kHcDQKbx+fIcAHRboJ5VLMiBfnRvQPaQCiVSAPTIkIMEYr4QchTkUQUF01UM7YBT1md+cv7mM2vYJ5+fM8yaXNRCDpMoZPn8Wf9nOf63FOQrh+ZwgI0mlkclqHKGdbuRNz1axTTIvdKs2DjIhpDfSoRqe8goVayMStbYo+YCBRfWDDAhewj5YdGQzSFHSPNjY7T6rGxJBA8yXCHoTEkRL0k7dpFIEZ6o9Vkrn54QN8TZci5HO7aRL1fPq7I/qcxL5mj93xCLeEP+X5WIk1IhUwHAqMWSlFjIupCNFHmJ0RobzKZEzI0dspErE1Tx20Fmi6SRoRr/WEa2PCJBay8rUAzli5WLJbxYLVcXiZOiNPXBdgn46vhNIDeJpJzkIT8ixaSYoVyEorBwTe5Yu0iarM0XuysrCk3Qju2T5cdr7XGyKD9SpbeBbKYoTtSOxccVwQWp8Y/HyIrikzRx4pm5/PHxmnjwYhADuCAMsIAStiwwHeQCSXtvcy/8pumJAHwgBzlABNy0mqERqeoeKbwmghLwByQRUAyPC1X3ikAx1H8c1mqubiBb3VusHpEHHkEuANEgH35XqkdJh2dLAQ+hRvKP2QUw1nzYVH3/1HGgJkarUQ75ZekNWRLDiWHEKGIE0Rk3w4PwADwGXkNg88TZuN9QtH/ZEx4ROgn3CVcJXYSb0ySl8i9imQC6oP8IbcZZn2eMO0Cf3ngoHgi9Q884EzcDbvhYOA8HD4Yze0MtVxu3KnfWv8lzOIPPaq61o3hQUMoISgjF6cuRui663sNeVBX9vD6aWLOGq8od7vlyfu5ndRbCe/SXltgibD92GjuOncUOYc2AhR3FWrAL2GEVD6+hh+o1NDRbgjqePOhH8o/5+No5VZVUeDR49Hh80PaBItFM1fsRcKfLZsklOeIiFge++UUsnlTgPorl6eHpAYDqf0TzmnrJVP8/IMxzf+kKjwHgVwGVOX/p+LYAHHwEAOP1XzrbF/DxWA7A4Q6BUl6s0eGqCwG+DfTgE2UKLIEtcIIZeQIfEABCQDgYD+JAEkgDU2GdxXA9y8EMMAcsBOWgEiwHa8B6sAlsBTvBHrAPNIND4Dj4GZwHHeAquAXXTzd4CvrAazCAIAgJoSMMxBSxQuwRV8QTYSNBSDgSgyQgaUgmkoNIESUyB/kKqURWIuuRLUg98gNyEDmOnEU6kZvIPaQHeYG8RzGUhhqhFqgDOhploxw0Gk1Cp6A5aCFagpahS9FqtA7djTahx9Hz6FW0C32K9mMA08GYmDXmhrExLhaHpWPZmBybh1VgVVgd1oi1wl/6MtaF9WLvcCLOwFm4G1zDUXgyLsAL8Xn4Enw9vhNvwk/il/F7eB/+iUAnmBNcCf4EHmESIYcwg1BOqCJsJxwgnIJPUzfhNZFIZBIdib7waUwj5hJnE5cQNxD3Eo8RO4kPiP0kEsmU5EoKJMWR+KQiUjlpHWk36SjpEqmb9JasQ7Yie5IjyOlkKbmUXEXeRT5CvkR+TB6g6FPsKf6UOIqQMouyjLKN0kq5SOmmDFANqI7UQGoSNZe6kFpNbaSeot6mvtTR0bHR8dOZqCPRWaBTrfO9zhmdezrvaIY0FxqXlkFT0pbSdtCO0W7SXtLpdAd6CD2dXkRfSq+nn6Dfpb/VZei66/J0hbrzdWt0m3Qv6T7To+jZ63H0puqV6FXp7de7qNerT9F30Ofq8/Xn6dfoH9S/rt9vwDAYYxBnUGCwxGCXwVmDJ4YkQwfDcEOhYZnhVsMThg8YGMOWwWUIGF8xtjFOMbqNiEaORjyjXKNKoz1G7UZ9xobGY41TjGca1xgfNu5iYkwHJo+Zz1zG3Me8xnw/wmIEZ4RoxOIRjSMujXhjMtIkxERkUmGy1+SqyXtTlmm4aZ7pCtNm0ztmuJmL2USzGWYbzU6Z9Y40GhkwUjCyYuS+kb+ao+Yu5gnms823ml8w77ewtIi0kFmsszhh0WvJtAyxzLVcbXnEsseKYRVkJbFabXXU6neWMYvDymdVs06y+qzNraOsldZbrNutB2wcbZJtSm322tyxpdqybbNtV9u22fbZWdlNsJtj12D3qz3Fnm0vtl9rf9r+jYOjQ6rDNw7NDk8cTRx5jiWODY63nehOwU6FTnVOV5yJzmznPOcNzh0uqIu3i9ilxuWiK+rq4ypx3eDaOYowym+UdFTdqOtuNDeOW7Fbg9s9d6Z7jHupe7P7s9F2o9NHrxh9evQnD2+PfI9tHrfGGI4ZP6Z0TOuYF54ungLPGs8rXnSvCK/5Xi1ez8e6jhWN3Tj2hjfDe4L3N95t3h99fH3kPo0+Pb52vpm+tb7X2UbsePYS9hk/gl+o33y/Q37v/H38i/z3+f8Z4BaQF7Ar4Mk4x3GicdvGPQi0CeQHbgnsCmIFZQZtDuoKtg7mB9cF3w+xDRGGbA95zHHm5HJ2c56FeoTKQw+EvuH6c+dyj4VhYZFhFWHt4YbhyeHrw+9G2ETkRDRE9EV6R86OPBZFiIqOWhF1nWfBE/DqeX3jfcfPHX8ymhadGL0++n6MS4w8pnUCOmH8hFUTbsfax0pjm+NAHC9uVdydeMf4wvifJhInxk+smfgoYUzCnITTiYzEaYm7El8nhSYtS7qV7JSsTG5L0UvJSKlPeZMalroytWvS6ElzJ51PM0uTpLWkk9JT0ren908On7xmcneGd0Z5xrUpjlNmTjk71Wxq/tTD0/Sm8aftzyRkpmbuyvzAj+PX8fuzeFm1WX0CrmCt4KkwRLha2CMKFK0UPc4OzF6Z/SQnMGdVTo84WFwl7pVwJeslz3OjcjflvsmLy9uRN5ifmr+3gFyQWXBQaijNk56cbjl95vROmausXNZV6F+4prBPHi3frkAUUxQtRUZww35B6aT8WnmvOKi4pvjtjJQZ+2cazJTOvDDLZdbiWY9LIkq+m43PFsxum2M9Z+Gce3M5c7fMQ+ZlzWubbzu/bH73gsgFOxdSF+Yt/KXUo3Rl6auvUr9qLbMoW1D24OvIrxvKdcvl5de/Cfhm0yJ8kWRR+2KvxesWf6oQVpyr9KisqvywRLDk3Ldjvq3+dnBp9tL2ZT7LNi4nLpcuv7YieMXOlQYrS1Y+WDVhVdNq1uqK1a/WTFtztmps1aa11LXKtV3VMdUt6+zWLV/3Yb14/dWa0Jq9tea1i2vfbBBuuLQxZGPjJotNlZveb5ZsvrElcktTnUNd1Vbi1uKtj7albDv9Hfu7+u1m2yu3f9wh3dG1M2HnyXrf+vpd5ruWNaANyoae3Rm7O/aE7WlpdGvcspe5t/J78L3y+99/yPzh2r7ofW372fsbf7T/sfYA40BFE9I0q6mvWdzc1ZLW0nlw/MG21oDWAz+5/7TjkPWhmsPGh5cdoR4pOzJ4tORo/zHZsd7jOccftE1ru3Vi0okrJyeebD8VferMzxE/nzjNOX30TOCZQ2f9zx48xz7XfN7nfNMF7wsHfvH+5UC7T3vTRd+LLR1+Ha2d4zqPXAq+dPxy2OWfr/CunL8ae7XzWvK1G9czrnfdEN54cjP/5vNfi38duLXgNuF2xR39O1V3ze/W/eb8294un67D98LuXbifeP/WA8GDpw8VDz90lz2iP6p6bPW4/onnk0M9ET0dv0/+vfup7OlAb/kfBn/UPnN69uOfIX9e6JvU1/1c/nzwxZKXpi93vBr7qq0/vv/u64LXA28q3pq+3fmO/e70+9T3jwdmfCB9qP7o/LH1U/Sn24MFg4Myvpyv3gpgsKHZ2QC82AEAPQ3uHTrgMWGy5pynFkRzNlUT+E+sOQuqxQeAHSEAJC8AIAbuUTbCZg+ZBu+qrXpSCEC9vIabVhTZXp4aXzR44iG8HRx8aQEAqRWAj/LBwYENg4Mft8FgbwJwrFBzvlQJEZ4NNrurqKP7GfhS/gUW+X72DW9S7QAAAIplWElmTU0AKgAAAAgABAEaAAUAAAABAAAAPgEbAAUAAAABAAAARgEoAAMAAAABAAIAAIdpAAQAAAABAAAATgAAAAAAAACQAAAAAQAAAJAAAAABAAOShgAHAAAAEgAAAHigAgAEAAAAAQAAAUKgAwAEAAAAAQAAAPYAAAAAQVNDSUkAAABTY3JlZW5zaG90CMjhZQAAAAlwSFlzAAAWJQAAFiUBSVIk8AAAAdZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IlhNUCBDb3JlIDUuNC4wIj4KICAgPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iPgogICAgICAgICA8ZXhpZjpQaXhlbFhEaW1lbnNpb24+MzIyPC9leGlmOlBpeGVsWERpbWVuc2lvbj4KICAgICAgICAgPGV4aWY6VXNlckNvbW1lbnQ+U2NyZWVuc2hvdDwvZXhpZjpVc2VyQ29tbWVudD4KICAgICAgICAgPGV4aWY6UGl4ZWxZRGltZW5zaW9uPjI0NjwvZXhpZjpQaXhlbFlEaW1lbnNpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgpXlnKKAAAAHGlET1QAAAACAAAAAAAAAHsAAAAoAAAAewAAAHsAAB+cIiQwWwAAH2hJREFUeAHsnQmUFNXVgO9swIAgCAEEQQVUFkFFwIgoARWDoDmIqJFwQNGQo7gEo7jgwhIT/qioERXFjR2BgMMWdBDZUTaBERhE1gEER2DCMsOs/337q+qepbtnerq7bntO1X13e/fdKj6rp7ur4orwBfSiDlAHqAMe7kAcgdDDR5+WTh2gDvAOEAjpRKAOUAc83wECoedPAWoAdYA6QCCkc4A6QB3wfAcIhJ4/BagB1AHqAIGQzgHqAHXA8x0gEHr+FKAGUAeoAwRCOgeoA9QBz3eAQOj5U4AaQB2gDhAI6RygDlAHPN8BAqHnTwFqAHWAOkAgpHOAOkAd8HwHCISePwWoAdQB6gCBkM4B6gB1wPMdIBB6/hSgBlAHqAMEQjoHqAPUAc93gEDo+VOAGkAdoA4QCOkcoA5QBzzfAQKh508BagB1gDpAIKRzgDpAHfB8BwiEnj8FqAHUAeoAgZDOAeoAdcDzHSAQev4UoAZQB6gDBEI6B6gD1AHPd4BA6PlTgBpAHaAOEAjpHKAOUAc83wECoedPAWoAdYA6QCCkc4A6QB3wfAcIhJ4/BagB1AHqAIGQzoFy70BBYT5k5WRCYWGhT+64OICiIgDcyY1D8PEvTlEEmMT9kqrDmRlwOPMAXNW8E1xYp6nbi8bUAZ8OEAh9WkKKUDpw6twJSDu0CnILcjjs4uLiMR3HnhhLmeniGBW51cioZBZtU7HcsZRNYQHAa1NGw5nss3yWqlWqwpA7n4bfd7i7lEgye70DBEKvnwHluP7CokJYt2cBQjCbw4yn5mATk5QGRQZA9uKA9AdJaRfZnNv4uAR49aMXISf3nDCIVJCYkAgfP7MA6tVq6AygEXXA6gCB0GoGiaF14JfTh2DboeU8SRywK0EBNQU4cbXH1Sj6u1I0IFQx/qEoKSdS8e2vJ47Dvz//l9YIjgq/+24eDANuHqptJFAH3B0gELo7QuOgO7D10Eo4duoAvxqUF3Q8V0lQFEBkbgp9SioeispTvLUWfnOWzoC0n7bwPHxSJkleNqp3EXzw1/lKTXvqgE8HCIQ+LSFFMB3IL8iD5T/OgsKiAvHWVr3NZYCTQGJ5GRTtvw0qI3MpCYp2jJJZrPgvEUZ++Cwv2zGXNe8bj0yByxq14T60oQ64O0AgdHeExkF1IOPkj/DD4TU8loGK/cdeAlr2mKuFrVQoyhwsj8zHJUk7nhXlg0cy4LNFH4icFvxsRc/r7oJHeo/gKtpQB9wdIBC6O0LjoDrw3d7FcDz7KI81+BIgVMASicsORcU0/39PZNkwF4Lw0wUT4cgvGSI9V1sVyCS1zqsDU55ZanxIog5YHSAQWs0gMbgOZOedhmXpM+TVH8vBAIVvgXU6ASxpcfpJL3mRh6MAP2QpTIR/TnqZEZfPxrdmYqGT4xH934SOl9+kqyKBOqA6QCBUnaB90B3Yfex72Hl0PQecYpB6S8ySlg5FEcWvFVUCFlcCFNXfE9P37oKUFbOYs+OlwMqVctC5TTcY3u81hx8NqAOsAwRCOg9C7sCy9M/hdO4JZBGjkYQawkexqTQoKk+HH8umEvCsritFnj8e3pv9Fn6B+jRfg+1vB/M0uKlaJRkm/S0VqiZVC3nNlCC2OkAgjK3jGfbVZGVn4qfFs/W8AmYMhww/gmRMJyTUcFoxyEmw8Ujbz8g6nmVTCXhW8ckzflANb80c67CpgXZXgtwPvXME3HJ1H10vCdQB1gECIZ0HIXVg26HV8NOvW3kOxhqDPAU9pWMwEzTifppsJUNRxYgsMl7sYNOO72Hl5lQ2kZ7fIUg/ueN+bS5pD2MGiE+YuS9tqAPYAQIhnQZBd6AI757w3+0fwzn8SR1/FSFyrCs9NxTNuGQoanDxK0ExYrE2FBPjqsBbM8bi9xaL0IIvE8Rle6hBicr4+ASY+MRCqF2jnqiZttQBdvrgyeznNh7UG+pA6R04ir8iWb1nHjuNuDPbalhJKCogGQgKHzM2gDPxMl8Jnzyfy86HifPfMUViiJpLFKNyGBehB/hTt0fhrs4PuAw09HIHCIRePvohrn3D/iWw/8QOdcGF2cTvhxWQOBQZENnLgpqBoA1FBS5jFVBVeufXcVZuXok/qdssUvMtm0P5KoXcqxLk8OKGLeCNwTNcTjT0cgcIhF4++iGsPb8wD1K2ToCCojyI56CxISQ+CGHXaJJB4krRBUVjFUBk5QidymU8FBTZhyxJ8dXgHXWDBf23Rs1BsypMo+ZXkFTGN/88E5rUa6aGtPd4BwiEHj8Bgl3+/uM7YN2+RTxc/H5YZAoIiiX8PZFl8wdFBsSsrDMwc+kkMbcmnZifkU+rLEgqZ27DzR2d7oOB3YfJINp5vQMEQq+fAUGu/xv8yszRU/tktEYPQoh9tUWo/UNRGNlWXOWhEOCHLItXLeJ3oJaTa/LxzGpyZcSxLEf7MVPdWvVhwiMLlBftPd4BAqHHT4Bglp+TdwbmbRnP+SXiEX8aQBo7GooCiMwToaTN4u+JQusLReVmYYyDs0p8MkyY+7aGmvKzErNkfuHH51IFYOBL970DbZt2ZGp6ebwDBEKPnwDBLJ/9nG7TQfz+nsQNx44CDMOfJbP87CqR7xE+JUFRQY1fKbr+nijyxMGxXzJh8Tr2STW+9DxiqAGoEmm1VLj0XdveBkN7jpJetPNyBwiEXj76Qa590Q8f8TvNqOsuwRe1xT0HlBgLKAqZTVcyFAUwmZeKsKEYh7fjn7dsNvzvTJapHOfivipAWvTbbjGp9je+cVC9anWY+OgSvJ1/kraT4M0OEAi9edyDXjV7Ol3Ktvc4quRXmZF7DEYGXgJkkkylQJGbsRr/f09kZZq8SXHJ8MmCCagyOjQ7XhqAlt6Gn3JW8z7WexR0adlDqWnv0Q4QCD164INd9uaMr2HbkVU8XOGI7RkUFYTY2HDIGkkout86s2TsSlHByT8U4+BARgas2rqMOTteal5bb+AnsvOtHSfla5pdD8/2GefIRwPvdYBA6L1jHtKKZ21+E+80c5IzJz5evZUV120Kf6VCURGP4c+SVWH+oMjevk5fPBXy8ZnJ7OUPfkLPzcyDCzo9NyqbtKILy/v+kIVwXrVaxkiS5zpAIPTcIQ9+wT+f2g+L8bfFCjIsk7rIKg2KCpIST7wIrtOk8oUiAyKfA4MSCqvA9NRJfCyDtcxzmo0wi4mEj5S1Ss0pFYO6PQm/v/penY8E73WAQOi9Yx70ilfvSYH0XzbqeMERjRcfKBr4ibfOLJBdyRk91/B8Booin/tDlp0/pUPaXvaUOvHiXmbDlYpvYmD5MVH5ivTGBcctGraC0fcxwNPLqx0gEHr1yAe47gJ8Szpt41jIK2QPULdoIvMIjdEzyX2VyFwZ8Nwfsgi9ssocnGpCTk6sAVOXfKZZxjxVDf7gp608XOXjQaZyqWYKVtO4QbOgwfmNhRNtPdcBAqHnDnlwC953fDss3TUdgxVBUOKiGbPMZuSUSoKi+nsfA5IdpUYFuQmQshpvxy+t5QE/UaucDXd9Og2Efr8dwtT08mAHCIQePOjBLDk1fSrswzvNMBjZsGK5DJiMhevZhr+MnkluKKqMxX3IsvGHzXDw2AFrHkwiU+rMqggfvajA+LsdRP31azeGcQMYbOnlxQ4QCL141ANc87n8szAV3xazh7c7XwphGkcWrIyOxYiR0SmpNChWT6wFM1OniGllkIoVSXGkFVK0xsymquRJLJtip0gOMPKeD6BFgyvVkPYe6gCB0EMHO9ilbv/5W1i9N0WGI1YsmAilUNhbpjd+zgAfP5nZHxSzzxRB6saF3IPHmY0GoM6uBNyXFX6sSJWye5s74cHfDZfV0M5LHSAQeuloB7nWlLQJeKeZ/RitSMMSCdnATiWXej40/sLPjP15Mx3zUEBkiFq1aS1knTkuLT47VYbeawBaU/nUqOCH6ewl1UquDf8elAIJeDt/enmrAwRCbx3vgFd7Kuc4TN/MngXMnugg6GJvRUKpseCj9EZlSVw0Y+ZrRkaqkVgb/rN8pjZqixLk3h/8eE7lJwd6qAVmEC8Fy7/2HAvtL+2i1LT3SAcIhB450MEuc9PBpbA+g91pRvNIphI0sbfCgFjyAxoWbdSWxEUztufJOpkN67avFHG2C8p2Niux79zq6s+OVytQOrXHRJ2ad4XHevxdetDOKx0gEHrlSAe5zhl4NchutOAfgyqpjSVNFR5TMhSNr/ETusT4REj9NhXy8nPFJKi2ZylP+LEJ1PxJiVVh/MD5UC2pupiXtp7oAIHQE4c5uEUeO30Q/rNtvAxmGFIPPDQAY0b3yIyNxDFmD3lWobC3PB8qkuPPh5Q14sHxGoBWvAIXTyODtFkLwurw5TbhYInSUewe6jocbmp5hxjQ1hMdIBB64jAHt8hVe76AtJ/XiGAXTQQUXcRBT6dGI8yySAg5HbVdWiHuXDKkfj/fnVBfufGisCadRgvcosxioG3SX4/RLGWtwpytGl0Fz/a2HhVqUpIUox0gEMbogQ11WYVFhTBp/WjIxtvyixdChNHCBURmKx2KAjP2VuXk8ZpCQpucVBM6NLodRs4Sv/RwTCkDeIgrzpFL24qHH/d3BOEA4+LxoVLj7p8DtavXY1Z6eaADBEIPHORglsh+RbKI32mGsUFTBVMJORAo2tE6nhdlWyRoUd+2YWe47pLbYdjke+DoyQxRPk7Ive0QYTFs1jYh+AJUppJxOhDddSizYWC/jg9Dr6sGKE/ax3gHCIQxfoCDXd6X6VNgd+b3MtxgoqxQDOXviX3aPQr1ajSCues/gjnfyrvCmBJ4TQ7IcZtwsERRu4yTOw45kcBh1nqVt/EFl8KYPp8JJ9rGfAcIhDF/iANfYG7BOfjku1fwJqh5GMzQpz4kYbk0UrjFZDdXdPpKixvteBPrzCRGzFonuT7cffWTPPL4qaPwxKS+OLuZX4HKlCHRbKeWslapoOL0OJty4ROzDSpG9fkYmtRprlUkxG4HCISxe2yDXtmOo9/B17vxi8z8pXGCIxtqzGhsEkc8gvspk4MwKl4ZpbuVqWOTHnDNRd20Ycy8RyH9sLwy1WHFw48Fcjd7XlToUO4gRrYLn1AqRDzAbVf2g3s7DuUm2sR2BwiEsX18g1rdF/hwpoNZP8pYhI6miBIkSKwrNRs1fqFokmBeO17lZNPFQf/2z8B5VWvLuQFW7FwAHy77h4mx3UUI99VqNQ8qtI77iZEy8yBbz2WtRSEO6tSoC6/fM8dWkhyjHSAQxuiBDXZZp89lwafrR+m3ow6YIBwESGytBEypULRA5KCRiW9Uqxnc0ebPjtLP5eXAY5/1hpz8HKOX08sdMsupcOuVWSeQCuOnLEJj+z912+vQ+sJrlQPtY7QDBMIYPbDBLmsTPqVu9T78/p5+STjoMRNsYGicGL2GorG5rxJ5Fma2qNO1WV9o1aAjMzle7y8dCWt2f8V1OqOKkwofPXorF50MFcZPaYXG11fYOze/FQZ3eUE50z5GO0AgjNEDG+yypm0aC5lnj/BwCxs41gixJOZmg8T4MH0gH7Ik4E/qBnZ4EaokVuNz25sfMjbA/y3ED1BsWuFU9mzKZrvwHFLBfXWAEHx9xay2vlqV6jCu3zxISqhil0RyjHWAQBhjBzSU5WSeOYx3mhnLU4jPaTU5ONZMbltvtBx+2qQFdCgdis3rtoUeLYv/3t6wqX3h17PHQoAfqxPrsMsSKrblL2OTTrhj0sNdRkCnS2+WXrSLxQ4QCGPxqAa5ptV7v4BNh5bKaEOMcECxZ6tBcOkFbYqtfNZ378PCLVORTKIuAy1VrtSrDLp8P/7aptNhlFTijkuWT9vGneDxbuJ/ECo97WOrAwTC2DqeQa+mqKgIvzv4Mn94O0viBI2hQmhQNHkUeNjb52r4lLpBnV7Cn7YVf0PUY1kZ8Mys+111iUJ1VpfgXAPzZSuz16YUbr1zzN62/+uu2fhp9vnCQNuY6wCBMOYOaXALOngyHeZus280oKliwcforK846wn9/U3RRDA3MRKAMpa2DW+Am5r30XmKE0bPHwJ7juEDpCTheAadxs5tZZB2JxRRqfTMVcoqylGftP3x2qHQ7Yq7lAvtY6wDBMIYO6DBLufL9Mmw/ei3yBjxL9/JBqlzKM2gZCgaPyOxKsWITde33ePQsObFpZa+bMdcmLz2TRUq/YP7u19Z4KfrReGSulfAcz3eK7VGcojODhAIo/O4lWvV7Kd0E9YOh9yCXAcfGBQ1DPiMZiR5Kesw+kDfOp9frR4M6PB8mdaTnXsanpzRB/IK2E//kIdmWhEvx0avFJKdLn+Hn2XjojVmTWCdGNVrEtSv2VjMRduY6gCBMKYOZ3CLST+2ARbt/MQKFhRwsACpYY/tyzIDFJbCeJUFitc1uQ06XXybNXfJ4rvLXoSN+1caJzmdTw1+9VidLk85iFRuNVuGY8U4vr11f7iz7YNmbpJipgMEwpg5lMEvZF7au7DneBpP4PjHLzVsp0HB5HKE4oBrn4fayb/hM5Vls+XgWnj76+e4q4EaG3JyCb0c8oHcCF+5CufOLE7rtSDyyWH9GhfCyF7yGct2cpKjvgMEwqg/hKEt4GzeKfhw7XP48PZCnqhI/qNng9KgWNLfE3m8lUvRRlwliuwNa14C91yFX5QO4FVYWAhPz+kLWdknMMoAi0uO+dBqK42rmE35ar0WdDVO0Irpnu7+b2hWt7X2ISE2OkAgjI3jGPQqNuNP6pb9NEvH2/ArDYqKJSy4JCg6gWKiuja7G9o1ulHPXVZh5vp34KudcwQGTToebuZCg2XjojVmNnutytfEy2qsQGa7sVlv+GP7wOBd1nWRX+V1gEBYeb2PiJmnbnoVfj51QHEAazK0UKAoGYhsGcpTLKksb53ZdwYHdxqDT4urIYIC2Gac3AsjF5i/1Rl4ydqdO7Mk1DsqVX5yr0vQY/TWsrCy7xL+o9dMfAh8onYnIfo7QCCM/mMY9ApOZB+Fj797yRVvo0JQwNaUFxSbXdAWerd52DV32YejFj4EGSd/wgBJKudOq43Z6eAGnPJTgW67HmOaIdeNgnaNO5e9WPKM+A4QCCP+EFVcgewndWv3L8QJfK98NBD49BIiwlMXVDIURYyJxIxIEzXu2fJBuOw31+hcgQqpO2bB55vF9/pUTp1cKvRs2oHV4JqJj4XSn80yY6Dwu6ZxF3joupddiWgYzR0gEEbz0Qux9g/XPS8f3q4SFQMECQBpVc6oFRqmCASK1RKT4aHfvgqJ8Uk6V6DCqZyTMHzePVBQlG9CsRy7JlWeP8CJIPQ2S1AqEab1QrD92J1oXu35OSQH8bbeFEtSJHWAQBhJRyOMtRzK2g3T5J1m2LQOgPA6fAEgypN6y4eJdnxpUGzb4Hq45Yr+Il0I2/HLn4OtR/DXMAJdIpMEmA0ubpB6XqmW5eQ41iou6JEBpVFx3/uvHgbXX9IzhOopNJI6QCCMpKMRxlq+wp/UbT6y3ADAIVn/6nlNYuwDF4wxnrZkZAVF27MffmXmovMvC3m1mw8uhwmrR2mK+dSnyxCC267H3Kydi4WfMQC0qNsOnujyWshroASR0QECYWQch7BWUVCYD+PXDMPb3591zGuhQOttgAklaoyj9nNeEwoHO1YBsWbVOvDwdX+34oIX8/GndsNT+gH7LqTjxaeXNbhrxbFlxjCXn8tffS1I5VdrZ2t75dbJ/Kl7ykb76O0AgTB6j13Qle/6ZRPMTWN3mrGh5iSAGUlQSGA4J7XjlUX5s7GdRcid8Cd1NzT7g3IOeT9945uw4id8tICeyk9NaONmy4dXp8eOUqWvZUTRGnFnBsg7Wz0AN7e4N+Q1UILK7wCBsPKPQdgrmLttPOzK3Oia1waI+589czU69HTFCru6WjJG4WdvB3Z8GepWb2hcQpT2Hd8JY5cO9b1KxUl1lVzQI+NrVMLXXgDaLDNWKUb2FWKjWhfD8K4TQlwBhUdCBwiEkXAUwlgDezv89qonoVA9vN35rx0rUf/gWVE+RmXVFftC0Y7XbjxXg/OawJ+uLf8HIY1a8gB+Kfwgn0yzTJfuqkfr5ep0AC/RtWIVawXZS0L5ma7vQmN8+h69orsDBMLoPn4BV//9oW9gcfpnPM7881b/4N3pbL3xZl5mZEtGFpnEWLGmW7N+0L7JLe5JQh4v2TENUrZ/bBXlnNcqls9lX9UxharPFMKujt1rMVZb6t68L/yhdfBfDLdzkVx5HSAQVl7vK2XmyRtfhQz98HZRgvOfvAsiukpb7y+CORq9+0oxDhLgL53/CTWqlP/t7rOyM+GFxf3xpv+FTqiZckRlNtzQZpl57WWFn24JCrWT68IrN08pMzjtWJIjpwMEwsg5FhVeSVZOJn5a/Dc+j4GAkZjB38jmhyiSXTEJyX+EyaSAeGmd1tA3wDvNqBnKsn9n1XDYiR8C2QvgJZpCuU2XzZOKUTAAtGt6BL8cfsVv2tsqkqOsAwTCKDtgoZS7Zm8KLN8zG38FYuNAoYpltvW+I0eYLqQ0KIqcvVoOhtYNf6ujylvYcCAVPsVnMvPZ7EJR4W9VocLPrr9Tk5uh/9VP2yqSo6wDBMIoO2ChlDth7bP4bODDPIWCQ/lBUWQUDFLZRbVVEqrBo53fqNCHpOfm58ALS+7F70Zmi/U5S0AdA7aPUhQY4rZaUjKMvnUGVEmoGmImCq+sDhAIK6vzYZ73yKl9+k4zbhyosYGi0Nhbu1zlL3T2FaHykpF8Fwdt8Cd1vVoNVsYK20/b/DqsO7jEyl9x8LMm4eLA9sOhfeNubjWNo6QDBMIoOVChlsmeUrc+4yufNE6oibeRBojMXUKNRzq9/Y18L7ri8C7Uw0p8eLtPUUEqdmduhbfXiLeoFXX1V1xprRt0gCF4f0V6RWcHCITRedwCqroIb8M/buVjcDb3fzzO39tXJ9REeqZzQ9H4GYl5+xuxec7DT4kf6fw6vi2NF0kreDv664GQeeZoBc/imz4+Ph5G3TINalat7WskTcR3gEAY8Yco9AJ3Z26B6d//i/2VzJHMXL259A4vMWAewUCR/aSu+2X3+clYMarF6ZPgv7umVUzyUrL2bTMEbmpW+oPqS0lD5kroAIGwEpoe7inZT+rSjq7BaQ3wgoWiylBWKD7YcSQ0qNk0bEvOPPszjPl6EBSZp0SFbe6mtVvAUzey33DTK9o6QCCMtiMWYL25BTnw+vK/QF4he3i7whhLYmSnHi3cZOxqSrdGjQ0UhUZt69VojHeaCf/fzd7CO+vs+XW7Kjus+xe6TYT6510U1jlpstA7QCAMvYcRnWHL4RXwxfb3fWp0wk8hjeHRyCwoECgaIPJIYD+pu/6SXj5zV7Ri3YH/wvQtb1b0NH7z34Z/Bri95SC/NlJGbgcIhJF7bMqlsskbx5iHtxfzgYWBn4Gg0Zky/EHRRFh+KBbhXEPxQ5Ja1eoaQ5gkdmOJEV/eB3kFuWGa0UxTt0Z9eKn7JKMgKSo6QCCMisMUXJGnzp3AT4sfxb+XiYe321n8fYrrhJ9BnFOvrhJZNuPjHjWt3RLvNPO8PWVY5c/wMaWbDq0I65xqssc7vwbN616phrSPgg4QCKPgIAVb4pp98+HLH6dguAGWkURWf0BkFif8TJRTXzwU2U/qrm7cVUxSCdsdxzbA+9+OqISZATpf/Hu4tx09BL5Smh/kpATCIBsXDWHvrX0G79O3X/6dT1VsQ03pxL68oMieTvfkjeOhKj6trrJehXgV/Erqn/ApfcfDXkL1KjVgzK30EPiwNz6ECQmEITQvkkOPnj4I7655SpZowc+IaDMDI4mQUKDYqn4n6NvusUpvT8qOibB09+xKqWNwhxHQ7sIulTI3TRp4BwiEgfcsKiK+2jUFVu5L4bU6IWdG5gvVzE3ojdUss3Qomij21vmeq/4Kl0fAbamO4NXwP78ZYhYSRqndhdfD4A70EPgwtjykqQiEIbUvcoNfW/EX+F/Or7JAG1R2zZZei1qwrhdNjD8o2n83TE6qBcPwS8Xx8QkmqBKl11YOhYMnd4e9gsSEJLwjzTSonlQz7HPThIF3gEAYeM8iPmLPr2nwycZXrDptVPkDnaUzIsabgZFEWn9AZJaOF90KPVs+IJwiYLti7zyYk+b7PcpwlHYv/nmg88Xh/x5lONYWa3MQCGPtiOJ65qa9C5sOf13MyhQUDdqMxELMyN9bZ6eHmMKG4oMdR+HD21sIQwRsz+RmwYtf3Q8FhQVhr6bZBa3giRvGhX1emjDwDhAIA+9ZREfk49Ppxn4zGG9QegbrNFDzLVrY7C3zcUaYUVmgeEH1BvDYDW/5TlXJmonrX4FtP68LexWsZy91/xQuKMfHl4Z9ER6ZkEAYYwd625HVMHPrG3xVxcHLd8k2Di34ORwtvRHRwwy6Nbsbuja/2xEVCQPWk4kbRldKKb2uGAA9Lu9fKXPTpGXvAIGw7L2KCs/J+IuKnb9skHgykAoEilaUXrPRMZUZmbxx8ESXt6BOcgMdEylCQWE+vJT6Rzh97lTYS2pQszE8/7uPwj4vTRhYBwiEgfUror3P4I1Xx37zEBQU5es6LWQZnVGizjHQPkJQf09kI+PnT2pa+3IY3KlyrrpcRfsdzk4bDyv3zvdrq2jlUze9DU3Pv7yip6H8IXSAQBhC8yItdN3+RZCyc6KFLGeF/gBmX9E5vd0jXyiafAC9Wz4EHZv2cAdFzPhA1i54fcXjlVLPTZfeCX2vfKRS5qZJy9aB/wcAAP//hvB/UwAAKg9JREFU7V0HmNVEF73L0ntHKT8sKEoV6SIIUsSCYAEFxQZ2UBSUunSQYscCdkHsFRERpYmKoIBKE5FeFFhAitRl8Z+Tx+RNZpP3kld2X+De79vNZDItJy8nM3fu3En6TwixnBYITPyxL23d/ydRUpJ5P8GQGWUEAvHBq0oWcT0Yb82FMzVnIJyclJP6tniZ8uUqmDl5AsWMmX8X7Ti4NctbVChPERrR5h3KkZSc5XVzhe4QSGIidAdUoqfac3gHPbHgPqOZFhpTGM4Sr9yQSm2IVrLgTEmpBwPXqpWqTzdd2E+/mHDnc9a9T5///ka2tOvuhiOoRpmG2VI3VxoeASbC8Bj5IsXsP9+h2es/sPTX0HALjSkMZ4lX7jAQH7yqZNFLM3N1rt2Hapx1kXmeqIH9R/fQsDm30MmTJ7O8iXXLXUK31R2Y5fVyhe4QYCJ0h1PCp3p8wT205/BOSzszkZp6VWG4IO0FEwTjlFAwKBIGTvLmzE/9WrxGOXPkCmZO4NCLiwbQH2m/ZHkLc+fMQ6PavEd5cubL8rq5wvAIMBGGxyjhU2zet4ZeFPpBiEFPSTksbQ7yl10ImQLxwauW7EqvMphC8mj9cm2oQ417rRkS+Gzptrk05Zfx2dLCm+v0oYYV2mRL3VxpaASYCEPj44urn62aSD9umWlpq0lZYUjRTIfckt0QtJQWPAnEB6/e2WAkVSpePZggwUPpGcco9ZvOdDT9SJa3tGqpC6hH43FZXi9XGB4BJsLwGCV0ioyTGTRy7i10OP2gQl5BokLjzTNbUjSvBtMZmRziFTSK5i1FjzZ/SYnxR/Dd356iRVu+zvLGJokPzfDWU6lI3hJZXjdXGBoBJsLQ+CT81VU7FtEby0YL0wxrU4OnwRBSGGcaIZrxChVacjn0FFukXEdtqna1VuyDs3V7VtBzCx/NlpZ2qN6dWlbplC11c6XOCDAROmPjiytTlo2h5Tt+ONXWAH3Zk6KF2oz00ZLiQ00nUOkC5X2Bk97IEXNvpT2HdunRcT8vVySF+l4yMe71cAXeEGAi9IZXQqU+mn6Ihs/pSukn042+nNUyPnpSDFJn5lDZwpWpZ5MnEwoPL42Z+ccU+mrtO16yxCxtvxYTqWyhlJiVxwVFjwATYfQYZlsJP22ZRR+snKDUHyAs/NdJUe8lIlMwdbCIQBwuhp55bnf+HXRxpfbBjD4L7RYG6KPm3k7Zsa6q1TkdqX21O32G2OndXCZCHz/fF4TJzIa9q8w7UFR5Ii7J1PiFI0WT/MwcgSLNeI0Uk8X5gBavU8E8Rc26/Rh4dmFv2rBndZY3vWi+EjSs1VQxSW8inOVt4AqtCDARWvHwzdm+I2litvgO0V51lUTwxbK+YzEixVOEWLXkhdSt/lDfYOXU0B83z6T3lj/rdDmu8T0aj6WqperEtQ4u3D0CTITusUqolFg3O+OPyafaFCDAJMuAODQp6r1EFKQPn5USLPfepXZvqlOuhSXOjydHTxym1K87U3rG8SxvfqMKremmOo9keb1coT0CTIT2uCR87Lj599COf7ecsoEOUlZQ86dS3SmiVJMpGkI1pcxvT4pJlCc5Lw1u9RblSs6T8Bi5aeDkZY/Rsu0L3CSNaZq8ufIZS+5OFxxjCk42FMZEmA2gR1vltv3r6cnvemYqJjAcVtkOQ2KV5oLX9KEzCsNVNTVidEKsV/ZSuvGC3pnq9mvE77uW0KTFqdnS/Nvr9qcLT4OedbaAF+NKmQhjDGhWFPfZqpdo/sZPzaqCGkAzyran6JYUJV3akeKd9UcI3daFwYp8Hjr530kaNrsr7T+6N8vvpEaZBnR3w5FZXi9XmBkBJsLMmCR0DF7cobNvpoPH/rFtp06KwZ6fpDdkc99TlLlAikXyFKPUllNOu9nOz1e/QnPWf2yLZzwjc+TIIYbH71KB3EXiWQ2X7QIBJkIXICVSkjW7ltLExYMsTQqSnSXaoDs1JphO0lvg6Lan2CLlGmp3Gtq//X1wM40VOtfskI4176NmKR2yo2quU0GAiVABww/Bt34ZR0u2zXNsapDsrEnse4qSEJHWmRRlmb2aTKByhVOMgqUNnDxaa/Pf2RNC57p137osb3jFYudS76bPZXm9XKEVASZCKx4JfXY84ygNEuYex08cddVOSWBqYp0QcS2QLhQpJlHp/BXonrqZ/fghL8gwOUdyYMgswjiX8Xp9lmtIZNQfyGOcZNO/BRs/o49XTsqW2h9pMpFK5j/bUncAP+vqHplAXjsFn4wWxyTD+3ZycnBvFDWN00fLKV4p+LQPMhH66BFH6lRUfRnU29VJCtcCaa2kiKFz83KdqOHZV6nZLeGcOXNazqH/0iX9+HHKmzevES2vHzlylAoVCmz6lJGRQbly5TLaAHf6apnqy+oU1utTz9U8arwMHzq+nwZ/cxPBrVlWS9OyHeiS8h0t1er3r17Efmu5c+dWo8xwcrIVd4kzEoAgcwgzABknj2ZmLYA2yDRO+DnFa0Ul/CkTYcI/omADJy4eSGt2LQtGRBByS4rBdKDLJOpWbSwVSHZeUpdsQ3x68+xeGvWFxksKwcsnX1p5juPJk/8Jckw2ruEccvTYccojSCFXLisRB65m/q9u2qi357Ulw2nlzsWZM8U5pkjuEtTtvLEGSeEeIRILu6olOXm9JnuKOlkmiRVDepmoH+ll2mDeYG/TWr/68QxcCf6GAucSexV3NYxU+nkgZ/z/MxHGH+OY1HDw2D6x8VDXKHssukFM5h8vGqv3FMsXqErXVnK2HVR/8EkOhPifeMGTNKNEO/LECydfBvXlRFglh/T0dEoWvVC116gCreZFPOqHyBdalqWmW71rMX24GkvuBC4qNBbYAieWKKNk8S9TZKYII6Vd7HUVH6bS+SrKkk71zM1TS0DiY4k8deJ0zSke2VQM1DJBgiBJXWR6ecR1azgInsQbaQLPFqGgqNf1TbXQZpSLo/yTOUPdj0zj5chE6AWtBE2LL216+gk6LoaeIIiTGSfppIiTX2D8wGQYt6CG9R+feg1p9euIcxLZm3G6rserLw+u5dCGdUacyrJKAXpe5ZJtUBKfelEvA+1X44Ah5MSJE2o2C346XjKhjpuaTpKyTJudRztc0B4VB7V94eLV8mRaHFUiU+PVumS8GqeGA+UEeo1MhOpT4XAmBPDC4cXFi5ghCDFDHE8IcgRRQuQLqb+o6jUj4al/dunU66HC0PkZYkNm+g8ZP3K7HqKeDuWpL0ygAvv/Xtqu9kwspYm2O5UDXKWo+Z3SI22oa7KsaI8m7qIgqB5OnPCm90QvWy1DbY8cKqtxdr1yiYc8Ij3UGqrIsiRJyueqPnMZh3xqvFpOLMLcI4wFij4pAySITs5/wigbYRAlDLTRg0RchugR4YieEa4jXv5Y1VtUXxK7XqDXlx11qD94tS4Zltfx0tmVbxdnN6yT5alHvKzyA6HGy7Bd2bI9efPmocOHw28EhXRHjoRPJ+vUj3huUk56mNBR88n88iiJRd6LHi/P5RHpJbEF82IYjKFrkKhwLfCHnIGw7CnKfPpR1pFdRybC7ELeB/WCHPCDVUkC4cDLFSBLhAPXZTxuLBAGYeKlDaQP3LAsS74IiMWLaLyMhmoJ65sDOiYc5Esq08sXMVCaLBMvoRoTmzDaqt9/qJKD2MhUAfbC/cv2yyuhjwrriYQSM5lH4inj1XtXyT/z9SCusqwAUQXO9DaGOw+W4f8QE6H/nyHfASPACESJABNhlABydkaAEfA/AkyE/n+GfAeMACMQJQJMhFECyNkZAUbA/wgwEfr/GfIdMAKMQJQIMBFGCSBnZwQYAf8j4Esi3LUrjfbv308FChSgsmWtXjv8/0j4DhgBRiCrEfAdEcI2asxj42n37t2UL18+Gjos1dETR1aDyfUxAoyAPxHwHRH+/vsaeuXl10y0O91wPV10UWPznAOMgBMC+Ij+9NPPtHTJMsNIuV79etSoUQOPxs5OpXO8nxHwHRG+/NKrtGbNHybmZ599Fj3at495zgFGwAmBWV99TbNmfWO53Oay1nTFFW0tcXxy5iHgKyJMS0szhsX6Y7q/x710zjlV9Gg+ZwRMBOCZZ8jg4YaHHjNSBOAIdsTIoZQnz+mxT7N6bxx2j4CviPDTT6fRdwu+z3R3tWrVpDu63ZYpniMYAYnAvn37aMTw0fLUckwdPICKFy9uieOTMwsB3xDhsWPHaNjQkYQjBF5IpJ84LA7Hj7lYsWJn1tPju3WNADzIYJJtz549ljz4zQxK7W86d7Bc5JMzBgHfEOH33y+kTz4ObGqO4UyHa66mjz78xHxQLVtdSu3aXWmec4AR0BH488919Oorr5m+GfExvfPOO6jqeVX1pHx+hiHgGyIcO+Zx2rVrl/F4MNN3fcfrxFBnFP377yEjLn/+/IYpDUiShRFwQuDgwYP0228rjMu1a9ekwoULOyXl+DMIAV8Q4do/1tKkSa+Yj+Xhhx+kCv+rQF988SXNnTPPjL+x8w2GOYQZwQFGgBFgBFwg4AsifO3VN2jVqtXG7ZQvX45693nICO/du5dGjxprOq4sV64s9XnkYRe3zUkYAUaAEQgikPBEuGfPXnpsdJDsbrixEzVu3NC8A92usOcD91PlyinmdQ4wAowAIxAOgYQnws+nTaf58xcY94HNwYcNH2xZUrdy5Sp6/bU3zfu8oE5tuu22W8xzDjACjAAjEA6BhCZCGMEOHzbK3PSmabOL6brrrrHcE8wiRo18jPbt22/EY4+L1MEDqWjRIpZ0fMIIMAKMgBMCCU2EPy5cRB9++LHZ9r79HqGzzipjnsvA12LZ1Fdi+ZSUNm1a0RVXXi5P+cgIMAKMQEgEEpoIx497gnbs2GncQIrQ+z0g9H92cmD/ARoxYrS5zWPBggVoyNBUw+jaLj3HMQKMACOgIpCwRLhu3Xp68YVJZlu73nIT1a17oXmuB958YwotXx6wD8O1m27qTPUb1NOTZds57B3hQzE9Pd1YxZBb2DuWKFnCWOuabY2yqRgeWrD64siRo2Lf4xOUMzkn5Rd+H4sVK5owXlqwTWia8El5TKhO4IqtUKGCBP2xvv2kze3FNQrY7RWTe4fF/sUGdjlzGbjBb2Z2CNrzzz//0CHx28sQ26riWRYRKqNChQplR3Ns64Rqa/fuPXTsqPi9iXCuXDmN5Y54rlkpCUuEb7w+mVasWGlggR8S/A5iJYCTrF37J02a+LJ5uUKF8vRw717meawC33/3A23atNksrn2HdrZGuXhZV65YRVjNsH7DBtp5qmdrZhQB6DMx1IdJUNXzziMY+Ia6RzVvuDDqf/ed981kpUqXorZt25jnagDrcJcLI+P16zfQBtHWQ4cOq5eNMH6YaGd5gSs+SDBVirXMmDGT/tn7j1EsSO3mrl0sVWzZspUWL/rJ+OAdOhQwpJcJ4DShd59eVKpUKRlle/xYrE46fOr+cE8dO11nm85tJJZ5AjdM2q0Sf1JXreYvXryYYfdau3YtuuCC2nFdzodnuXjxz7Rxw0baunWbqV9X2wMjcjzL888/z+gs4CMSK1mw4HvasnmLWdw117anggULmucIHDt2nFavXi3+fqc1wq2e3e8NmJUvX95oX/Xq1eKKGdqUkESIr9iokWNM+8CWLVtQu6uvQnsdBV+/sWPGU1rabjNNr4ceoIoV/2eexyIw9a13aNmyX8yiBgzsa3n50A4Q+Axh7K22xcwQIoAv9UVNGlPTpk0y/XhCZLO9hBe076MDzGspKZXogQd7mOcIHBE9lzlz5tGCb78z121bEoQ4SUmpRM2aNaXaF9SK2Y/0ySefoe3bthu1ggiffGq8EUavYfbsuQQ3WsDXSfCxLFIk9CQZJt/QM4cUKlyIhg8f4lRc2Pi//vqL3pryNu3cGVjxFDaDSFBSjALatGltvOCx7MFuFuQzb958WrF8ZUiM9Dbmzp2L6tevT5e1bW37QdfThzuf/OZbYuXOcjOZ7tAC5IelsSBst1KqVEm6VkySgrjjJQlJhF9Mn0Fz584373lQ6gAqUSK8d5D587+lz6d9YeZDzwVD6lhKKCKEgffUqe/Spo2boqqyQIH81LnzjVSjZvWIywlHhEuXLqNPP5lGhw9n7v15qfTcc8+hLkINEYtZejsiBAm+/vqbtHrV72Gb9fgTYyk5OTlkulgR4aIfFxN6l+h5RyL16tWlTjd0FKZg0S0JTU9PNyYK5ynvSyTtwRLVTp2uJ5ifRSNORHhUDH0/eP8j+vXX3yIqHh+NDh2upkuaN4sof7hMCUeEeLD4scoX9DyxIP6ee+8Kdx/GdXSxhw8bafZuMPQcMnRQTL50sgFORLhH6DleEDpN/UtXrfr5VKVyZWNoVKZ0acolfvh4uf/991/CUA/DiOXiK441sLqgdwhzoXAvt54P56GIUJ+NR3qQb+3atel/FSsQ1AqFCxcR9eYwyoE+brNo64YNGwUhrc7U48ifPx916dI5KuJGG+yI8FthQzpt2nRcNgQ6pOrVqxt4on1HhS7zgMAOPcmHxNLLcBILIkSPH6obVTB8qyWGvtVEr6Wg0FnitwdPSWgXemuLF/8k1sqnqVmonBie3nvv3Qb2lgsuT7DY4LVXXzcnFGU2DEVrCTVLSqVKxvOEaglEAnO07dv/MobN8PT+9987ZBbz2OySpnTNNe0j1rfaESF66VgdpjpUzp07t6FiqXJOZapUsSLlE78hdPbxHmzevJl+X73GovOXDbzl1pvpwgvryNOYHROOCPGDef+9D80b7Cb8DNasVdM8Dxd4++13DVfsMh30Ym0vv0yeRn20I0IUiomd/WL2GoIfXeOLGlGLFs3FsLmkERfqH8h/yc9LxfBvjlBuW4cM6Dl0uelGz8NPJyL8Tug4P/3kM7M5RYoUplatW1HDhvUthupmAi2Alw89b5ApCF0KXvzuwpNLtWrnyyjPR50I+/V/hJ54/GnzwwY70quuuiIqJ6rREiF6NrBbPXz4iHF/0OmiJ9VA4BdKgBX0sB9//IlFJ4aPHfJ7FfxOnn/uRWMyROYFAcJ0rFHjRmF7mlKFM/PLrzIN7Vtc2pyuFqqoSIbuOhFiNDdn9lxatGixbCbhOUI9gEmuULJVfHzfEqoo7E8kBXpdeKSPxQhEloljwhEhfvjQvUDwJRk8ZKAnEti0aRNNePYFIz/+QQ80ZMigiHpVZiFKQCdCTMigdyB7gjDdueXWroQho1eBzg5Erg8DMRzAsMDLD9OOCJu3uIQwuy4FOhdMSEQyq7lBTBBMnjzV0pOF55/77r+HKlWqKKvwdNSJsF79usYHAmQDFQcmG6KVaIkQL/WMGTPNZoDEQGZuBfpv/F62iZ7i/4TjEIx28HJ7kQMHDhgkiNlWKcD89jtu9Tz6wUcYHQ9V740y4eauefNLZPGujzoRQrcPVRcEH8suXW4kPFe3gvcK77N8v5APRN2+fTu3RbhKl1BEiKEXvnJS0JNzmumUaeyOTzz+lCDTv81L4UxvzIQuAjoRgvAwMwwpWrQoPdirh3F0UZRtEvQcpn32OaHnpgqWDXrR3+hEWEbMTsOMAkNyCHqsHYUrM/w4IxXYbz7//IuG+YMsAx+eAQP6GuYsMs7tUSVC5MFsJnpgsfQqFC0RTpjwgqkDxuQWJgPwAfAiuKcvpn9JV7W7wjMJoieHJaXSCQnqhfoIvXF8MCIRlAnv77CIkAIVRN++jxgmXjLOzVEnQnQMpKu8SN9DkDTeOylQ4wwdNjji+5XlqMeEIsLJk8WM06+BGSe8oOgNhpsFVG9Ghhf+8CN99FHQaWtFoYPo9VBPeTmqo06EsjAovR/s1VPssxy9WQnIEDoV6HGkYCjQXxAMdCtuRCdCNQ/I++577oxJLxkzps8+85xBWLKOSzG0iuCLrRMhyqtSpTJhTxovvWHZDrtjNESIiZH+/QaZEySwU4W9alYKJhumTJ5qVonfBTwuRdKrNwsRAdzbc4LkobeWUrXquUaP1Qv2OhHKsurWExOXXSObuMT7gMUVqo71XtGTjqVD3YQhQthfQfeCm4bUqhX5PiT44sKtP5TDUjCExSRAtOJEhLpXnGjrwT3Atbw6ieJl6aATEWIYNnBQv6hfHPX+fv1FvJxTgi8nPmLQ45QpU1pNFjZsR4Q339zF01AqXCXRECEm8FIHDTWraNLkoqjtEM3CXAQw+TJ61BizhwWcYRIVKxMx6OKefOIZczsMNAkTUBjCuxU7IkSPGZOW0ZA1/I7C/6gU6DAvbdlCnkZ9TBgihNL2m2/mmDcE3Qm6/JEK1ihDoS8lVl9vOyLEsPPRR3tHNcyU7VSPCxeKnq2wuZKCoSJ2XHMzBHIiQuhsWrZsIYuMyRFDK/QK1d7ExU2b0PXXX+upfJ0IYSQ9fMQQ171gN5VFQ4T4OA0cMNisBhYBd93V3TyPd2CRMCb/4P3gRCImuDoLnVss5euvZ9NXM2eZRWLPcOwd7lbsiPDiiy8yPMq7LcMuHVQBGCVJwSSibnAvr0VyTAgixEurut0vWbIEDRjYL6rhECZcMPEiBSYoMLjFzFo0YkeEt90u9HdixUCsBcOVMcJIHMu2pGC3PvSWw4kdEUJfkzp4UNgZxXBl211fu9a6sgd6nGHCWNmL6Y9OhLH6eKntjYYIQfgYtagz++iRpaRUUquIW/iZpydYPjaYmIKaI5aSlmbdMjfwMRrq+jdjR4QYHWD/8WgkLW23GCGNM4vAiiw4YYmVJAQR/vzzEstysFh1e9FLgQ2XlCuubGtM28vzSI46EeKHMnLUMFe9tEjq+3LGV4ZZjcyLmVPMDoYTOyKM1FQjXF24DpXGyBGjTRMixN15Vzdh81cNQVeiE+G113Yg2LXFUqIhQrTjww/ESOPH4EgDo4EeQocZ7Qc23D3uEDZ/48c/aSaDbhDu5jA8jrWolhso28sKLZ0IMRzGKMaLntHufnT9LEZHj40ZaZc0oriEIMKnnnqWtm3dZtwAehBwvhqNPkEioRMsbObw4/HSS5FlyaNOhDDuhJFnvGT79u2G3kaWD+LFDyDcD8uOCKNVN8g2OB1hn6jOdoPEQGZuRSfCe++7m6Cwj6VES4Swo4TiHmYnUkCCnbvc4In0ZV63R3UXR+Rp2Sp+uzbOFiqqL4WqSgqGxhgiuxGdCGvWrEHdut/uJmvYNFgsIW11Mas9bvyYsHncJsh2IoQDgwnPPm+2N5rZJbOQUwH8WAGeNH5F9K23daU6dS7Qk7o+14nQy4/EdSVKQgzHhgweZjHCHSzsIuENJpToRAjiHDf+sbj1XNGWVSuFHue1oB7nXEFi9wkycys6EbpZO+y2bJkuWiJEOQsWfE+fCXMTXapVO58uEeSP2cxwHyo9b7jzDz74iLCsTwrMZWrUiHwJpizH7rhundXzkxd9r06EsRrdoZ0YcUi1BPCVa9Ht7sFrXLYToU4s8DkI34OxkmmfTadvv11gFhfKr6GZKERAb2+PnvcZJh4hskR9SbVdQ2F333Nn2AXoOhEWF2u1U4WVfzxF1y/Bywl6925FJ8Lxj4+JOXHHggihBsCyv+8EIdpJabGUsmGjBmIJWZ2obErVsnX9IPTSZ599tpokZuGdO3dalhBC/4363IhOhLHUY0I/u/eUdyK05amnH3fTJFdpspUIYSE/YnjQoSqGrE3EDFMsZb8wy1m+fIWlSNhdRepGSifCYcKws7AYcsdT3nv3A/rpp5/NKq4Rw030PEKJToSYgXe7ZjtUuaGuQY/Tr+9A0wQKaTGMhz7HjehEiC9+rHtWsSBCeS9wvQVXZ1gR5CT48DZu1JDqXHiBZ8NrtUzMVmPWOjsEPU/0QN2IToS9hdkaXLfFQkYJ0yF14vC0IUK4VZo165tYYOSpDGwQj9UKkYhOhG48nkRSj5oH9lPq/s1XXnk5tRZrSkOJToSxNjdwqhvDeLmSAGm8fChUIoz10Ee2N5ZEiDIxVJv11SxauvQX09Ba1qUeofNuIpbiXSRsDyNZJ/voI/1Dlq/WFeuwFy9OOhH26/+oZ3tSp/aflkSI3gPc6x88cNDpvuMWD0XrkKGYkMnvuQ6dCOPRa9EbpdtYull6qBNhPExR9HbiHIbs6OlLcaPPlGn9SISy7TB8/+H7hYaXGanQl9fUI4yLoTfDyMfLjG+f3n0zef1Ry41nuFmziw1/gG7q0InQrQs9N2WflkQIf3hvC9992SVXtbuSWomZN6+iE2E89Fh6m6ZPn0Gqvzl4YGnVuqWezHKuE6GXr7qlII8ng1OHWiZ2YBCNNbluxM9EKO8P+kNMAEIdA28zqrMAmQZHzIbD2sCtdUS/vgPETPUJswjY5rldbmlmijCQL19egr9CN6IToe6Y1U0ZTmlOSyLUbfygVC1bNj7KXwCLr7W60x0cJOAhefkqoxydCAcN6u95YTrK8SJTpwqv2GLoJQXOEsLpUnUixKb3PcVEVDzl+PF0sRZ3oKWKseMec22MezoQoXrzIEV4a4YKSF0nK9NAd4ZZdTfeZ1TTEeSHGRjc2SeaMBF6eCJbxcLup4WVvBT8IKBUjafA6wr0QxiSS4FhslfXTjoR3nV396h88Mm2hDqqdpZI11PMVFcWzghCiU6EsHWDYWs8BR5/4PlHSokSJWhQan95GvZ4uhGhvGEQIjyoYNtZ1XUWrjdoUN/wNynTOh0niv14/lz7p3k5K353ZmUeAkyEHsB65+33aMmSpWaOGzt3okZiZi3eopPYOedUMTybeKlXLyOWdlJ27QBxDxo4xOJAYuSo4WH1mzoRouwRI4eJFRAF7KqJSdwvv/xq7OEhC6shjGm7d79dnoY9nq5EKG8czxLu6mHor4obhyCfCGN11U2WmwkztY6sCjMRukRa75nBzTsmLqLdu8FN9Rs2WP0dIo/XdZA6EVYRPTPYEsZL4Otw4osvmcVjdQx8sYUTOyKEU8xwnpTDlRvqOnS+0P1K8eItB3lOdyLEPYIMX37pVdOHJeLcuC1bqDngyGqHD2inG2EidIOSSPPNN7Np5pezzNTwggtvuFkl6qbxqNOrdw2dCFEGjIZhPBwPgfcZvARS3HrysCPCeL48qG9w6jCLC6eHhQunCh5cOJ0JRIjnuHXrNnpaLCuVgr1L+vR5SJ7aHjHpAptbKdBt43cX7zXOsj63RyZCF0jhawjrcNW8AF5m3Ozr4aJ4V0n0NZvoiaKH5UZhjQrsiPCyy1rT5Ve0dVW/l0Twfzd61FiLwa7bBfB2RIiXB/uAhNv710sbZVoYfMPwWwpWV6AuLwbRZwoRBpZNDhez64G9mTGrjtn1cPLC8xONPZRlOjeG9TJtVh2ZCF0grXvXzYrVDnqz7Jy2YpN2bLTkRuyIEGQ6cGD/mK8w+fzzL2j+vG/NZpUsWVK4J+vrilzsiBAFeVkuZVYcJgAHuHCRpH7grhQmPq3DmPjoxZ4pRIj7HjJ4uLltgtuliPrugyBQ/B7crtzR8Y7HOROhC1ThCnzjxk1mym7dbyd4p8hq0V0pYR3uQNEzdWNKY0eEaD/2E7lVbNrkpQcU6r7hT/HppyZYZrm97PngRISoM9YzjvrKFwzX8IK67WVLHBKdCHfs2Gm44Ipmu0vcK8yMBg5INZciut1KAh+cscI/Jby5S2khNuRq3yHrVEuyXqcjE6ETMqfidXdS8J4Cq3M35BOmaM+Xsbfrk088bcnXvbvw5uFiQ3UnIkRhl4vNpi5r28ZSbiQn+/fvp2eefk70sII/eMxww9bSLdGGIkK48urVqyedFaWzTNyb7uoMcTeJfTywksWrJDIRYl0xJoPgLh/PuK34c/ssdBz0vZrdTJbIMvRtERAf671+sQ/ND9//YKwm8XqPTITySTkcdccB2T39D9dfWAEgBZb+8H8XTnQibClWp6jrgLFiBT/sSAke+0Zgu0d18+2cOXOKDXoeEms2y4RrnnldJ0L0OnKIDdE3iplzCDbFwp7RXiYzzMJPBWAChecKOzkpXglb5sMxUYnw4MF/DQ/q0HFLiXTvX33fEZSHTb/cboEK/SKsCNatWy+bYvzW7rjjNlcfcjOTTQBqI9g6ws0Ynil8LDZs2MAmpXMUE6EzNoZSGMbMeDkh8DIzZGhq2A2eQxQZ9SW8xLBnVMXNAnGdCLGzHPZ4gP5TCrwy33BjR08zyfiBowzYmeFlkQJC7dbtdqpew72nZ+TViTAlpZKxxwNmKw8dOowkxnNo376dsUrFi7NavDDYcnTx4qBHHJQH9+k9et4f1sYRae0kUYkQbdWtHRBXq1ZNw+KhePHiOA0r2NN4quhVyo8RMkSiJ4cJGvb6VTc+R1nYOL1du6s8m6KB9GD2hC1GsWZaCkYOGLV5sT1lIpTo2RznzJlHM5QdqLJq3atNU8woEAWWLUlSwAU3Dih1IoQuDC/Cu+++b1kGB2LB8LBp04uN/Rqceoggld/EmtRv539L0EHpgg1q4DnGq9gRIfbXwLBnkliloA67oaaAGVNdUY/Tjx5EnZa229gQa9GixRayRtugZ33wgR5RTRglMhHi/j/DftOit6QKnnPz5s2ofv16BLf9dkNJkMvKFasIa8bxvKVg/e5DDz9AmATzKvCUjVGNSlwoAxMo2LO6ceNGIZ33Hjt2XMxAr6c1a/6gNWLbWH3FC+4DIxuMcOzuyam9TIQOyOBrM2rkGMvi81g7X3WoOmz0dDErO0+ZlcUidthmhZqFsyNCmKPgPrFJNtY064IvK7YSLVW6FOXOlVukzTAIGPZkaWKzHDvBDxpDk2rC63Ek4kSEKAvOLUGGeo8C14oVKyaGy+WN3mxyjmQ6kXGCdgsCRFthzmMn559/ntHWaG0pE5kIcd8gQ6zwsHvGuI5nVrlKChUqWFCoIZLpuCAb7OyHiS9d8JvAni5VqoReKqnnU8/37N4jepjvWPblUa/D+L5subJUQnyok5Nz0vH048YH7MD+A8akpTrUV/NBjdKx03UR+exkIlSRVMLwwvHmG1PMGDhWeERsfZkIAiJ4bPQ4S1PC2WY5ESEKwYuClwQ+FqWNmKVwlycYcnW6oaNj78xNMaGIEPnRk4B5ztIlwZUgbspV08BsqN3V7QhG3l56DWoZajjRiRBtxTOGI4XPp023zN6q9xEujJ7jHWKdO2wtoxWQGbbgxD4jaFs0glVeGFrDu7bTCCZc+UyEDgi9+MIki2K3UyexEYxwUJko8tKkV+iPP9aazQlnqxeKCGUh0PFhCDV37nzLUEhetzvCT129+nUFqTSJ6EuslxmOCGV67I42U+g4V6xYKaPCHkuWLGGoEaBI92oiE6pwPxChbD+GlnNmzzXMadx+9KA+aN2qpbHM0YtOVtYZ6ggHsViBBFtDp567XX4QHnqx1apVEw4g6kW9UoWJ0A5lEbdr1y7xpQpeLCF+DJgFTRTBj1j1qIx24UV3+qG6IUJ5b7D7wpByk7CdxAw1hsHwKZeUI4lyCQzQI8DyqvLiLyWlUkxJxS0RyrZCZ7hp42bauGkTbd60RbxMh4wJFwyp8gp/dNjaAO0sX768McyPtMcg67M7Qu+FdkspUyb6HpMsSx6h54QaA4J7iHZVE8rCDP/atX8a3mGA4zHx3PGjz5MnLxUqXIjOExYJUHE46RBl22JxTE9PNyZjtm3bTvjbsWOHGBKn08mMk+K9SxYTWQWF27jixnAZw2ZM1oRSBXltE2wc1cm+UO+S17IxgssQ9yEllr+PbN2zRN6Qn45eiDA778srEWZnW7luRiC7EWAi9PgEmAg9AsbJGQEfIMBE6PEhMRF6BIyTMwI+QICJ0ONDYiL0CBgnZwR8gAAToceHxEToETBOzgj4AAEmQo8PiYnQI2CcnBHwAQJMhB4fEhOhR8A4OSPgAwSYCD0+JCZCj4BxckbABwgwEXp8SEyEHgHj5IyADxBgIvT4kJgIPQLGyRkBHyDAROjxITERegSMkzMCPkCAidDjQ2Ii9AgYJ2cEfIAAE6HHh8RE6BEwTs4I+AABJkIfPCRuIiPACMQXASbC+OLLpTMCjIAPEGAi9MFD4iYyAoxAfBFgIowvvlw6I8AI+AABJkIfPCRuIiPACMQXASbC+OLLpTMCjIAPEGAi9MFD4iYyAoxAfBFgIowvvlw6I8AI+AABJkIfPCRuIiPACMQXASbC+OLLpTMCjIAPEGAi9MFD4iYyAoxAfBFgIowvvlw6I8AI+AABJkIfPCRuIiPACMQXASbC+OLLpTMCjIAPEGAi9MFD4iYyAoxAfBFgIowvvlw6I8AI+AABJkIfPCRuIiPACMQXASbC+OLLpTMCjIAPEGAi9MFD4iYyAoxAfBFgIowvvlw6I8AI+AABJkIfPCRuIiPACMQXASbC+OLLpTMCjIAPEGAi9MFD4iYyAoxAfBFgIowvvlw6I8AI+ACB/wProHKlYQjK0QAAAABJRU5ErkJggg==';

                    if (base64Img) {
                        doc.addImage(base64Img, 'JPEG', 170, 5, 26, 20);
//                        doc.addImage(base64Img, 'JPEG', data.settings.margin.left, 15, 10, 10);
                    }

                    doc.setFontSize(32);
                    doc.setTextColor(0,135,82);
                    doc.text("Preliminary Financial Analysis", data.settings.margin.left, 18);
                },
                styles: {
                    lineWidth: 0.001
                },
                headStyles: {
                    fillColor: "#6CB33F",
                    lineColor: "#597D39",
                    valign: "middle"
                },
                alternateRowStyles: {
                    fillColor: "#ffffff",
                    valign: "middle"
                },
                bodyStyles: {
                    lineColor: "#959996",
                    fontStyle: "normal",
                    fillColor: "#F1F7E8",
                    valign: "middle",
                    textColor: "#706f73"
                }
            };

            const incomesTableSettings = {
                ...commonSettings,
                ...{
                    startY: 40,
                    html: "#incomes-table",
                    didParseCell: function (data) {
                        var rows = data.table.body;
                        if (data.row.index === rows.length - 1) {
                            data.cell.styles.fontStyle = "bold";
                        }
                    }
                }
            };

            doc.setTextColor(112,111,115);
            doc.text("Income",15,35);
            autoTable(doc, incomesTableSettings);
            let finalY = doc.previousAutoTable.finalY;

            const expensesTableSettings = {
                ...commonSettings,
                ...{
                    startY: finalY + 20,
                    margin: { top: 30, bottom:30 },
                    html: "#expenses-table",
                    didParseCell: function (data) {
                        var rows = data.table.body;
                        if (data.row.index === rows.length - 1) {
                            data.cell.styles.fontStyle = "bold";
                        }
                    }
                }
            };

            doc.setTextColor(112,111,115);
            doc.text("Expenses", 15, finalY + 15);
            autoTable(doc, expensesTableSettings);
            finalY = doc.previousAutoTable.finalY;

            const debtsTableSettings = {
                ...commonSettings,
                ...{
                    startY: finalY + 20,
                    margin: { top: 30, bottom:30 },
                    html: "#debts-table",
                    didParseCell: function (data) {
                        var rows = data.table.body;
                        if (data.row.index === rows.length - 1) {
                            data.cell.styles.fontStyle = "bold";
                        }
                    }
                }
            };

            doc.setTextColor(112,111,115);
            doc.text("Debts", 15, finalY + 15);
            autoTable(doc, debtsTableSettings);
            finalY = doc.previousAutoTable.finalY;

            addFooters(doc);
            doc.save("summary-report.pdf");
        },
        checkIfBankruptcyTimerFinished() {
            if (this.submission.submission_type === "Bankruptcy") {
                let time = localStorage.getItem(
                    "bankruptcy-timer-ms-remaining"
                );

                if (time && Number(time) === 0) {
                    return true;
                }

                return false;
            } else {
                return true;
            }
        },
        checkIfRequiredStepsCompleted() {
            if (this.submission.accept_statement_of_counseling) {
                this.$store.dispatch("steps/completeStep", {
                    name: this.$route.name,
                    steps: this.steps
                });

                // Update the list of completed+required+enabled steps
                this.$store.dispatch(
                    "steps/updateCompletedRequiredEnabledSteps",
                    this.$store.state.steps.steps
                );
                this.$store.dispatch(
                    "steps/updateIncompleteRequiredEnabledSteps",
                    this.$store.state.steps.steps
                );

                // Update progress %
                this.$store.dispatch(
                    "steps/updateStepsProgress",
                    this.$store.state.steps
                );

                // Accepted statement and timer completed
                if (this.checkIfBankruptcyTimerFinished() === true) {
                    // Check if completely done
                    if (this.progress >= 100) {

                        // Go to the 100% completion screen
                        this.$store.dispatch("steps/goToNextStep", {
                            next_step: this.next_step
                        });
                    }
                } else {
                    // Accepted statement but timer is not finished
                    this.message =
                        "You must wait for the countdown to complete before proceeding";
                }
            } else {
                if (this.checkIfBankruptcyTimerFinished() === true) {
                    // Timer is finished, but statement not accepted
                    this.message =
                        "You must accept the statement of counseling before proceeding";
                } else {
                    // Neither are finished
                    this.message =
                        "You must accept the statement of counseling and wait for the countdown to complete before proceeding";
                }
            }
        },

        buildICMPayload() {
            let payload = {};
            let applicant = {};
            let coApplicant = {};
            applicant["FirstName"] = this.submission.first_name;
            applicant["LastName"] = this.submission.last_name;
            applicant["PhoneNumber"] = this.submission.phone;
            applicant["EmailAddress"] = this.submission.user.email;
            if (this.submission.state) {
                if (this.submission.address_line_2) {
                    applicant["StreetAddress"] =
                        this.submission.address_line_1 +
                        " " +
                        this.submission.address_line_2;
                }
                else {
                    applicant["StreetAddress"] =
                        this.submission.address_line_1;
                }
                applicant["City"] = this.submission.city;
                applicant["State"] = this.submission.state;
                applicant["ZipCode"] = this.submission.zip;
            } else {
                applicant["StreetAddress"] = "Unknown Address";
                applicant["City"] = "Unknown City";
                applicant["State"] = "OH";
                applicant["ZipCode"] = "43230";
            }

            if (this.submission.date_of_birth)
                applicant["DateOfBirth"] = this.submission.date_of_birth;
            else
                applicant["DateOfBirth"] = "01/01/1900";

            if (this.submission.ssn)
                applicant["SocialSecurityNumber"] = this.submission.ssn.replace(/(\d{3})(\d{2})(\d{4})/, "$1-$2-$3");

            if (this.submission.military)
                applicant["IsMilitary"] = 1;
            else
                applicant["IsMilitary"] = 0;

            if (this.submission.income_dependents)
                applicant["HouseholdCount"] = this.submission.income_dependents;
            else
                applicant["HouseholdCount"] = 1;

            if (this.submission.message)
                applicant["ClientComments"] = "Submission Reason: " + this.submission.reason + " Client Comments: " + this.submission.message;
            else
                applicant["ClientComments"] = "Submission Reason: " + this.submission.reason + " Client Comments: None";

            applicant["CreditPull"] = this.submission.credit_pull;
            payload["Applicant"] = applicant;

            if (this.submission.joint_coapplicant == 1) {
                coApplicant[
                    "FirstName"
                ] = this.submission.co_applicant_first_name;
                coApplicant[
                    "LastName"
                ] = this.submission.co_applicant_last_name;
                coApplicant["PhoneNumber"] = this.submission.phone;

                if (this.submission.co_applicant_email)
                    coApplicant["EmailAddress"] = this.submission.co_applicant_email;
                else
                    coApplicant["EmailAddress"] = "none given";

                if (this.submission.co_applicant_address_line_2)
                    coApplicant["StreetAddress"] =
                        this.submission.co_applicant_address_line_1 +
                        this.submission.co_applicant_address_line_2;
                else
                    coApplicant["StreetAddress"] =
                        this.submission.co_applicant_address_line_1;

                coApplicant["City"] = this.submission.co_applicant_city;

                if (this.submission.co_applicant_state)
                    coApplicant["State"] = this.submission.co_applicant_state;
                else
                    coApplicant["State"] = this.submission.state;

                coApplicant["ZipCode"] = this.submission.co_applicant_zip;
                coApplicant[
                    "HouseholdCount"
                ] = this.submission.income_dependents;
                coApplicant["ClientComments"] = this.submission.message;
                coApplicant["PhoneNumber"] = this.submission.phone;

                if (this.submission.co_applicant_date_of_birth) {
                    coApplicant["DateOfBirth"] = this.submission.co_applicant_date_of_birth;
                }
                else {
                    coApplicant["DateOfBirth"] = "01/01/1900";
                }
                coApplicant["SocialSecurityNumber"] = this.submission.co_applicant_ssn.replace(/(\d{3})(\d{2})(\d{4})/, "$1-$2-$3");

                payload["CoApplicant"] = coApplicant;
            }

            //incomes
            let obj = {};
            let icm_incomes = [];
            let incomeType = null;
            if (this.submission.gross_employment_income && this.submission.gross_employment_income > 0) {
                obj = {};
                obj["Detail"] = "Employment Income";
                obj["NetIncome"] = this.submission.net_employment_income;
                obj["GrossIncome"] = this.submission.gross_employment_income;

                //find swagger api type and detail
                incomeType = this.income_types.find(function(income) {
                    return income.income_type === obj["Detail"];
                });
                if (incomeType) {
                    if (incomeType.swagger_api_type)
                        obj["Type"] = incomeType.swagger_api_type;
                    if (incomeType.swagger_api_detail)
                        obj["Detail"] = incomeType.swagger_api_detail;
                }
                icm_incomes.push(obj);
            }
            if (this.submission.benefits_income && this.submission.benefits_income > 0) {
                obj = {};
                obj["Detail"] = "Benefits Income";
                obj["NetIncome"] = this.submission.benefits_income;
                obj["GrossIncome"] = this.submission.benefits_income;

                //find swagger api type and detail
                incomeType = this.income_types.find(function(income) {
                    return income.income_type === obj["Detail"];
                });
                if (incomeType) {
                    if (incomeType.swagger_api_type)
                        obj["Type"] = incomeType.swagger_api_type;
                    if (incomeType.swagger_api_detail)
                        obj["Detail"] = incomeType.swagger_api_detail;
                }
                icm_incomes.push(obj);
            }
            if (this.submission.retirement_income && this.submission.retirement_income > 0) {
                obj = {};
                obj["Detail"] = "Retirement Income";
                obj["NetIncome"] = this.submission.retirement_income;
                obj["GrossIncome"] = this.submission.retirement_income;

                //find swagger api type and detail
                incomeType = this.income_types.find(function(income) {
                    return income.income_type === obj["Detail"];
                });
                if (incomeType) {
                    if (incomeType.swagger_api_type)
                        obj["Type"] = incomeType.swagger_api_type;
                    if (incomeType.swagger_api_detail)
                        obj["Detail"] = incomeType.swagger_api_detail;
                }
                icm_incomes.push(obj);
            }
            if (this.submission.social_security_income && this.submission.social_security_income > 0) {
                obj = {};
                obj["Detail"] = "Social Security Income";
                obj["NetIncome"] = this.submission.social_security_income;
                obj["GrossIncome"] = this.submission.social_security_income;

                //find swagger api type and detail
                incomeType = this.income_types.find(function(income) {
                    return income.income_type === obj["Detail"];
                });
                if (incomeType) {
                    if (incomeType.swagger_api_type)
                        obj["Type"] = incomeType.swagger_api_type;
                    if (incomeType.swagger_api_detail)
                        obj["Detail"] = incomeType.swagger_api_detail;
                }
                icm_incomes.push(obj);
            }
            if (this.submission.pension_income && this.submission.pension_income > 0) {
                obj = {};
                obj["Detail"] = "Pension Income";
                obj["NetIncome"] = this.submission.pension_income;
                obj["GrossIncome"] = this.submission.pension_income;

                //find swagger api type and detail
                incomeType = this.income_types.find(function(income) {
                    return income.income_type === obj["Detail"];
                });
                if (incomeType) {
                    if (incomeType.swagger_api_type)
                        obj["Type"] = incomeType.swagger_api_type;
                    if (incomeType.swagger_api_detail)
                        obj["Detail"] = incomeType.swagger_api_detail;
                }
                icm_incomes.push(obj);
            }
            if (this.submission.self_employment_income && this.submission.self_employment_income > 0) {
                obj = {};
                obj["Detail"] = "Self-Employment Income";
                obj["NetIncome"] = this.submission.self_employment_income;
                obj["GrossIncome"] = this.submission.self_employment_income;

                //find swagger api type and detail
                incomeType = this.income_types.find(function(income) {
                    return income.income_type === obj["Detail"];
                });
                if (incomeType) {
                    if (incomeType.swagger_api_type)
                        obj["Type"] = incomeType.swagger_api_type;
                    if (incomeType.swagger_api_detail)
                        obj["Detail"] = incomeType.swagger_api_detail;
                }
                icm_incomes.push(obj);
            }
            if (this.submission.other_income && this.submission.other_income > 0) {
                obj = {};
                obj["Detail"] = "Other Income";
                obj["NetIncome"] = this.submission.other_income;
                obj["GrossIncome"] = this.submission.other_income;

                //find swagger api type and detail
                incomeType = this.income_types.find(function(income) {
                    return income.income_type === obj["Detail"];
                });
                if (incomeType) {
                    if (incomeType.swagger_api_type)
                        obj["Type"] = incomeType.swagger_api_type;
                    if (incomeType.swagger_api_detail)
                        obj["Detail"] = incomeType.swagger_api_detail;
                }
                icm_incomes.push(obj);
            }
            payload["Incomes"] = icm_incomes;

            let icm_expenses = [];
            console.log("expenses");
            for (let i = 0; i < this.expenses.length; i++) {
                obj = {};
                //don't pass expenses <= 0
                if (this.expenses[i].expense_value <= 0)
                    continue;
                obj["MonthlyPayment"] = this.expenses[i].expense_value;
                if (this.expenses[i].expense_type.swagger_api_type)
                    obj["Type"] = this.expenses[
                        i
                    ].expense_type.swagger_api_type;
                if (this.expenses[i].expense_type.swagger_api_detail)
                    obj["Detail"] = this.expenses[
                        i
                    ].expense_type.swagger_api_detail;
                else
                    obj["Detail"] = " ";

                //check to see if obj allready exists in arr and if so combine
                let index = icm_expenses.findIndex(x => x.Type === obj["Type"]);
                if (index > -1) {
                    console.log("found dup at " + index);
                    icm_expenses[index].MonthlyPayment += obj['MonthlyPayment'];
                }
                else {
                    icm_expenses.push(obj);
                }
            }
            payload["Expenses"] = icm_expenses;

            let icm_debts = [];
            let icm_liabs = [];
            let accounts = [];

            if (typeof this.credit_accounts == "object")
                accounts = Object.values(this.credit_accounts);
            else
                accounts = this.credit_accounts;

            if (accounts.length <= 0) {
                obj = {};
                obj["Type"] = "Credit Card";
                obj["MonthlyPayment"] = 1.00;
                obj["Balance"] = 1.00;
                obj["CreditorName"] = "No Debts Entered";
                obj["AccountNumber"] = "No Account Number Entered"
                obj["DebtType"] = "No Debts Entered - Credit Cards";
                icm_debts.push(obj);
                payload["Debts"] = icm_debts;
            }

            for (let i = 0; i < accounts.length; i++) {
                obj = {};

                //find swagger api type and detail
                let findDebtType = accounts[i].debt_type;
                let item = this.credit_account_debt_types.find(function(ct) {
                    return ct.debt_type === findDebtType;
                });

                if (item && accounts[i].balance_owed > 0) {
                    if (item.swagger_api_type)
                        obj["Type"] = item.swagger_api_type;
                    if (item.swagger_api_detail)
                        obj["Detail"] = item.swagger_api_detail;
                    else obj["Detail"] = "Personal Loan";

                    //api can't handle zero amt
                    if (accounts[i].monthly_payment > 0)
                        obj["MonthlyPayment"] = accounts[i].monthly_payment;
                    else
                        obj["MonthlyPayment"] = 1.00;

                    obj["Balance"] = accounts[i].balance_owed;
                    obj["DebtType"] = accounts[i].debt_type;

                    if (accounts[i].account_number)
                        obj["AccountNumber"] = accounts[i].account_number;
                    else
                        obj["AccountNumber"] = "UATV";

                    if (accounts[i].interest_rate) {
                        if (isNaN(accounts[i].interest_rate)) {
                            if(this.submission.credit_pull) {
                                obj["Apr"] = ".25";
                            }
                            else {
                                obj["Apr"] = accounts[i].interest_rate;
                            }
                        }
                        else {
                            obj["Apr"] = accounts[i].interest_rate / 100;
                        }
                    }
                    else {
                        if(this.submission.credit_pull) {
                            obj["Apr"] = .25;
                        }
                        else {
                            obj["Apr"] = "";
                        }
                    }

                    if (accounts[i].past_due)
                        obj["MonthsDelinquent"] = 1;
                    else
                        obj["MonthsDelinquent"] = 0;

                    if (item.swagger_api_category == "Debts") {
                        obj["CreditorName"] = accounts[i].creditor;
                        //custom mapping requested by apprisen
                        obj["DebtType"] = accounts[i].creditor + " - " + accounts[i].debt_type;
                        icm_debts.push(obj);
                    } else {
                        let lender = "Unknown";
                        if (accounts[i].creditor) {
                            obj["LenderName"] = accounts[i].creditor;
                            lender = accounts[i].creditor;
                        }
                        else {
                            obj["LenderName"] = "Unknown";
                        }
                        //custom mapping requested by apprisen
                        obj["Detail"] = lender + " - " + accounts[i].debt_type;
                        icm_liabs.push(obj);
                    }
                }
            }
            payload["Debts"] = icm_debts;
            payload["Liabilities"] = icm_liabs;

            return payload;
            //return JSON.stringify(payload);
        },

        async onSubmit($event) {
            const isValid = await this.$refs.observer.validate();
            if (isValid) {
                //default to check for bankruptcy only
                if (this.submission.reason == "Bankruptcy") {
                    this.submission.accept_statement_of_counseling = 1;
                }
                this.submitInProgress = true;
                let ICM_payload = this.buildICMPayload();
                console.log("ICM payload");
                console.log(ICM_payload);

                await api.submissions
                    .postToSwagger({ id:this.submission.id, payload: ICM_payload })
                    .then(response => {
                        this.submitInProgress = false;
                        console.log("swagger api respsonse");
                        console.log(response);
                        if (response.data.IsSuccess) {
                            api.infusionsoft
                                .addCompletionTag({
                                    id: this.submission.id,
                                });
                            this.$store.dispatch(
                                "submissions/updateSubmission",
                                this.submission
                            );
                            this.checkIfRequiredStepsCompleted();
                        } else {
                            console.log("Swagger API Post Error");
                            console.log(response.data.Errors);
                            if (response.data.Errors.length)
                                this.message =
                                    "Submission error - " +
                                    response.data.Errors[0].Value;
                        }
                    })
                    .catch(error => {
                        this.submitInProgress = false;
                        console.log("Swagger API Post Error");
                        //console.log(response.data.Errors);
                        console.log(error);
                        this.message = "Submission error";
                    });

            }
        }
    },
    mounted() {
        if (this.submission.reason == "Bankruptcy") {
            this.isBankruptcy = true;
        }
        else {
            this.isBankruptcy = false;
        }

        const tooltip1 = document.getElementById("military-tooltip");
        const commonSettings = {
            allowHTML: true,
            offset: [-5, 15],

            delay: [null, 150],
            arrow: true
        };

        const tooltip1Settings = {
            content: `<div class="tooltip relative">

                Mark here if you, your spouse, dependents or parents are or have been in the military. We have funding to provide additional resources.
                <div class="tooltip__link cursor-pointer text-secondary weight-600 mt-2">Got It</div>
            </div>`,
            placement: "right-start"
        };

        tippy(tooltip1, {
            ...commonSettings,
            ...tooltip1Settings
        });
    }
};
</script>

<style>
.lds-ring-container {
  display: inline-block;
  position: absolute;
  right: 55%;
  top: 20%;
}
.lds-ring {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
}
.lds-ring div {
  box-sizing: border-box;
  display: block;
  position: absolute;
  width: 25px;
  height: 25px;
  border: 3px solid #fff;
  border-radius: 50%;
  animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
  border-color: #fff transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
  animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
  animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
  animation-delay: -0.15s;
}
@keyframes lds-ring {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
