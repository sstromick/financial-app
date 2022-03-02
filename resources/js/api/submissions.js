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
        return client.get("submissions", params);
    },
    find(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get(`submissions/${id}`);
    },
    update(id, data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.put(`submissions/${id}`, data);
    },
    delete(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.delete(`submissions/${id}`);
    },
    create(data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.post("submissions", data);
    },
    current() {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get("/submission");
    },
    postToSwagger(data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.post("submissions-swagger", data);
    }
};
