import axios from "axios";

export function completeMilestone(id) {
    let milestone = document.getElementById(id);
    if (milestone) {
        milestone.classList.add("milestone--completed");
    }
}

export function checkMilestoneProgress() {
    axios.get("/api/user").then(response => {
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
                submission.address_Line_1 &&
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
    });
}

export default {
    methods: {
        completeMilestone,
        checkMilestoneProgress
    }
};
