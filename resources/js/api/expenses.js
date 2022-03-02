import axios from "axios";

axios.defaults.headers.common["Authorization"] =
    "Bearer " + localStorage.getItem("jwt");

const client = axios.create({
    baseURL: "/api",
    withCredentials: true
});

export default {
    all(params) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("expenses", params);
    },
    find(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get(`expenses/${id}`);
    },
    update(id, data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.put(`expenses/${id}`, data);
    },
    delete(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.delete(`expenses/${id}`);
    },
    create(data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.post("expenses", data);
    },
    categories() {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("expense-categories");
    },
    types() {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("expense-types");
    }
};
