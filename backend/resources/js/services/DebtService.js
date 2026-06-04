import axios from 'axios'

const API_URL = '/api/debts'

export default {

    async getDebts() {
        return await axios.get(API_URL)
    },

    async createDebt(payload) {
        return await axios.post(API_URL, payload)
    }

}