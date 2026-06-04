import api from "./api";

export default {
  async getBills() {
    const response = await api.get("/bills");
    return response.data;
  },

  async getBillers() {
    const response = await api.get("/billers");

    return response.data;
  },

  async createBill(data) {
    const response = await api.post("/bills", data);

    return response.data;
  },

  async createBiller(data) {
    const response = await api.post("/billers", data);

    return response.data;
  },
  async toggleBill(id) {
    const response = await api.patch(`/bills/${id}/toggle`);

    return response.data;
  },

  async deleteBiller(id) {
    const response = await api.delete(`/billers/${id}`);

    return response.data;
  },
};
