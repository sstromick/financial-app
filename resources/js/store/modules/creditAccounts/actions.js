import api from "@/api";

const getCreditAccounts = context => {
    api.getUrl(context, "/api/credit-accounts", "CREDIT_ACCOUNTS_UPDATED");
};

const getCreditAccount = context => {
    api.getUrl(context, "/api/credit-account", "CREDIT_ACCOUNT_UPDATED");
};

const createCreditAccount = (context, payload) => {
    api.postUrl(
        context,
        "/api/credit-accounts",
        payload,
        "CREDIT_ACCOUNT_UPDATED"
    );
};

const updateCreditAccount = (context, payload) => {
    api.patchUrl(
        context,
        "/api/credit-accounts/" + payload.id,
        payload,
        "CREDIT_ACCOUNT_UPDATED"
    );
};

const getCreditAccountDebtTypes = context => {
    api.getUrl(
        context,
        "/api/credit-account-types",
        "CREDIT_ACCOUNT_DEBT_TYPES_UPDATED"
    );
};

const resetCreditAccount = context => {
    context.commit("RESET_CREDIT_ACCOUNT");
};

const deleteCreditAccount = (context, payload) => {
    api.deleteUrl(
        context,
        "/api/credit-accounts/" + payload.id,
        "CREDIT_ACCOUNT_DELETED"
    );
};

const creditPull = async (context, payload) => {
    return await api.postUrl(
        context,
        "/api/credit-pull",
        payload,
        "CREDIT_ACCOUNTS_UPDATED"
    );
};

export default {
    getCreditAccounts,
    getCreditAccount,
    createCreditAccount,
    updateCreditAccount,
    getCreditAccountDebtTypes,
    resetCreditAccount,
    deleteCreditAccount,
    creditPull
};
