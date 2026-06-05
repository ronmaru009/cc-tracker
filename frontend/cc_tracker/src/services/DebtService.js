import api from "./api";

export default {
  async getDebts() {
    return await api.get("/debts");
  },

  async createDebt(payload) {
    return await api.post("/debts", payload);
  },

  async updateDebt(id, payload) {
    return await api.put(`/debts/${id}`, payload);
  },

  async deleteDebt(id) {
    return await api.delete(`/debts/${id}`);
  },
};
