const CREDIT_ACCOUNTS_UPDATED = (state, credit_accounts) => {
    state.credit_accounts = credit_accounts;
};

const CREDIT_ACCOUNT_UPDATED = (state, credit_account) => {
    if (credit_account) {
        state.credit_account = credit_account;
    } else {
        state.credit_account = {
            submission_id: null,
            debt_type: null,
            creditor: null,
            account_number: null,
            monthly_payment: null,
            interest_rate: null,
            balance_owed: null,
            past_due: null
        };
    }
};

const CREDIT_ACCOUNT_DEBT_TYPES_UPDATED = (state, types) => {
    state.credit_account_debt_types = types;
};

const RESET_CREDIT_ACCOUNT = state => {
    state.credit_account = {
        debt_type: null,
        creditor: null,
        account_number: null,
        monthly_payment: null,
        interest_rate: null,
        balance_owed: null,
        past_due: null
    };
};

const CREDIT_ACCOUNT_DELETED = (state, credit_account) => {
    state.credit_accounts = state.credit_accounts.filter(function(account) {
        return account.id != credit_account.id;
    });
};

export default {
    CREDIT_ACCOUNTS_UPDATED,
    CREDIT_ACCOUNT_UPDATED,
    CREDIT_ACCOUNT_DEBT_TYPES_UPDATED,
    RESET_CREDIT_ACCOUNT,
    CREDIT_ACCOUNT_DELETED
};
