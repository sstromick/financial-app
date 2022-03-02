import api from "@/api";

const getExpenses = context => {
    api.getUrl(context, "/api/expenses", "EXPENSES_UPDATED");
};

const getExpense = (context, payload) => {
    api.getUrl(context, "/api/expenses/" + payload.id, "EXPENSE_UPDATED");
};

const createExpense = (context, payload) => {
    api.postUrl(context, "/api/expenses", payload, "EXPENSE_UPDATED");
};

const updateExpense = (context, payload) => {
    api.patchUrl(
        context,
        "/api/expenses/" + payload.id,
        payload,
        "EXPENSE_UPDATED"
    );
};

const getExpenseCategories = context => {
    api.getUrl(
        context,
        "/api/expense-categories",
        "EXPENSE_CATEGORIES_UPDATED"
    );
};

const getAllExpenseTypes = context => {
    api.getUrl(context, "/api/expense-types", "EXPENSE_TYPES_UPDATED");
};

const updateRelativeExpenseCategories = (context, payload) => {
    if (
        payload.enabled_expense_categories &&
        payload.enabled_expense_categories.length > 0
    ) {
        const index = payload.enabled_expense_categories.findIndex(
            value => value.id === payload.current_expense_category.id
        );

        if (index >= 0) {
            context.commit(
                "CURRENT_EXPENSE_CATEGORY_UPDATED",
                payload.current_expense_category || null
            );
            context.commit(
                "NEXT_EXPENSE_CATEGORY_UPDATED",
                payload.enabled_expense_categories[index + 1] || null
            );
            context.commit(
                "PREVIOUS_EXPENSE_CATEGORY_UPDATED",
                payload.enabled_expense_categories[index - 1] || null
            );
        }
    }
};

const updateCurrentExpenseCategory = (context, payload) => {
    context.commit("CURRENT_EXPENSE_CATEGORY_UPDATED", payload);
};

const updateNextExpenseCategory = (context, payload) => {
    context.commit("NEXT_EXPENSE_CATEGORY_UPDATED", payload);
};

const updatePreviousExpenseCategory = (context, payload) => {
    context.commit("PREVIOUS_EXPENSE_CATEGORY_UPDATED", payload);
};

// Expenses for a specific category
const updateFilteredExpenses = (context, payload) => {
    api.expenses
        .all()
        .then(response => {
            let filtered_expense_types = payload.filtered_expense_types;

            // Just an array of strings
            let filtered_expense_types_names = filtered_expense_types.map(
                a => a.expense_type
            );

            let expenses = response.data;

            let filtered_expenses = expenses.filter(obj => {
                return filtered_expense_types.some(fe => {
                    return (
                        fe.expense_type == obj.expense_type.expense_type &&
                        fe.category_id == obj.expense_type.category_id
                    );
                });
            });

            context.commit("FILTERED_EXPENSES_UPDATED", filtered_expenses);
        })
        .catch(error => {
            console.log("error");
            console.log(error);
        });
};

// Expense types for a specific category
const updateFilteredExpenseTypes = (context, payload) => {
    context.commit("FILTERED_EXPENSE_TYPES_UPDATED", payload);

    // Just an array of the expense_type names
    let filtered_expense_types_names = payload.map(a => a.expense_type);
    context.commit(
        "FILTERED_EXPENSE_TYPES_NAMES_UPDATED",
        filtered_expense_types_names
    );
};

const updateEnabledExpenseCategories = (context, payload) => {
    context.commit("ENABLED_EXPENSE_CATEGORIES_UPDATED", payload);
};

const deleteExpense = (context, payload) => {
    api.deleteUrl(context, "/api/expenses/" + payload.id, "EXPENSE_DELETED");
};

export default {
    getExpenses,
    getExpense,
    createExpense,
    updateExpense,
    getExpenseCategories,
    getAllExpenseTypes,
    updateFilteredExpenseTypes,
    updateEnabledExpenseCategories,
    updateFilteredExpenses,
    updateCurrentExpenseCategory,
    updateNextExpenseCategory,
    updatePreviousExpenseCategory,
    updateRelativeExpenseCategories,
    deleteExpense
};
