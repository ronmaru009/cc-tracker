import api from "./api";

async function getCards() {
  const response = await api.get("/credit-cards");

  return response.data;
}

async function getCard(id) {
  const response = await api.get(`/credit-cards/${id}`);

  return response.data;
}

async function createCard(data) {
  const response = await api.post("/credit-cards", data);

  return response.data;
}

async function updateCard(id, data) {
  const response = await api.put(`/credit-cards/${id}`, data);

  return response.data;
}

async function deleteCard(id) {
  await api.delete(`/credit-cards/${id}`);
}

export default {
  getCards,

  getCard,

  createCard,

  updateCard,

  deleteCard,
};
