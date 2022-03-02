const EXPENSES_UPDATED = (state, expenses) => {
    state.expenses = expenses;
};


const EXPENSE_UPDATED = (state, expense) => {
    if(expense) {
        state.expense = expense;
    } else {
        state.expense = {
            submission_id: null,
            expense_type: null,
            expense_value: null,
            expense_category: null,
        }
    }
};

const EXPENSE_CATEGORIES_UPDATED = (state, expense_categories) => {
    state.expense_categories = expense_categories;
};


const NEXT_EXPENSE_CATEGORY_UPDATED = (state, next_expense_category) => {
    state.next_expense_category = next_expense_category;
};

const PREVIOUS_EXPENSE_CATEGORY_UPDATED = (state, previous_expense_category) => {
    state.previous_expense_category = previous_expense_category;
};


const FILTERED_EXPENSE_TYPES_UPDATED = (state, filtered_expense_types) => {
  state.filtered_expense_types = filtered_expense_types;
};


const FILTERED_EXPENSE_TYPES_NAMES_UPDATED = (state, filtered_expense_types_names) => {
    state.filtered_expense_types_names = filtered_expense_types_names;
  };



const FILTERED_EXPENSES_UPDATED = (state, payload) => {
    state.filtered_expenses = payload;
}

const EXPENSE_TYPES_UPDATED = (state, expense_types) => {
    state.expense_types = expense_types;
};

const ENABLED_EXPENSE_CATEGORIES_UPDATED = (state, enabled_expense_categories) => {
  state.enabled_expense_categories = enabled_expense_categories;  
};


const CURRENT_EXPENSE_CATEGORY_UPDATED = (state, expense_category) => {
  state.current_expense_category = expense_category;  
};


const EXPENSE_DELETED = (state, expense) => {
    state.expenses = state.expenses.filter(function(account) { return account.id != expense.id});
}

export default {
    EXPENSES_UPDATED,
    EXPENSE_UPDATED,
    EXPENSE_CATEGORIES_UPDATED,
    EXPENSE_TYPES_UPDATED,
    ENABLED_EXPENSE_CATEGORIES_UPDATED,
    FILTERED_EXPENSE_TYPES_UPDATED,
    FILTERED_EXPENSES_UPDATED,
    CURRENT_EXPENSE_CATEGORY_UPDATED,
    FILTERED_EXPENSE_TYPES_NAMES_UPDATED,
    NEXT_EXPENSE_CATEGORY_UPDATED,
    PREVIOUS_EXPENSE_CATEGORY_UPDATED,
    EXPENSE_DELETED
};
