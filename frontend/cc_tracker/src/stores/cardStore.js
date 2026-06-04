import { defineStore } from 'pinia'
import CreditCardService from '../services/CreditCardService'

export const useCardStore = defineStore('card', {

    state: () => ({
        cards: [],
        loading: false
    }),

    actions: {

        async fetchCards() {

            this.loading = true

            try {

                this.cards = await CreditCardService.getCards()

            } catch (error) {

                console.error('Failed to fetch cards:', error)

            } finally {

                this.loading = false
            }
        },

        async createCard(payload) {

            await CreditCardService.createCard(payload)

            await this.fetchCards()
        },

        async updateCard(id, payload) {

            await CreditCardService.updateCard(id, payload)

            await this.fetchCards()
        },

        async deleteCard(id) {

            await CreditCardService.deleteCard(id)  

            await this.fetchCards()
        }
    }

})