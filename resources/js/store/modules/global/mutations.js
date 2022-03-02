const ALERT_UPDATED = (state, alert) => {
    state.alert = {
      visible: alert.visible,
      message: alert.message,
      type: alert.type
    }
    state.loading = false
  };
  
  const LOADING_UPDATED = (state, loading) => {
    state.loading = loading
  };
  
  const LOADING_COMPLETED = (state, loading) => {
    setTimeout(function(){ state.loading = false }, 500);
  };
  
  const RESET_STATE = state => {
    state.alert = {
      visible: false,
      message: null,
      type: null
    }
    state.loading = false
    state.category = null
  }
  
  export default {
    ALERT_UPDATED,
    LOADING_UPDATED,
    LOADING_COMPLETED,
    RESET_STATE
  };
  