import api from '@/api';

const getStates = context => {
  api.getUrl(context, '/api/us-states', 'US_STATES_UPDATED');  
};




export default {
    getStates,
};