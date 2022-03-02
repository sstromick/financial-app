import axios from "axios";

axios.defaults.headers.common["Authorization"] =
    "Bearer " + localStorage.getItem("jwt");

const client = axios.create({
    baseURL: "/api"
});
/*
const client = axios.create({
    baseURL: "/api",
    withCredentials: true
});
*/

export default {
    all(params) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("users", params);
    },
    find(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get(`users/${id}`);
    },
    update(id, data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.put(`users/${id}`, data);
    },
    delete(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.delete(`users/${id}`);
    },
    create(data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.post("users", data);
    },
    // Get the current user
    current() {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("user");
    },
    // Get the submission for the current user
    submission() {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("user/submission");
    },
    info() {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("user/info");
    },
    login(data) {
        return axios.post("/login", data);
    },
    verifyLogin(data) {
        return axios.post("/user/verify-login", data);
    },
    loginWithoutReload(data) {
        return axios.post("/user/login-without-reload", data);
    },
    logout() {
        return axios.post("/user/logout");
    },
    login2(data) {
        return axios.post("/user/login", data);
    }
};
