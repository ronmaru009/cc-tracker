import api from "./api";

export default {
  async getLoans() {
    const response = await api.get("/loans");

    return response.data;
  },

  async createLoan(data) {
    const response = await api.post("/loans", data);

    return response.data;
  },

  async toggleLoanPayment(id) {
    const response = await api.patch(`/loan-payments/${id}/toggle`);
    return response.data;
  },

  async updateLoanPayment(id, data) {
    const response = await api.patch(`/loan-payments/${id}`, data);

    return response.data;
  },
};
