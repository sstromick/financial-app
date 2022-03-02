import Vue from 'vue';
import Vuex from 'vuex';

import usersModule from './modules/users';
import submissionsModule from './modules/submissions';
import globalModule from './modules/global';
import stepsModule from './modules/steps';
import incomesModule from './modules/incomes';
import expensesModule from './modules/expenses';
import creditAccountsModule from './modules/creditAccounts';
import filesModule from './modules/files';
import usStatesModule from './modules/usStates';
import paymentsModule from './modules/payments';

Vue.use(Vuex);

export default new Vuex.Store({
    state: () => ({

    }),
    modules: {
        users: usersModule,
        submissions: submissionsModule,
        global: globalModule,
        steps: stepsModule,
        incomes: incomesModule,
        expenses: expensesModule,
        credit_accounts: creditAccountsModule,
        files: filesModule,
        us_states: usStatesModule,
        payments: paymentsModule,
    }
});
