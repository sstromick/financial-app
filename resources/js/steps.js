export const steps = [
    {
        name: "SubmissionReason",
        enabled: true,
        completed: false,
        required: true
    },
    {
        name: "SubmissionCustomActionPlan",
        enabled: true,
        completed: false,
        required: true
    },
    {
        name: "SubmissionBankruptcyWelcome",
        enabled: false,
        completed: false,
        required: true
    },
    {
        name: "BankruptcyIncomeThreshold",
        enabled: false,
        completed: false,
        required: false
    },
    {
        name: "BankruptcyUnderThreshold",
        enabled: false,
        completed: false,
        required: false
    },
    {
        name: "BankruptcyOverThreshold",
        enabled: false,
        completed: false,
        required: false
    },
    {
        name: "BankruptcyBasics",
        enabled: false,
        completed: false,
        required: false
    },
    {
        name: "SubmissionIncomeDependents",
        enabled: true,
        completed: false,
        required: false
    },
    {
        name: "SubmissionIncomes",
        enabled: true,
        required: false,
        completed: false
    },
    {
        name: "SubmissionEmploymentIncome",
        enabled: false,
        parent: "SubmissionIncomes",
        required: false,
        completed: false
    },
    {
        name: "SubmissionBenefitsIncome",
        enabled: false,
        parent: "SubmissionIncomes",
        required: false,
        completed: false
    },
    {
        name: "SubmissionSocialSecurityIncome",
        enabled: false,
        parent: "SubmissionIncomes",
        required: false,
        completed: false
    },
    {
        name: "SubmissionSelfEmploymentIncome",
        enabled: false,
        parent: "SubmissionIncomes",
        required: false,
        completed: false
    },
    {
        name: "SubmissionRetirementIncome",
        enabled: false,
        parent: "SubmissionIncomes",
        required: false,
        completed: false
    },
    {
        name: "SubmissionPensionIncome",
        enabled: false,
        parent: "SubmissionIncomes",
        required: false,
        completed: false
    },
    {
        name: "SubmissionOtherIncome",
        enabled: false,
        parent: "SubmissionIncomes",
        required: false,
        completed: false
    },
    {
        name: "BankruptcyBudgetingBasics",
        enabled: false,
        completed: false,
        required: false
    },
    {
        name: "SubmissionAutomaticDebts",
        enabled: true,
        completed: false,
        required: false
    },

    {
        name: "CreditAccountManualDebts",
        enabled: true,
        completed: false,
        required: false
    },

    {
        name: "Expenses",
        enabled: true,
        completed: false,
        required: false,
        parent: true
    },

    {
        name: "ExpensesCreate",
        enabled: true,
        completed: false,
        required: false,
        parent: true
    },
    {
        name: "BankruptcyNextStepsResources",
        enabled: false,
        completed: false,
        required: false
    },
    {
        name: "BankruptcyConfirmLogin",
        enabled: false,
        completed: false,
        required: false
    },
    {
        name: "Summary",
        enabled: true,
        completed: false,
        required: true
    },
    {
        name: "CompletedGeneralSubmission",
        enabled: true,
        completed: false,
        required: false
    },
    {
        name: "BankruptcyCompletedSubmission",
        enabled: true,
        completed: false,
        required: false
    }
];
