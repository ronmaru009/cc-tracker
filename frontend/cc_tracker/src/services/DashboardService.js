import api from "./api";

export default {
  async getDashboardData() {
    const response = await api.get("/dashboard");

    return response.data;
  },
};
