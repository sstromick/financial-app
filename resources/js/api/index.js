import axios from "axios";
import users from "./users";
import submissions from "./submissions";
import expenses from "./expenses";
import creditAccounts from "./creditAccounts";
import info from "./info";
import files from "./files";
import payments from "./payments";
import infusionsoft from "./infusionsoft";

axios.defaults.headers.common["Authorization"] =
    "Bearer " + localStorage.getItem("jwt");

const client = axios.create();
/*
const client = axios.create({
    withCredentials: true
});
*/

import router from "../router";

export default {
    getUrl(context, url, type, payload, callbackOnSuccess, callbackOnFail) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");

        let params = {};

        if (payload) {
            params = {
                params: payload
            };
        }

        client
            .get(url, params)
            .then(response => {
                context.commit(type, response.data);
                if (context.rootState.global.loading) {
                    context.commit("global/LOADING_COMPLETED", true, {
                        root: true
                    });
                }

                if (typeof callbackOnSuccess === "function") {
                    callbackOnSuccess(response);
                }
            })
            .catch(error => {
                console.log("bad response");
                console.log(error.response.data);
                context.commit(
                    "global/ALERT_UPDATED",
                    {
                        visible: true,
                        message: error.response.data.error,
                        type: "error"
                    },
                    {
                        root: true
                    }
                );

                if (typeof callbackOnFail === "function") {
                    callbackOnFail(error);
                }
            });
    },

    postUrl(context, url, payload, type, redirect, alert, event) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        client
            .post(url, payload)
            .then(response => {
                if (type) {
                    context.commit(type, response.data.data);
                }
                if (redirect) {
                    if (redirect.params == "id") {
                        redirect.params = {
                            id: response.data.data.id
                        };
                    }
                    router.push({
                        name: redirect.name,
                        params: redirect.params
                    });
                }

                if (context.rootState.global.loading) {
                    context.commit("global/LOADING_COMPLETED", true, {
                        root: true
                    });
                }

                if (alert != false) {
                    context.commit(
                        "global/ALERT_UPDATED",
                        {
                            visible: true,
                            message: response.data.message,
                            type: "success"
                        },
                        {
                            root: true
                        }
                    );
                }
                if (event) axios.post("/events", event);
            })
            .catch(error => {
                if (error.response) {
                    context.commit(
                        "global/ALERT_UPDATED",
                        {
                            visible: true,
                            message: error.response.data.error,
                            type: "error"
                        },
                        {
                            root: true
                        }
                    );
                } else {
                    context.commit(
                        "global/ALERT_UPDATED",
                        {
                            visible: true,
                            message: ["Error: " + url + " - " + error],
                            type: "error"
                        },
                        {
                            root: true
                        }
                    );
                }
            });
    },

    patchUrl(context, url, payload, type, alert, event, alert_message) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");

        client
            .patch(url, payload)
            .then(response => {
                context.commit(type, response.data);
                if (alert != false) {
                    if (alert_message) {
                        context.commit(
                            "global/ALERT_UPDATED",
                            {
                                visible: true,
                                message: [alert_message],
                                type: "success"
                            },
                            {
                                root: true
                            }
                        );
                    } else {
                        context.commit(
                            "global/ALERT_UPDATED",
                            {
                                visible: true,
                                message: response.data.message,
                                type: "success"
                            },
                            {
                                root: true
                            }
                        );
                    }
                }
                if (context.rootState.global.loading) {
                    context.commit("global/LOADING_COMPLETED", true, {
                        root: true
                    });
                }
                if (event) axios.post("/events", event);
            })
            .catch(error => {
                context.commit(
                    "global/ALERT_UPDATED",
                    {
                        visible: true,
                        message: error.response.data.error,
                        type: "error"
                    },
                    {
                        root: true
                    }
                );
            });
    },

    deleteUrl(context, url, type, event) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        client
            .delete(url)
            .then(response => {
                context.commit(type, response.data.data);
                //   context.commit('global/ALERT_UPDATED', {visible: true, message: response.data.message, type: "success"}, {root: true});
                if (context.rootState.global.loading) {
                    // context.commit('global/LOADING_COMPLETED', true, { root: true })
                }
                if (event) axios.post("/events", event);
            })
            .catch(error => {
                context.commit(
                    "global/ALERT_UPDATED",
                    {
                        visible: true,
                        message: error.response.data.error,
                        type: "error"
                    },
                    {
                        root: true
                    }
                );
            });
    },
    users,
    submissions,
    expenses,
    creditAccounts,
    info,
    files,
    payments,
    infusionsoft
};
