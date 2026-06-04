import axios from "axios";
const API_URL = "http://127.0.0.1:8000/api";
const api = axios.create({
  baseURL: API_URL,
});

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
