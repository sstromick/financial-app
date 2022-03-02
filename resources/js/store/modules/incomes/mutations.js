const INCOMES_UPDATED = (state, incomes) => {
  state.incomes = incomes;  
};


const INCOME_UPDATED = (state, income) => {
    state.income = income;  
};

const INCOME_TYPES_UPDATED = (state, income_types) => {
  state.income_types = income_types;  
};

export default {
    INCOMES_UPDATED,
    INCOME_UPDATED,
    INCOME_TYPES_UPDATED
};