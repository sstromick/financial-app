const expenses = state => state.expenses
const expense = state => state.expense
const expense_categories = state => state.expense_categories
const expense_types = state => state.expense_types
const enabled_expense_categories = state => state.enabled_expense_categories
const filtered_expense_types = state => state.filtered_expense_types
const filtered_expenses = state => state.filtered_expenses
const current_expense_category = state => state.current_expense_category
const filtered_expense_types_names = state => state.filtered_expense_types_names
const previous_expense_category = state => state.previous_expense_category
const next_expense_category = state => state.next_expense_category

export default {
    expenses,
    expense,
    expense_categories,
    expense_types,
    enabled_expense_categories,
    filtered_expense_types,
    filtered_expenses,
    current_expense_category,
    filtered_expense_types_names,
    previous_expense_category,
    next_expense_category
};
