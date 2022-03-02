import api from '@/api';

const getIncomes = context => {
  api.getUrl(context, '/api/incomes', 'INCOMES_UPDATED');  
};


const getIncome = context => {
    api.getUrl(context, '/api/incomes/:id', 'INCOME_UPDATED');
};

const createIncome = (context, payload) => {
  api.postUrl(context, '/api/incomes', payload, 'INCOME_UPDATED');
};

const updateIncome = (context, payload) => {
    api.patchUrl(context, '/api/incomes/' + payload.id, payload, 'INCOME_UPDATED');
};

const getIncomeTypes = context => {
  api.getUrl(context, '/api/income-types', 'INCOME_TYPES_UPDATED');  
};

export default {
    getIncomes,
    getIncome,
    createIncome,
    updateIncome,
    getIncomeTypes,
};