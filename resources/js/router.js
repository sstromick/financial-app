import Vue from "vue";
import Router from "vue-router";
import api from "./api";

Vue.use(Router);

export default new Router({
    mode: "history",
    linkExactActiveClass: "is-active",
    // Scroll to top of page after each navigation
    scrollBehavior(to, from, savedPosition) {
        return {
            x: 0,
            y: 0
        };
    },
    // mode: 'abstract',
    routes: [
        {
            path: "/expenses/",
            name: "Expenses",
            component: () => import("@views/Steps/Expenses.vue")
        },
        {
            path: "/expenses/create",
            name: "ExpensesCreate",
            component: () => import("@views/Steps/ExpensesCreate.vue"),
            meta: {
                substep: true,
                parent: "Expenses"
            }
        },
        {
            path: "/submission/incomes",
            name: "SubmissionIncomes",
            component: () => import("@views/Steps/Incomes.vue")
        },
        {
            path: "/submission/custom-action-plan",
            name: "SubmissionCustomActionPlan",
            component: () => import("@views/Steps/CustomActionPlan.vue")
        },
        {
            path: "/submission/income-dependents",
            name: "SubmissionIncomeDependents",
            component: () => import("@views/Steps/IncomeDependents.vue")
        },

        {
            path: "/submission/reason",
            name: "SubmissionReason",
            component: () => import("@views/Steps/Reason.vue")
        },
        {
            path: "/submission/automatic-debts",
            name: "SubmissionAutomaticDebts",
            component: () => import("@views/Steps/AutomaticDebts.vue")
        },
        {
            path: "/submission/summary",
            name: "Summary",
            component: () => import("@views/Steps/Summary.vue")
        },
        {
            path: "/submission/manual-debts",
            name: "CreditAccountManualDebts",
            component: () => import("@views/Steps/ManualDebts.vue")
        },

        {
            path: "/submission/completed",
            name: "CompletedGeneralSubmission",
            component: () =>
                import("@views/Steps/CompletedGeneralSubmission.vue")
        },
        // Income Type-specific routes
        {
            path: "/submission/employment-income",
            name: "SubmissionEmploymentIncome",
            component: () =>
                import("@views/Steps/IncomeTypes/EmploymentIncome.vue"),
            meta: {
                substep: true,
                parent: "SubmissionIncomes"
            }
        },
        {
            path: "/submission/benefits-income",
            name: "SubmissionBenefitsIncome",
            component: () =>
                import("@views/Steps/IncomeTypes/BenefitsIncome.vue"),
            meta: {
                substep: true,
                parent: "SubmissionIncomes"
            }
        },
        {
            path: "/submission/self-employment-income",
            name: "SubmissionSelfEmploymentIncome",
            component: () =>
                import("@views/Steps/IncomeTypes/SelfEmploymentIncome.vue"),
            meta: {
                substep: true,
                parent: "SubmissionIncomes"
            }
        },
        {
            path: "/submission/retirement-income",
            name: "SubmissionRetirementIncome",
            component: () =>
                import("@views/Steps/IncomeTypes/RetirementIncome.vue"),
            meta: {
                substep: true,
                parent: "SubmissionIncomes"
            }
        },
        {
            path: "/submission/social-security-income",
            name: "SubmissionSocialSecurityIncome",
            component: () =>
                import("@views/Steps/IncomeTypes/SocialSecurityIncome.vue"),
            meta: {
                substep: true,
                parent: "SubmissionIncomes"
            }
        },
        {
            path: "/submission/pension-income",
            name: "SubmissionPensionIncome",
            component: () =>
                import("@views/Steps/IncomeTypes/PensionIncome.vue"),
            meta: {
                substep: true,
                parent: "SubmissionIncomes"
            }
        },
        {
            path: "/submission/other-income",
            name: "SubmissionOtherIncome",
            component: () => import("@views/Steps/IncomeTypes/OtherIncome.vue"),
            meta: {
                substep: true,
                parent: "SubmissionIncomes"
            }
        },
        // Bankruptcy-Specific Routes
        {
            path: "/submission/bankruptcy/welcome",
            name: "SubmissionBankruptcyWelcome",
            component: () => import("@views/Steps/Bankruptcy/Welcome.vue")
        },
        {
            path: "/submission/bankruptcy/income-threshold",
            name: "BankruptcyIncomeThreshold",
            component: () =>
                import("@views/Steps/Bankruptcy/IncomeThreshold.vue")
        },
        {
            path: "/submission/bankruptcy/under-threshold",
            name: "BankruptcyUnderThreshold",
            component: () =>
                import("@views/Steps/Bankruptcy/UnderThreshold.vue")
        },
        {
            path: "/submission/bankruptcy/over-threshold",
            name: "BankruptcyOverThreshold",
            component: () => import("@views/Steps/Bankruptcy/OverThreshold.vue")
        },
        {
            path: "/submission/bankruptcy/basics",
            name: "BankruptcyBasics",
            component: () => import("@views/Steps/Bankruptcy/Basics.vue")
        },
        {
            path: "/submission/bankruptcy/budgeting",
            name: "BankruptcyBudgetingBasics",
            component: () =>
                import("@views/Steps/Bankruptcy/BudgetingBasics.vue")
        },
        {
            path: "/submission/bankruptcy/resources",
            name: "BankruptcyNextStepsResources",
            component: () =>
                import("@views/Steps/Bankruptcy/NextStepsResources.vue")
        },
        {
            path: "/submission/bankruptcy/confirm-login",
            name: "BankruptcyConfirmLogin",
            component: () => import("@views/Steps/Bankruptcy/ConfirmLogin.vue")
        },
        {
            path: "/submission/bankruptcy/completed",
            name: "BankruptcyCompletedSubmission",
            component: () =>
                import("@views/Steps/Bankruptcy/CompletedSubmission.vue")
        },
        {
            path: "/404",
            name: "404",
            component: () => import("@views/Page/NotFound.vue")
        },
        {
            path: "*",
            component: () => import("@views/Steps/Reason.vue")
            //redirect: '/404',
        },
        {
            path: "/payment-approved",
            name: "PaymentApproved"
        },
        {
            path: "/privacy",
            name: "Privacy",
            component: () => import("@views/Page/Privacy.vue")
        },
        {
            path: "/counseling",
            name: "Counseling",
            component: () => import("@views/Page/Counseling.vue")
        },
        {
            path: "/404",
            name: "404",
            component: () => import("@views/Page/NotFound.vue")
        },
        {
            path: "/reset-password/:token",
            name: "ResetPasswordForm",
            component: () => import("@views/Page/ResetPassword.vue"),
            meta: {
                auth: false
            }
        }
    ]
});
