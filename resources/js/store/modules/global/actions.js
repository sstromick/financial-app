const updateLoading = (context, loading) => {
    context.commit('LOADING_UPDATED', loading)
  }
  
  const updateAlert = (context, alert) => {
    context.commit('ALERT_UPDATED', alert)
  }
  
  const resetObjects = context => {
    context.commit('RESET_STATE');
  }
  
  export default {
    updateLoading,
    resetObjects,
    updateAlert
  };
  