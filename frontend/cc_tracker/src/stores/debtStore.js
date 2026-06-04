import { defineStore } from 'pinia'
import DebtService from '../services/DebtService'

export const useDebtStore = defineStore('debt', {

    state: () => ({
        debts: []
    }),

    getters: {

        totalDebt(state) {
            return state.debts.reduce((sum, debt) => {
                return sum + Number(debt.balance)
            }, 0)
        },

        snowballDebts(state) {
            return [...state.debts].sort((a, b) => {
                return Number(a.balance) - Number(b.balance)
            })
        }

    },

    actions: {

        async fetchDebts() {

            const response = await DebtService.getDebts()

            this.debts = response.data
        },

        async createDebt(payload) {

            await DebtService.createDebt(payload)

            await this.fetchDebts()
        },

        async updateDebt(id, payload) {

            await DebtService.updateDebt(id, payload)

            await this.fetchDebts()
        },

        async deleteDebt(id) {

            await DebtService.deleteDebt(id)

            await this.fetchDebts()
        }

    }

})