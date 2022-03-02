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
        return client.get("files", params);
    },
    find(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.get(`files/${id}`);
    },
    update(id, data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.put(`files/${id}`, data);
    },
    delete(id) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.delete(`files/${id}`);
    },
    create(data) {
        client.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.getItem("jwt");
        return client.post("files", data, {
            headers: {
                "Content-Type": "multipart/form-data"
            }
        });
    }
    //   updateOrCreate(id, data) {
    //       return client.post('files')
    //   }
};
