import axios from "axios";

axios.defaults.headers.common["Authorization"] =
    "Bearer " + localStorage.getItem("jwt");

const client = axios.create({
    baseURL: "/api",
    withCredentials: true
});

export default {
    addCompletionTag(data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.post("infusionsoft-completion", data);
    },
    addClientTag(data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.post("infusionsoft-client", data);
    }
};
