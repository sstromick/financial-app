import actions from "./actions";
import getters from "./getters";
import mutations from "./mutations";

const state = {
    user: {
        email: null,
        password: null,
        has_password: false,
        has_email: false,
        contact_id: null
    }
};

export default {
    namespaced: true,
    state,
    actions,
    getters,
    mutations
};
