// const USERS_UPDATED = (state, users) => {
//   state.users = users;
// };

const USER_UPDATED = (state, user) => {
    if (user.data) {
        state.user = user.data;
    } else {
        state.user = user;
    }
};

const USER_RESET = state => {
    state.user = null;
};

export default {
    // USERS_UPDATED,
    USER_UPDATED,
    USER_RESET
};
