import axios from 'axios'

const API_URL = 'http://127.0.0.1:8000/api/debts'

export default {

    async getDebts() {
        return await axios.get(API_URL)
    },

    async createDebt(payload) {
        return await axios.post(API_URL, payload)
    },

    async updateDebt(id, payload) {
        return axios.put(`${API_URL}/${id}`, payload)
    },

    async deleteDebt(id) {
        return axios.delete(`${API_URL}/${id}`)
    }


}