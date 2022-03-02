import api from '@/api';

const getPayments = context => {
  api.getUrl(context, '/api/payments', 'PAYMENTS_UPDATED');  
};

const getPayment = context => {
    api.getUrl(context, '/api/payment', 'PAYMENT_UPDATED');
}

const createPayment = (context, payload) => {
  api.postUrl(context, '/api/payments', payload, 'PAYMENT_UPDATED');  
};

const updatePayment = (context, payload) => {
    api.patchUrl(context, '/api/payments/' + payload.id, payload, 'PAYMENT_UPDATED');
}

export default {
    getPayments,
    getPayment,
    createPayment,
    updatePayment
};