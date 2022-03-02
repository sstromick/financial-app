import api from "@/api";

const getUser = context => {
    api.getUrl(context, "/api/user", "USER_UPDATED");
};

const createUser = (context, payload) => {
    api.postUrl(context, "/api/users", payload, "USER_UPDATED");
};

const loginUser = (context, payload) => {
    api.postUrl(context, "/login", payload, "USER_UPDATED");
};

const updateUser = (context, payload) => {
    api.patchUrl(context, "/api/users/" + payload.id, payload, "USER_UPDATED");
};

const resetUser = context => {
    context.commit("USER_RESET");
};

export default {
    getUser,
    createUser,
    updateUser,
    loginUser,
    resetUser
};
