import axios from 'axios'

const API_URL =
    'http://127.0.0.1:8000/api/credit-cards'

async function getCards() {

    const response =
        await axios.get(API_URL)

    return response.data
}

async function getCard(id) {

    const response =
        await axios.get(`${API_URL}/${id}`)

    return response.data
}

async function createCard(data) {

    const response =
        await axios.post(API_URL, data)

    return response.data
}

async function updateCard(id, data) {

    const response =
        await axios.put(
            `${API_URL}/${id}`,
            data
        )

    return response.data
}

async function deleteCard(id) {

    await axios.delete(`${API_URL}/${id}`)
}

export default {

    getCards,

    getCard,

    createCard,

    updateCard,

    deleteCard
}